<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Favorite;
use Illuminate\Http\Request;
use App\Models\SearchHistory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductController extends Controller
{

    private function translateToEnglish($text)
    {
        $apiKey = env('GOOGLE_TRANSLATE_API_KEY');
        $url = "https://translation.googleapis.com/language/translate/v2?key={$apiKey}";

        $data = [
            'q' => $text,
            'target' => 'en'
        ];

        $options = [
            'http' => [
                'header'  => "Content-Type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data),
            ],
        ];

        $context  = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $result = json_decode($response, true);

        return $result['data']['translations'][0]['translatedText'] ?? $text; // Fallback to original if translation fails
    }

    public function translateProduct(Request $request)
    {
        $productName = $request->input('product_name');
        $ingredientsText = $request->input('ingredients_text');

        // Translate product name
        $translatedFoodName = $this->translateToEnglish($productName);
    
        // Translate ingredients text if it's not empty
        $translatedIngredientsText = !empty($ingredientsText) ? $this->translateToEnglish($ingredientsText) : '';

        return response()->json([
            'translatedFoodName' => $translatedFoodName,
            'translatedIngredientsText' => $translatedIngredientsText,
        ]);
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('product') ?? session('last_search_term');
        $favoritedProductIds = Favorite::where('user_id', Auth::id())->pluck('product_id')->toArray();

        if (!$searchTerm) {
            return view('dashboard')->with('message', 'No search term provided.');
        }

        session(['last_search_term' => $searchTerm]);

        if ($request->has('product')) {
            $request->validate([
                'product' => 'required',
            ]);

            // Save to search history only for fresh searches
            SearchHistory::create([
                'product_name' => $searchTerm,
                'user_id' => auth()->id(),
            ]);

            // Only fetch API data for new searches
            $encodedSearchTerm = urlencode($searchTerm);
            $apiUrl = "https://world.openfoodfacts.org/cgi/search.pl?action=process&json=true&search_terms={$encodedSearchTerm}";

            try {
                $response = file_get_contents($apiUrl);
                $data = json_decode($response, true);
            } catch (\Exception $e) {
                return view('dashboard', compact('searchTerm'))->with('message', 'Failed to fetch data');
            }

            $filteredProducts = collect($data['products'])->filter(function ($product) {
                return !empty($product['image_url']) && !empty($product['product_name']);
            })->values();

            // Store filtered products in session
            session(['search_results' => $filteredProducts]);
        } else {
            // Use previously cached results
            $filteredProducts = collect(session('search_results', []));
        }

        // Paginate locally from session data
        $perPage = 6;
        $page = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $filteredProducts->slice(($page - 1) * $perPage, $perPage)->values();

        $paginatedProducts = new LengthAwarePaginator(
            $currentItems,
            $filteredProducts->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('dashboard', [
            'products' => $paginatedProducts,
            'favoritedProductIds' => $favoritedProductIds,
            'searchTerm' => $searchTerm,
        ]);
    }

    public function history()
    {
        // Get all search histories for the authenticated user
        $searchHistories = SearchHistory::where('user_id', auth()->id())
                                        ->orderBy('created_at', 'desc')
                                        ->get();

        // Group by product_name and count how many times each was searched
        $groupedHistories = $searchHistories->groupBy('product_name')->map(function ($items) {
            return [
                'count' => $items->count(),
                'items' => $items,
            ];
        });

        // Pass grouped histories to the view
        return view('history', compact('groupedHistories'));
    }

    public function show($id, Request $request)
    {
        $searchTerm = $request->query('product');
        if ($searchTerm) {
            session(['last_search_term' => $searchTerm]);
        }
    
        $apiUrl = "https://world.openfoodfacts.org/api/v2/product/{$id}.json";
        $response = Http::get($apiUrl);
    
        if ($response->successful() && isset($response['product'])) {
            $product = $response['product'];
            return view('show', compact('product', 'searchTerm'));
        }
    }
}