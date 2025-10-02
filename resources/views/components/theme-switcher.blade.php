<div
    x-data="{
        bgTheme: localStorage.getItem('bgTheme') || 'light',
        colorTheme: localStorage.getItem('colorTheme') || 'default',

        init() {
            document.documentElement.classList.add(this.bgTheme);
            if (this.colorTheme !== 'default') {
                document.documentElement.classList.add(this.colorTheme);
            }

            this.$watch('bgTheme', val => {
                document.documentElement.classList.remove('light', 'dark');
                document.documentElement.classList.add(val);
                localStorage.setItem('bgTheme', val);
            });

            this.$watch('colorTheme', val => {
                document.documentElement.classList.remove('blue', 'red', 'green', 'orange', 'yellow', 'pink', 'purple');
                if (val !== 'default') {
                    document.documentElement.classList.add(val);
                }
                localStorage.setItem('colorTheme', val);
            });
        }
    }"
    x-init="init()"
    class="font-mono transition-colors duration-1000 min-h-screen"
    style="background-color: var(--bg); color: var(--text)">

    <!-- Improved Dropdown Menu -->
    <div class="absolute mt-4 ml-4">
        <div x-data="{ open: false }" class="relative inline-block text-left" @click.away="open = false" @keydown.escape="open = false">

            <button
                @click="open = !open"
                type="button"
                class="inline-flex justify-between items-center w-48 px-4 py-2 bg-white dark:bg-black border border-black dark:border-white rounded-md hover:bg-white dark:hover:bg-black"
                aria-haspopup="true"
                :aria-expanded="open.toString()"
                :class="{
                    'text-blue-600 dark:text-blue-400': colorTheme === 'blue',
                    'text-red-600 dark:text-red-400': colorTheme === 'red',
                    'text-green-600 dark:text-green-400': colorTheme === 'green',
                    'text-orange-600 dark:text-orange-400': colorTheme === 'orange',
                    'text-yellow-600 dark:text-yellow-400': colorTheme === 'yellow',
                    'text-pink-600 dark:text-pink-400': colorTheme === 'pink',
                    'text-purple-600 dark:text-purple-400': colorTheme === 'purple',
                }">
                <span x-text="`Theme: ${bgTheme.charAt(0).toUpperCase()}${bgTheme.slice(1)}`"></span>
                <svg
                    class="ml-2 h-5 w-5 text-black dark:text-white"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    aria-hidden="true">
                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                </svg>
            </button>

            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="origin-top-right absolute right-0 mt-2 w-48 rounded-md bg-white dark:bg-black border border-black dark:hover:border-white"
                role="menu"
                aria-orientation="vertical"
                tabindex="-1">
                <div class="py-1" role="none">
                    <template x-for="option in ['light', 'dark']" :key="option">
                        <button
                            @click="bgTheme = option; open = false"
                            class="block w-full text-left px-4 py-2 hover:scale-110 transition-transform duration-300"
                            role="menuitem"
                            tabindex="-1"
                            x-text="option.charAt(0).toUpperCase() + option.slice(1)"
                        ></button>
                    </template>

                    <div class="border-t border-black dark:border-white my-1"></div>

                    <button
                        @click="colorTheme = 'default'; open = false"
                        class="text-black dark:text-white block w-full text-left px-4 py-2 text-sm hover:scale-110 transition-transform duration-300"
                        role="menuitem"
                        tabindex="-1"
                    >
                        Default
                    </button>

                    <template x-for="option in ['blue', 'red', 'green', 'orange', 'yellow', 'pink', 'purple']" :key="option">
                        <button
                            @click="colorTheme = option; open = false"
                            class="block w-full text-left px-4 py-2 text-sm hover:scale-110 transition-transform duration-300"
                            role="menuitem"
                            tabindex="-1"
                            :class="{
                                'text-blue-600 dark:text-blue-400': option === 'blue',
                                'text-red-600 dark:text-red-400': option === 'red',
                                'text-green-600 dark:text-green-400': option === 'green',
                                'text-orange-600 dark:text-orange-400': option === 'orange',
                                'text-yellow-600 dark:text-yellow-400': option === 'yellow',
                                'text-pink-600 dark:text-pink-400': option === 'pink',
                                'text-purple-600 dark:text-purple-400': option === 'purple',
                            }"
                            x-text="option.charAt(0).toUpperCase() + option.slice(1)"
                        ></button>
                    </template>
                </div>
            </div>
        </div>
    </div>
    <!-- Main content slot -->
    <div class="p-6">
        {{ $slot }}
    </div>

</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('themeSwitcher', () => ({

        bgTheme: localStorage.getItem('bgTheme') || 'light',
        colorTheme: localStorage.getItem('colorTheme') || 'default',

        init() {
            document.documentElement.classList.add(this.bgTheme);
            if (this.colorTheme !== 'default') {
                document.documentElement.classList.add(this.colorTheme);
            }

            this.$watch('bgTheme', val => {
                document.documentElement.classList.remove('light', 'dark');
                document.documentElement.classList.add(val);
                localStorage.setItem('bgTheme', val);
            });

            this.$watch('colorTheme', val => {
                document.documentElement.classList.remove('blue', 'red', 'green', 'orange', 'yellow', 'pink', 'purple');
                if (val !== 'default') {
                    document.documentElement.classList.add(val);
                }
                localStorage.setItem('colorTheme', val);
            });
        }
    }));
});
</script>
