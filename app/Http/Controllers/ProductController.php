<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Support\Facades\Http;
use App\Models\SearchHistory;
use Illuminate\Http\Request;
use App\Services\FoodService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    protected FoodService $foodService;

    public function __construct(FoodService $foodService)
    {
        $this->foodService = $foodService;
    }

    /**
     * Search products and display dashboard
     */
    public function search(Request $request)
    {
        // Get search term from input or session
        $searchTerm = $request->input('product') ?? session('last_search_term');

        if (!$searchTerm) {
            return view('dashboard', [
                'products' => collect(),
                'favoritedProductIds' => [],
                'searchTerm' => null,
            ]);
        }

        // Save search term in session
        session(['last_search_term' => $searchTerm]);

        // Record search history only for new submissions
        if ($request->has('product')) {
            $request->validate(['product' => 'required']);
            SearchHistory::create([
                'product_name' => $searchTerm,
                'user_id' => Auth::id(),
            ]);
        }

        // Fetch products from FoodService (limit 50 for performance)
        $allProducts = collect($this->foodService->search($searchTerm, 50));

        // Local pagination
        $perPage = 6;
        $page = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $allProducts->slice(($page - 1) * $perPage, $perPage)->values();

        $paginatedProducts = new LengthAwarePaginator(
            $currentItems,
            $allProducts->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        // Get user's favorites
        $favoritedProductIds = Favorite::where('user_id', Auth::id())
                                       ->pluck('product_id')
                                       ->toArray();

        return view('dashboard', [
            'products' => $paginatedProducts,
            'favoritedProductIds' => $favoritedProductIds,
            'searchTerm' => $searchTerm,
        ]);
    }

    /**
     * Translate a product name (optional)
     */
    public function translateProduct(Request $request)
    {
        $productName = $request->input('product_name');
        $ingredientsText = $request->input('ingredients_text');

        return response()->json([
            'translatedFoodName' => $this->translateToEnglish($productName),
            'translatedIngredientsText' => !empty($ingredientsText)
                ? $this->translateToEnglish($ingredientsText)
                : '',
        ]);
    }

    /**
     * Show product details
     */
    public function show($id)
    {
        $product = $this->foodService->getProduct($id);
        if (!$product) abort(404);

        return view('show', compact('product'));
    }

    /**
     * Translate text using Google Translate
     */
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
        $response = @file_get_contents($url, false, $context);

        if (!$response) return $text;

        $result = json_decode($response, true);

        return $result['data']['translations'][0]['translatedText'] ?? $text;
    }

    /**
     * Display user's search history
     */
    public function history()
    {
        $searchHistories = SearchHistory::where('user_id', Auth::id())
                                        ->orderBy('created_at', 'desc')
                                        ->get();

        $groupedHistories = $searchHistories->groupBy('product_name')->map(function ($items) {
            return [
                'count' => $items->count(),
                'items' => $items,
            ];
        });

        return view('history', compact('groupedHistories'));
    }
}
