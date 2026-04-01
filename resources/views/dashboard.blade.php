<x-app-layout>
  <!-- Search -->
  <div class="py-4 px-4">
    <div class="flex justify-center">
      <div class="transition duration-1000 p-6 w-full max-w-md border-4 rounded-lg border-[color:var(--border)] text-[color:var(--text)]">

        <form id="searchForm" action="{{ route('searchProduct') }}" method="GET" onsubmit="showSpinner()">
          <label class="block text-center font-semibold mb-2" for="product">
            Search for Something:
          </label>
          <x-text-input id="product" name="product" class="w-full mb-3" placeholder="To Eat" value="{{ request('product') }}" />
          <div class="flex justify-center">
            <x-secondary-button type="submit">Search</x-secondary-button>
          </div>
          <x-input-error :messages="$errors->get('product')" />
        </form>

      </div>
    </div>
  </div>

  <!-- Spinner -->
  <div id="searchingSpinner" class="hidden mt-6 text-center text-gray-500 text-lg">
    Searching… please wait
  </div>

  @if(isset($products) && $products->count())
    <!-- Products Grid -->
    <div id="products-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mx-4 mt-6">
      @foreach($products as $index => $product)
        <div class="transition duration-1000 p-6 flex flex-col border-4 rounded-lg border-[color:var(--border)] text-[color:var(--text)]">
          <div class="flex flex-col items-center">
            <a href="{{ route('show', ['id' => $product['id'], 'product' => $searchTerm]) }}">
              <img src="{{ $product['image_url'] }}" alt="{{ $product['product_name'] }}" class="w-full h-48 object-cover rounded-md mb-4"/>
              <p class="text-center">
                <strong>Food Name:</strong> <span>{{ $product['product_name'] }}</span>
              </p>
            </a>

            <form action="{{ route('favorites.toggle', $product['id']) }}" method="POST">
              @csrf
              @php $isFavorited = in_array($product['id'], $favoritedProductIds ?? []); @endphp
              <button type="submit"
                      class="{{ $isFavorited ? 'text-red-500' : 'text-gray-300 dark:text-white' }} hover:text-red-500 dark:hover:text-red-400 text-3xl transition-colors duration-150">
                ❤
              </button>
            </form>

            <x-secondary-button class="translateButton"
                                data-product-name="{{ $product['product_name'] }}"
                                data-index="{{ $index }}">
              Translate
            </x-secondary-button>

          </div>
        </div>
      @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-4 flex flex-col items-center">
      <p class="text-sm">Page {{ $products->currentPage() }} of {{ $products->lastPage() }}</p>
      <div>
        {!! $products->appends(request()->query())->links('pagination::simple-tailwind') !!}
      </div>
    </div>

  @elseif(isset($searchTerm))
    <p class="text-center mt-6 text-red-500">No products found for "{{ $searchTerm }}".</p>
  @endif

  <script>
    function showSpinner() {
      document.getElementById('searchingSpinner').classList.remove('hidden');
    }

    document.querySelectorAll('.translateButton').forEach(function(button) {
      button.addEventListener('click', function() {
        var productName = this.getAttribute('data-product-name');

        // get current card
        var card = this.closest('.flex.flex-col.items-center');

        // find the span inside THIS card
        var nameSpan = card.querySelector('p span');

        fetch('{{ route("translateProduct") }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({ 
            product_name: productName
          })
        })
        .then(response => response.json())
        .then(data => {
          if (nameSpan && data.translatedFoodName) {
            nameSpan.textContent = data.translatedFoodName;
          }
        })
        .catch(error => console.error('Error:', error));
      });
    });
  </script>
</x-app-layout>
