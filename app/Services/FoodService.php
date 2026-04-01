<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class FoodService
{
    protected string $baseUrl = 'https://world.openfoodfacts.org';

    // Search multiple products
    public function search(string $query, int $limit = 50): array
    {
        $cacheKey = "off_search_" . md5($query);

        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($query, $limit) {
            $encoded = urlencode($query);
            $url = "{$this->baseUrl}/cgi/search.pl?action=process&json=true&search_terms={$encoded}&page_size={$limit}";

            try {
                $response = Http::timeout(10)->get($url);
                if ($response->ok()) {
                    return collect($response['products'] ?? [])
                        ->filter(fn($p) => !empty($p['product_name']) && !empty($p['image_url']))
                        ->values()
                        ->toArray();
                }
            } catch (\Exception $e) {
                return [];
            }

            return [];
        });
    }

    // Get a single product
    public function getProduct(string $id): ?array
    {
        $cacheKey = "off_product_" . $id;

        return Cache::remember($cacheKey, now()->addHours(12), function () use ($id) {
            try {
                $response = Http::timeout(10)->get("{$this->baseUrl}/api/v2/product/{$id}.json");
                if ($response->ok() && isset($response['product'])) {
                    return $response['product'];
                }
            } catch (\Exception $e) {
                return null;
            }
            return null;
        });
    }
}
