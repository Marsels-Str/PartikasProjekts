<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 text-center">
            <div class="transition duration-1000 p-8 border-4 rounded-lg border-[color:var(--border)] text-[color:var(--text)]">

                <img 
                    src="{{ $product['image_url'] ?? asset('images/no-image.png') }}" 
                    alt="{{ $product['product_name'] ?? 'No Name' }}" 
                    class="w-full max-h-[500px] object-contain rounded-md mb-6"/>

                <h2 class="text-3xl font-semibold mb-4" id="productName">
                    {{ $product['product_name'] ?? 'No Name' }}
                </h2>
                <p class="text-lg" id="ingredientsText">
                    <strong>Ingredients:</strong> {{ $product['ingredients_text'] }}
                </p>
                
                <x-secondary-button onclick="window.history.back()">
                    Back
                </x-secondary-button>
                
                <x-secondary-button 
                    class="translateButton mt-4" 
                    data-product-name="{{ $product['product_name'] }}"
                    data-ingredients="{{ $product['ingredients_text'] }}">
                    Translate
                </x-secondary-button>

            </div>
        </div>
    </div>

    <script>
    //-------------------------------------TRANSLATE-------------------------------------
    document.querySelectorAll('.translateButton').forEach(function(button) {
        button.addEventListener('click', function() {

            var productName = this.getAttribute('data-product-name');
            var ingredientsText = this.getAttribute('data-ingredients');

            fetch('{{ route("translateProduct") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ 
                    product_name: productName,
                    ingredients_text: ingredientsText
                })
            })

            .then(response => response.json())
            .then(data => {
                document.getElementById('productName').textContent = data.translatedFoodName; 
                document.getElementById('ingredientsText').textContent = data.translatedIngredientsText; 
            })
            
            .catch(error => console.error('Error:', error));

        });
    });
    </script>
</x-app-layout>
