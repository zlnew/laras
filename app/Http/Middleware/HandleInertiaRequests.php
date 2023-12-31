<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'query' => $request->query(),
            'auth' => [
                'user' => $request->user(),
                'role' => $request->user() ? $request->user()->roles->first()->name : null,
                'permissions' => function () use ($request) {
                    $permissions = [];
                    if ($request->user()) {
                        $permissionsViaRoles = $request->user()->getPermissionsViaRoles();
                        $directPermissions = $request->user()->getDirectPermissions();
                        $permissions = $permissionsViaRoles->merge($directPermissions)->pluck('name')->toArray();
                    }
                    return $permissions;
                }
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                    'request' => $request->all(),
                ]);
            },
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ]
        ]);
    }
}
