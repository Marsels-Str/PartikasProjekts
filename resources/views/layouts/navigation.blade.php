<nav x-data="navLinks({{ auth()->check() ? 'true' : 'false' }})" x-init="setActiveLink()">
    <div class="flex justify-center items-center w-full relative">
        <!-- Burger Menu Icon -->
        <div @click="isOpen = !isOpen" class="p-2 cursor-pointer space-y-1 fixed right-4 top-4 z-50">
            <!-- Line 1 -->
            <span class="block w-6 h-0.5 transition-transform duration-300"
                :class="isOpen ? 'transform rotate-45 translate-y-1.5' : ''"
                :style="{ backgroundColor: 'var(--text)' }"></span>

            <!-- Line 2 -->
            <span class="block w-6 h-0.5 transition-opacity duration-300"
                :class="isOpen ? 'opacity-0' : ''"
                :style="{ backgroundColor: 'var(--text)' }"></span>

            <!-- Line 3 -->
            <span class="block w-6 h-0.5 transition-transform duration-300"
                :class="isOpen ? '-rotate-45 -translate-y-1.5' : ''"
                :style="{ backgroundColor: 'var(--text)' }"></span>
        </div>

        <!-- Sliding Menu -->
        <div x-show="isOpen"
             @click.away="isOpen = false"
             class="fixed bg-white dark:bg-black right-0 top-0 bottom-0 left-auto z-40 max-w-sm w-[30%] lg:w-[11%] overflow-hidden border-l-2 border-[color:var(--border)] text-[color:var(--text)]"
             :class="isOpen ? 'translate-x-0' : 'translate-x-full'">
            <div class="flex flex-col items-center space-y-6 py-8 px-4 h-full">

                <!-- Home -->
                <a href="{{ route('welcome') }}"
                   class="link p-2 transition transform duration-300 ease-in-out hover:scale-110"
                   :class="{
                       '': activeLink !== 'home' && hoveredLink !== 'home',
                       'hover:text-red-500 shadow-red-500': hoveredLink === 'home' && activeLink !== 'home',
                       'text-green-500 hover:text-green-500 shadow-green-500': activeLink === 'home'
                   }"
                   @click="setLink('home'); isOpen = false"
                   @mouseover="hoveredLink = 'home'"
                   @mouseleave="hoveredLink = null">
                   Home
                </a>

                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}"
                   class="link p-2 transition transform duration-300 ease-in-out hover:scale-110"
                   :class="{
                       'hover:text-red-500 shadow-red-500': hoveredLink === 'dashboard' && activeLink !== 'dashboard',
                       'text-green-500 hover:text-green-500 shadow-green-500': activeLink === 'dashboard',
                       '': activeLink !== 'dashboard' && hoveredLink !== 'dashboard'
                   }"
                   @click="setLink('dashboard'); isOpen = false"
                   @mouseover="hoveredLink = 'dashboard'"
                   @mouseleave="hoveredLink = null">
                   Search
                </a>

                <!-- Favorites -->
                <a href="{{ route('favorites') }}"
                   class="link p-2 transition transform duration-300 ease-in-out hover:scale-110"
                   :class="{
                       'hover:text-red-500 shadow-red-500': hoveredLink === 'favorites' && activeLink !== 'favorites',
                       'text-green-500 hover:text-green-500 shadow-green-500': activeLink === 'favorites',
                       '': activeLink !== 'favorites' && hoveredLink !== 'favorites'
                   }"
                   @click="setLink('favorites'); isOpen = false"
                   @mouseover="hoveredLink = 'favorites'"
                   @mouseleave="hoveredLink = null">
                   Favorites
                </a>

                <!-- History -->
                <a href="{{ route('history') }}"
                   class="link p-2 transition transform duration-300 ease-in-out hover:scale-110"
                   :class="{
                       'hover:text-red-500 shadow-red-500': hoveredLink === 'history' && activeLink !== 'history',
                       'text-green-500 hover:text-green-500 shadow-green-500': activeLink === 'history',
                       '': activeLink !== 'history' && hoveredLink !== 'history'
                   }"
                   @click="setLink('history'); isOpen = false"
                   @mouseover="hoveredLink = 'history'"
                   @mouseleave="hoveredLink = null">
                   History
                </a>

                <!-- Profile -->
                <a href="{{ route('profile.edit') }}"
                   class="link p-2 transition transform duration-300 ease-in-out hover:scale-110"
                   :class="{
                       'hover:text-red-500 shadow-red-500': hoveredLink === 'profile' && activeLink !== 'profile',
                       'text-green-500 hover:text-green-500 shadow-green-500': activeLink === 'profile',
                       '': activeLink !== 'profile' && hoveredLink !== 'profile'
                   }"
                   @click="setLink('profile'); isOpen = false"
                   @mouseover="hoveredLink = 'profile'"
                   @mouseleave="hoveredLink = null">
                   Profile
                </a>

                <!-- Log Out -->
                <div class="flex justify-center mt-auto">
                    <form method="POST" action="{{ route('logout') }}" class="inline-block">
                        @csrf
                        <button type="submit"
                                class="transition transform duration-300 ease-in-out hover:scale-110 hover:text-red-500 hover:shadow-red-500"
                                @click="clearLink">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('navLinks', (isLoggedIn) => ({
            activeLink: null,  // The currently active link
            hoveredLink: null, // The link being hovered over
            isOpen: false,
            isLoggedIn: isLoggedIn,

            // Link From Session
            setActiveLink() {
                if (!this.isLoggedIn) {
                    this.activeLink = null;
                    window.sessionStorage.removeItem('activeLink');
                } else {
                    const path = window.location.pathname;
                    // Link from Session
                    if (window.sessionStorage.getItem('activeLink')) {
                        this.activeLink = window.sessionStorage.getItem('activeLink');
                    } else {
                        // Current Link
                        if (path.includes('/welcome')) {
                            this.activeLink = 'home';
                        } else if (path.includes('/dashboard')) {
                            this.activeLink = 'dashboard';
                        } else if (path.includes('/history')) {
                            this.activeLink = 'history';
                        } else if (path.includes('/favorites')) {
                            this.activeLink = 'favorites';
                        } else if (path.includes('/profile')) {
                            this.activeLink = 'profile';
                        }
                    }
                }
            },
            // Active Link
            setLink(link) {
                this.activeLink = link;
                window.sessionStorage.setItem('activeLink', link);
                this.isOpen = false;
            },
            // Clear Links
            clearLink() {
                window.sessionStorage.removeItem('activeLink');
                this.activeLink = null;
            }
        }));
    });
</script>

<style>
    .shadow-red-500 {
        text-shadow: 
            0 0 8px red,
            0 0 16px red,
            0 0 24px red,
            0 0 32px red,
            0 0 48px rgba(255, 0, 0, 0.8),
            0 0 64px rgba(255, 0, 0, 0.6),
            0 0 80px rgba(255, 0, 0, 0.4);
    }

    .shadow-green-500 {
        text-shadow: 
            0 0 8px green,
            0 0 16px green,
            0 0 24px green,
            0 0 32px green,
            0 0 48px rgba(0, 255, 0, 0.8),
            0 0 64px rgba(0, 255, 0, 0.6),
            0 0 80px rgba(0, 255, 0, 0.4);
    }
</style>
