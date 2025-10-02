<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => '
        inline-flex items-center px-4 py-2 rounded-md text-xs tracking-widest transition ease-in-out duration-300 active:scale-95
        bg-[var(--bg)] text-[var(--text)] border border-[var(--border)]
        hover:bg-red-500 hover:border-red-500 hover:text-white
        dark:hover:bg-red-500 dark:hover:border-red-500 dark:hover:text-black
    '
]) }}>
    {{ $slot }}
</button>
