<section>
    <header>
        <h2 class="text-center font-bold text-lg">
            {{ __('Update Password') }}
        </h2>

        <p class="text-center">
            {{ __('Ensure your account is using a strong password, that only you know!') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <!-- Current Password Field -->
        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <div class="relative">
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="w-full" />
                <div class="absolute inset-y-0 right-3 flex items-center">
                    <input id="toggleUpdateCurrentPassword" type="checkbox" class="hidden" onchange="togglePasswordVisibility('update_password_current_password', this)" />
                    <label for="toggleUpdateCurrentPassword" class="cursor-pointer hover:scale-150 transition-transform duration-150 active:scale-95">
                        <img 
                            :src="bgTheme === 'dark' ? '{{ asset('images/white-eye.png') }}' : '{{ asset('images/black-eye.png') }}'" 
                            alt="Toggle Password Visibility" 
                            class="w-8" 
                        />
                    </label>
                </div>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" />
        </div>

        <!-- New Password Field -->
        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <div class="relative">
                <x-text-input id="update_password_password" name="password" type="password" class="w-full" />
                <div class="absolute inset-y-0 right-3 flex items-center">
                    <input id="toggleUpdatePassword" type="checkbox" class="hidden" onchange="togglePasswordVisibility('update_password_password', this)" />
                    <label for="toggleUpdatePassword" class="cursor-pointer hover:scale-150 transition-transform duration-150 active:scale-95">
                        <img 
                            :src="bgTheme === 'dark' ? '{{ asset('images/white-eye.png') }}' : '{{ asset('images/black-eye.png') }}'" 
                            alt="Toggle Password Visibility" 
                            class="w-8" 
                        />
                    </label>
                </div>
            </div>
            <x-input-error :messages="$errors->updatePassword->first('password')" />
        </div>

        <!-- Confirm New Password Field -->
        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm New Password')" />
            <div class="relative">
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="w-full" />
                <div class="absolute inset-y-0 right-3 flex items-center">
                    <input id="toggleUpdateConfirmPassword" type="checkbox" class="hidden" onchange="togglePasswordVisibility('update_password_password_confirmation', this)" />
                    <label for="toggleUpdateConfirmPassword" class="cursor-pointer hover:scale-150 transition-transform duration-150 active:scale-95">
                        <img 
                            :src="bgTheme === 'dark' ? '{{ asset('images/white-eye.png') }}' : '{{ asset('images/black-eye.png') }}'" 
                            alt="Toggle Password Visibility" 
                            class="w-8" 
                        />
                    </label>
                </div>
            </div>
        </div>

        <!-- Save with a message -->
        <div class="flex items-center">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm pl-4"
                >{{ __('Password updated!') }}</p>
            @endif
        </div>
    </form>
</section>
