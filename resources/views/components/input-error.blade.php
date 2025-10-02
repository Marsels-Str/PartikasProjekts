@props(['messages'])

@if ($messages)
    <div class="flex justify-center break-words relative">
        <ul {{ $attributes->merge(['class' => 'text-sm text-red-500 text-center']) }}>
            @foreach ((array) $messages as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif
