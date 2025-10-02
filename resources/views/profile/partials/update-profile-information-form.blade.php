<section>
    <header>
        <h2 class="text-center font-bold text-lg">
            {{ __('Profile Information') }}
        </h2>
        <p class="text-center">
            {{ __("Update your account's profile information!") }}
        </p>
    </header>

    <!-- Name Update -->
    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="w-full" :value="old('name', $user->name)" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <!-- Password Confirmation -->
        <div>
            <x-input-label for="current_password" :value="__('Current Password')" />
            <div class="relative">
                <x-text-input id="current_password" name="current_password" type="password" class="w-full" />
                <div class="absolute inset-y-0 right-3 flex items-center">
                    <input id="toggleCurrentPassword" type="checkbox" class="hidden" onchange="togglePasswordVisibility('current_password', this)" />
                    <label for="toggleCurrentPassword" class="cursor-pointer hover:scale-150 transition-transform duration-150 active:scale-95">
                        <img 
                            :src="bgTheme === 'dark' ? '{{ asset('images/white-eye.png') }}' : '{{ asset('images/black-eye.png') }}'" 
                            alt="Toggle Password Visibility" 
                            class="w-8" 
                        />
                    </label>
                </div>
            </div>
            <x-input-error :messages="$errors->get('current_password')" />
        </div>

        <div class="flex items-center">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 2000)" class="text-sm pl-4">
                    {{ __('Name updated!') }}
                </p>
            @endif
        </div>
    </form>
</section>

<!-- Update Password -->
<section class="mt-8">
    @include('profile.partials.update-password-form')
</section>

<!-- Password Visibility -->
<script>
    function togglePasswordVisibility(inputId, checkbox) {
        const passwordInput = document.getElementById(inputId);
        passwordInput.type = checkbox.checked ? 'text' : 'password';
    }
</script>
