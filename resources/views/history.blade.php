<x-app-layout>
    <div class="py-12">
        <div class="max-w-screen-xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-6">
                History
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6">
                
                @foreach($groupedHistories as $productName => $group)
                    <div 
                        class="flex flex-col justify-center items-center text-center p-4 transition duration-1000 border-4 rounded-lg border-[color:var(--border)] text-[color:var(--text)] ">
                        <h4 class="font-bold mb-2">
                            {{ $productName }}
                        </h4>
                        
                        <p class="text-sm">
                            You searched for this 
                            <span class="font-bold">
                                {{ $group['count'] }}
                            </span> 
                            time{{ $group['count'] > 1 ? 's' : '' }}.
                        </p>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</x-app-layout>
