<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')"/>
            <x-text-input id="name" class="block w-full" type="text" name="name" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <!-- Password -->
        <div class="mt-8 mb-8">
            <x-input-label for="password" :value="__('Password')" />
            <div class="relative">
                <x-text-input id="password"
                            class="block w-full pr-10"
                            type="password"
                            name="password"
                            autocomplete="new-password" />
                <div class="absolute inset-y-0 right-3 flex items-center">
                    <input id="togglePassword" type="checkbox" class="hidden" onchange="togglePasswordVisibility('password', this)" />
                    <label for="togglePassword" class="cursor-pointer hover:scale-150 transition-transform duration-150 active:scale-95">
                        <img 
                            :src="bgTheme === 'dark' ? '{{ asset('images/white-eye.png') }}' : '{{ asset('images/black-eye.png') }}'" 
                            alt="Toggle Password Visibility" 
                            class="w-8" 
                            />
                    </label>
                </div>
            </div>
            <x-input-error :messages="$errors->first('password')" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <div class="relative">
                <x-text-input id="password_confirmation"
                            class="block w-full"
                            type="password"
                            name="password_confirmation"
                            autocomplete="new-password" />
                <div class="absolute inset-y-0 right-3 flex items-center">
                    <input id="togglePasswordConfirmation" type="checkbox" class="hidden" onchange="togglePasswordVisibility('password_confirmation', this)" />
                    <label for="togglePasswordConfirmation" class="cursor-pointer hover:scale-150 transition-transform duration-150 active:scale-95">
                        <img 
                            :src="bgTheme === 'dark' ? '{{ asset('images/white-eye.png') }}' : '{{ asset('images/black-eye.png') }}'" 
                            alt="Toggle Password Visibility" 
                            class="w-8" 
                            />
                    </label>
                </div>
            </div>
        </div>
        <x-input-error :messages="$errors->get('password_confirmation')"/>

        <script>
            function togglePasswordVisibility(inputId, checkbox) {
                const passwordInput = document.getElementById(inputId);
                passwordInput.type = checkbox.checked ? 'text' : 'password';
            }
        </script>

        <div class="flex items-center justify-end mt-4">
            <a class="text-sm rounded-md hover:underline transition-transform duration-150 active:scale-95"
               href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
