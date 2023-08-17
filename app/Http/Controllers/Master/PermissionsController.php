<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsController extends Controller
{
    public function index(Request $request): Response
    {
        $roles = Role::all()->toArray();
        $permissions = Permission::all()->pluck('name')->toArray();

        $role = Role::findByName('admin');
        $rolePermissions = $role->permissions()->pluck('name')->toArray();

        if ($request->get('role')) {
            $role = Role::findByName($request->get('role'));
            $rolePermissions = $role->permissions()->pluck('name')->toArray();
        }

        return Inertia::render('Master/PermissionsPage', [
            'roles' => $roles,
            'permissions' => $permissions,
            'role' => $role,
            'rolePermissions' => $rolePermissions
        ]);
    }

    public function sync(Request $request, Role $role): RedirectResponse
    {        
        $permissions = $request->post('permissions');

        $role->syncPermissions($permissions);

        return redirect()->back()->with('success', 'Permissions synced successfully');
    }
}
