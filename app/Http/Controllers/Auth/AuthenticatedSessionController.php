<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
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
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        if(Auth::user()->role == 1)
        {
            $url = RouteServiceProvider::ADMIN_HOME;
        }
        else if(Auth::user()->role == 2)
        {
            $url = RouteServiceProvider::TEACHER_HOME;
        }
        else if(Auth::user()->role == 3)
        {
            $url = RouteServiceProvider::STUDENT_HOME;
        }
        else if(Auth::user()->role == 4)
        {
            $url = RouteServiceProvider::PARENT_HOME;
        }

        // print_r($url);die;
        return redirect()->intended($url);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
