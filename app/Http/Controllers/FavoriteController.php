<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;
use App\Services\FoodService;

class FavoriteController extends Controller
{
    protected FoodService $foodService;

    public function __construct(FoodService $foodService)
    {
        $this->foodService = $foodService;
    }

    public function index()
    {
        $userId = Auth::id();

        // Get all favorite product IDs
        $favoritedProductIds = Favorite::where('user_id', $userId)
            ->pluck('product_id')
            ->toArray();

        // Fetch products using FoodService (cached)
        $products = collect($favoritedProductIds)
            ->map(function ($productId) {
                return $this->foodService->getProduct($productId);
            })
            ->filter() // remove nulls if API failed
            ->values()
            ->toArray();

        return view('favorites', [
            'products' => $products,
            'favoritedProductIds' => $favoritedProductIds,
        ]);
    }

    public function toggle($productId)
    {
        $userId = Auth::id();

        $existing = Favorite::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            $existing->delete();
        } else {
            Favorite::create([
                'user_id' => $userId,
                'product_id' => $productId,
            ]);
        }

        return back();
    }
}
