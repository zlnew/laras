<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Auth/LoginPage', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        
        switch ($request->user()->roles->first()->name) {
            case 'admin': $dashboard = RouteServiceProvider::DASHBOARD_ADMIN; break;
            case 'manajer proyek': $dashboard = RouteServiceProvider::DASHBOARD_MANAJER_PROYEK; break;
            case 'kepala divisi': $dashboard = RouteServiceProvider::DASHBOARD_KEPALA_DIVISI; break;
            case 'keuangan': $dashboard = RouteServiceProvider::DASHBOARD_KEUANGAN; break;
            case 'direktur utama': $dashboard = RouteServiceProvider::DASHBOARD_DIREKTUR_UTAMA; break;
            default: $dashboard = RouteServiceProvider::DASHBOARD_ADMIN; break;
        }

        return redirect()->intended($dashboard);
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
