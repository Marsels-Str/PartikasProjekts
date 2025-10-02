<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\LoginHistories;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['name' => $request->name, 'password' => $request->password], $request->filled('remember'))) {
            // Ensure there's no active session before creating a new one
            $activeSession = LoginHistories::where('user_id', Auth::id())
                                        ->whereNull('logout_time')  // If there's no logout time
                                        ->first();

            // Only create a new login record if there isn't already an active session
            if (!$activeSession) {
                LoginHistories::create([
                    'user_id' => Auth::id(),
                    'login_time' => Carbon::now(),
                ]);
            }

            $request->session()->regenerate();

            return redirect()->route('welcome');
        }

        return back()->withErrors([
            'name' => 'The provided credentials do not match our records!',
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        // Fetch the active login session (user logged in but didn't log out)
        $loginHistories = LoginHistories::where('user_id', $user->id)
            ->whereNull('logout_time')  // Active session (no logout time yet)
            ->first();
        
        if ($loginHistories) {
            // Set the logout time using the correct time zone (Europe/Riga)
            $logoutTime = Carbon::now();
            $loginHistories->update(['logout_time' => $logoutTime]);
        }
        
        // Log the user out
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}
