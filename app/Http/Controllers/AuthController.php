<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    //Login View Page
    public function login(): View
    {
        return view('auth.login');
    }

    //Execute Login
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        if(Auth::user()->hasRole('staff')) {
            return redirect()->intended(RouteServiceProvider::SALE)->with('success', 'Login Success');
        }
        return redirect()->intended(RouteServiceProvider::HOME)->with('success', 'Login Success');
    }

    //Execute Logout 
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout Success');
    }
}
