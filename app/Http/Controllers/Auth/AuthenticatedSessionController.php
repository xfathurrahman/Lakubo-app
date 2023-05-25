<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (auth()->user()->hasRole('admin')) {
                return redirect('admin/dashboard');
            }

            if (auth()->user()->hasRole('seller')) {
                return redirect('seller/dashboard');
            }

            return redirect()->intended(RouteServiceProvider::HOME);
        }

        if (User::query()->where('email', $credentials['email'])->exists()) {
            return redirect()->back()->withErrors(['password' => 'Password salah.']);
        } else {
            return redirect()->back()->withErrors(['email' => 'Email salah.']);
        }
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
