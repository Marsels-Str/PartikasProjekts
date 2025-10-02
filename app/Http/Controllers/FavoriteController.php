<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{

    public function index()
    {
        $favorites = Favorite::where('user_id', auth()->id())->pluck('product_id');
        $favoritedProductIds = Favorite::where('user_id', auth()->id())->pluck('product_id')->toArray();

        $products = [];

        foreach ($favorites as $productId) {
            $response = Http::get("https://world.openfoodfacts.org/api/v2/product/{$productId}");
            if ($response->ok() && isset($response['product'])) {
                $products[] = $response['product'];
            }
        }

        return view('favorites', compact('products', 'favoritedProductIds'));
    }

    public function toggle($productId)
    {
        $user = Auth::user();
        $favoritedProductIds = Favorite::where('user_id', auth()->id())->pluck('product_id')->toArray();

        $existing = Favorite::where('user_id', $user->id)
                            ->where('product_id', $productId)
                            ->first();

        if ($existing) {
            $existing->delete();
            return back();
        }

        Favorite::create([
            'user_id' => $user->id,
            'product_id' => $productId,
        ]);

        return back();
    }
}
