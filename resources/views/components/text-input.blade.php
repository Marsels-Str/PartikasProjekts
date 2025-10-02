@props(['disabled' => false])

<input
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge([
        'class' =>
            'bg-transparent border-2 border-[color:var(--text)] rounded-md ' .
            'focus:border-[color:var(--text)] focus:ring-0 active:scale-95 transition-colors duration-1000'
    ]) !!}
>
