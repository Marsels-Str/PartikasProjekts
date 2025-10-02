<section>
    <header>
        <h2 class="text-center font-bold text-lg">
            {{ __('Delete Account') }}
        </h2>

        <p class="text-center">
            {{ __('Deleting an account is permanent and will remove all of the data that is connected with this account from our databases, so think twice before you make this decision!') }}
        </p>
    </header>

    <!-- Delete Pop Up -->
    <x-danger-button
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
        {{ __('Delete') }}
    </x-danger-button>
    <x-modal 
        name="confirm-user-deletion" 
        :show="$errors->userDeletion->isNotEmpty() || $errors->has('password')" 
        focusable>
        <form method="POST" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('DELETE') {{-- Spoofs the DELETE method in a form (HTML only supports GET/POST) --}}

            <h2 class="text-center font-bold text-lg">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="text-center">
                {{ __('Please make sure u will not need anything from this account ever again, because once its deleted all of its data will be deleted too and you will not be able to get anything back!') }}
            </p>

            <!-- Password -->
            <div class="flex justify-center">
                <div class="flex flex-col w-3/4">
                    <x-input-label for="password" value="{{ __('Password') }}" />
                    <div class="relative">
                        <x-text-input
                            id="password"
                            name="password"
                            type="password"
                            aria-describedby="password-error"
                            autocomplete="current-password"
                            class="w-full" />
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
                    <x-input-error :messages="$errors->get('password')" id="password-error" />
                </div>
            </div>

            <!-- Cancel and Delete -->
            <div class="mt-6 flex justify-between">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button>
                    {{ __('Delete') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
