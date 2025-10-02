<?php

namespace App\Http\Controllers;

use App\Models\LoginHistories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user(); // Get the currently authenticated user
        // Fetch the user's login history
        $loginHistories = LoginHistories::where('user_id', $user->id)
                                        ->orderBy('login_time', 'desc')
                                        ->get(); // Fetch all login histories for the user

        return view('profile.edit', compact('user', 'loginHistories')); // Pass user and login history to the view
    }

    public function update(Request $request)
    {
        $user = $request->user();

        // Validate the input
        $request->validate([
            'name' => [
                'required',
                'string',
                'regex:/^(?=.*[a-zA-Z])[a-zA-Z]{1,20}[0-9]{0,5}$/', // Up to 20 letters and 5 numbers
                'unique:users,name,' . $user->id, // Ignore the current user's name
            ],
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail(__('auth.password'));
                    }
                },
            ],
        ]);

        // Update the user's name
        $user->update([
            'name' => $request->name,
        ]);

        return back()->with('status', 'profile-updated'); // Success message
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        // Validate the input
        $request->validate([
            'old_password' => [
                'required',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail(__('auth.password'));
                    }
                },
            ],
            'new_password' => [
                'required',
                'string',
                'confirmed',
                'min:8', // Minimum 8 characters
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', // At least one lowercase, one uppercase, and one digit
            ],
        ]);

        // Update the user's password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('status', 'password-updated'); // Success message
    }

    public function destroy(Request $request)
    {
        $user = $request->user();

        // Validate password before destroying
        $request->validate([
            'password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail(__('auth.password'));
                }
            }],
        ]);

        // Delete the user
        $user->delete();

        // Logout the user and redirect to homepage
        auth()->logout();

        return redirect('/')->with('status', 'profile-deleted');
    }
}