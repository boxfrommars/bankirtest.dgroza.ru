<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(Request $request): View
    {
        return view('auth.login', [
            'authenticated' => $request->session()->get('owner_authenticated') === true,
        ]);
    }

    public function login(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'password' => ['required', 'string'],
        ]);
        $passwordHash = config('owner.password_hash');

        if (blank($passwordHash)) {
            abort(503, 'Owner access is not configured.');
        }

        if (! password_verify($validated['password'], $passwordHash)) {
            return back()
                ->withErrors(['password' => 'Неверный пароль'])
                ->onlyInput();
        }

        $request->session()->regenerate();
        $request->session()->put('owner_authenticated', true);

        return redirect()->intended(route('home'));
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
