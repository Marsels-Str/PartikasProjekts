<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-center">Favorites</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 w-full">

                    @forelse ($products as $product)
                        <div class="flex flex-col justify-between w-full p-4 transition duration-1000 border-4 rounded-lg border-[color:var(--border)] text-[color:var(--text)] ">

                            <a href="{{ route('show', ['id' => $product['id'], 'product' => $product['product_name']]) }}">
                                <img 
                                    src="{{ $product['image_url'] ?? 'https://via.placeholder.com/150' }}" 
                                    alt="{{ $product['product_name'] }}" 
                                    class="w-full h-48 object-cover rounded-md mb-4"
                                />
                                <p class="text-center font-semibold">
                                    <strong>Food Name:</strong> {{ $product['product_name'] ?? 'Unnamed Product' }}
                                </p>
                            </a>

                            <form action="{{ route('favorites.toggle', $product['id']) }}" method="POST" class="mt-2 flex justify-center">
                                @csrf
                                @php
                                    $isFavorited = in_array($product['id'], $favoritedProductIds ?? []);
                                @endphp
                                <button 
                                    type="submit" 
                                    class="{{ $isFavorited ? 'text-red-500' : 'text-gray-300 dark:text-white' }}
                                    hover:text-red-500 dark:hover:text-red-900 transition-colors duration-150 text-3xl">
                                    ❤
                                </button>
                            </form>

                        </div>
                    @empty
                        <p class="text-center col-span-full">You have no favorite products yet!</p>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
