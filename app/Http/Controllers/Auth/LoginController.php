<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ActivityLogService;

class LoginController extends Controller
{
    /**
     * Display the login form
     * GET /login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     * POST /login
     */
    public function login(Request $request)
    {
        // Validate credentials
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
        ]);

        // Attempt authentication
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // Regenerate session
            $request->session()->regenerate();

            // Get authenticated user
            $user = Auth::user();
            
            // Log the login
            ActivityLogService::logUserLogin($user->id);

            // Redirect based on role
            $redirectTo = ($user->role === 'admin' || $user->role === 'manager') ? '/admin' : '/resources';

            return redirect($redirectTo)->with('success', 'Successfully logged in.');
        }

        // Failed login
        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'Invalid credentials.',
            ]);
    }

    /**
     * Logout user
     * POST /logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Successfully logged out.');
    }
}
