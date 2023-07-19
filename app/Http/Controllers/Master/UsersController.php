<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class UsersController extends Controller
{
    public function index(Request $request): Response
    {
        $usersQuery = DB::table('users')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('users.deleted_at', null)
            ->where('users.id', '!=', $request->user()->id);

        if ($request->method() === 'GET' && $request->all()) {
            $usersQuery = $this->filter($request, $usersQuery);
        }

        $users = $usersQuery->select('users.*', 'roles.name as role_name')
            ->groupBy('users.id', 'roles.name')
            ->orderBy('users.id', 'desc')
            ->paginate(10);

        $roles = DB::table('roles')
            ->select('id', 'name')
            ->get();

        return Inertia::render('Master/Users/Index', [
            'users' => $users,
            'roles' => $roles
        ]);
    }

    public function filter(Request $request, $usersQuery): Builder
    {
        $usersQuery->when($request->get('name'), function ($query, $name) {
            $query->where('users.name', 'like', $name . '%');
        });
    
        $usersQuery->when($request->get('email'), function ($query, $email) {
            $query->where('users.email', 'like', $email . '%');
        });
    
        $usersQuery->when($request->get('role'), function ($query, $role) {
            $query->where('roles.name', $role);
        });

        return $usersQuery;
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $validated = $request->safe();

        DB::transaction(function () use ($validated) {
            $user = new User;

            if ($validated->password === null) {
                $validated->password = 'password';
            }
    
            $user->fill([
                'name' => $validated->name,
                'email' => $validated->email,
                'password' => Hash::make($validated->password),
            ]);
    
            $user->save();

            $user->assignRole($validated->role);
        });

        return redirect()->back()->with('success', 'User berhasil dibuat!');
    }

    public function update(UpdateRequest $request, User $user): RedirectResponse
    {
        $validated = $request->safe();

        DB::transaction(function () use ($validated, $user) {
            $user->fill([
                'name' => $validated->name,
                'email' => $validated->email,
            ]);

            if ($validated->password !== null) {
                $user->password = Hash::make($validated->password);
            }
    
            $user->save();

            $userRoles = $user->getRoleNames();
            
            foreach ($userRoles as $role) {
                $user->removeRole($role);
            }

            $user->assignRole($validated->role);
        });

        return redirect()->back()->with('success', 'User berhasil diperbarui!');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus!');
    }
}