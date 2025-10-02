<x-app-layout>
    <div class="py-16 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row gap-6">
                <!-- Profile Information -->
                <div class="transition duration-1000 w-full md:w-1/2 p-6 md:p-8 border-4 rounded-lg border-[color:var(--border)] text-[color:var(--text)]">
                    <div class="max-w-md mx-auto">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Login History -->
                <div class="transition duration-1000 w-full md:w-1/2 p-6 md:p-8 flex flex-col border-4 rounded-lg border-[color:var(--border)] text-[color:var(--text)]">
                    <section class="space-y-6">
                        <header>
                            <h2 class="text-center font-bold text-lg">
                                {{ __('Login History') }}
                            </h2>
                        </header>

                        <div class="overflow-y-auto max-h-[460px] space-y-2"> 
                            @if(isset($loginHistories) && $loginHistories->isNotEmpty())
                                @php
                                    $hasLoggedOut = $loginHistories->whereNotNull('logout_time')->isNotEmpty();
                                @endphp

                                @foreach ($loginHistories as $history)
                                    <div class="p-2 transition duration-1000 border rounded-lg border-[color:var(--border)] text-[color:var(--text)]">
                                        <p><strong>Login:</strong> {{ $history->login_time->setTimezone('Europe/Riga')->subHour()->format('Y-m-d H:i') }}</p>

                                        @if ($history->logout_time)
                                            <p><strong>Logout:</strong> {{ $history->logout_time->setTimezone('Europe/Riga')->subHour()->format('Y-m-d H:i') }}</p>
                                            @php
                                                $login = $history->login_time->setTimezone('Europe/Riga')->subHour();
                                                $logout = $history->logout_time->setTimezone('Europe/Riga')->subHour();
                                                $diff = $login->diff($logout);
                                                $duration = sprintf('%02d:%02d:%02d', $diff->h, $diff->i, $diff->s);
                                            @endphp
                                            <p><strong>Duration:</strong> {{ $duration }}</p>
                                        @else
                                            <p><strong>Status:</strong> You're still online!</p>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <p class="text-center">{{ __('Nothing to see yet!') }}</p>
                            @endif
                        </div>
                    </section>

                    <!-- Delete Account -->
                    <div class="mt-6 md:mt-auto">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
