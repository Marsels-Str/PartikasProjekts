<button {{ $attributes->merge([
    'type' => 'button',
    'class' => '
        inline-flex items-center px-4 py-2 rounded-md text-xs tracking-widest transition ease-in-out duration-300 active:scale-95
        bg-[var(--bg)] text-[var(--text)] border border-[var(--border)]
        hover:bg-[var(--text)] hover:text-[var(--bg)]
    '
]) }}>
    {{ $slot }}
</button>
