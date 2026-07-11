<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Display the admin login form.
     */
    public function showLoginForm()
    {
        if (Auth::guard('employee')->check()) {
            return redirect()->route('crm.dashboard');
        }

        return view('crm.auth.login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);
        if (str_contains($request->username, '@')) {
            $credentials['email'] = $request->username;
            unset($credentials['username']);
        }
        $remember = $request->boolean('remember');

        if (Auth::guard('employee')->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('crm.dashboard'));
        }

        throw ValidationException::withMessages([
            'username' => __('بيانات الدخول غير صحيحة.'),
        ]);
    }

    /**
     * Log the employee out of the application.
     */
    public function logout(Request $request)
    {
        Auth::guard('employee')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('crm.login');
    }
}
