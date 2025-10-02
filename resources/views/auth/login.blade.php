<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')"/>
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"/>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-8 mb-8">
            <x-input-label for="password" :value="__('Password')" />
            <div class="relative">
                <x-text-input id="password"
                            class="block mt-1 w-full"
                            type="password"
                            name="password"
                            autocomplete="current-password" />

                <div class="absolute inset-y-0 right-3 flex items-center">
                    <input id="togglePassword" type="checkbox" class="hidden" onchange="togglePasswordVisibility()" />
                    <label for="togglePassword" class="cursor-pointer hover:scale-150 transition-transform duration-150 active:scale-95">
                        <img 
                            :src="bgTheme === 'dark' ? '{{ asset('images/white-eye.png') }}' : '{{ asset('images/black-eye.png') }}'" 
                            alt="Toggle Password Visibility" 
                            class="w-8" 
                            />
                    </label>
                </div>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <script>
            function togglePasswordVisibility() {
                const passwordInput = document.getElementById('password');
                const toggleCheckbox = document.getElementById('togglePassword');
                passwordInput.type = toggleCheckbox.checked ? 'text' : 'password';
            }
        </script>
        
        <div class="flex items-center justify-end">
                <a class="text-sm rounded-md hover:underline transition-transform duration-150 active:scale-95"
                   href="{{ route('register') }}">
                    {{ __("Don't have an account?") }}
                </a>

            <x-primary-button class="ms-4">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
