<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                switch ($request->user()->roles->first()->name) {
                    case 'admin': $dashboard = RouteServiceProvider::DASHBOARD_ADMIN; break;
                    case 'manajer proyek': $dashboard = RouteServiceProvider::DASHBOARD_MANAJER_PROYEK; break;
                    case 'kepala divisi': $dashboard = RouteServiceProvider::DASHBOARD_KEPALA_DIVISI; break;
                    case 'keuangan': $dashboard = RouteServiceProvider::DASHBOARD_KEUANGAN; break;
                    case 'direktur utama': $dashboard = RouteServiceProvider::DASHBOARD_DIREKTUR_UTAMA; break;
                    default: $dashboard = RouteServiceProvider::DASHBOARD_ADMIN; break;
                }

                return redirect($dashboard);
            }
        }

        return $next($request);
    }
}
