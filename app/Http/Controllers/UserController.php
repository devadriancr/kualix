<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Area;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })
            ->with('roles')
            ->paginate(10);

        return view('users.index', compact('users', 'search'));
    }

    public function create()
    {
        $areas = Area::all();
        $roles = Role::all();
        return view('users.create', compact('areas', 'roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'area_id' => $validated['area_id'],
        ]);

        if ($request->filled('roles')) {
            $roles = Role::whereIn('id', $request->roles)->pluck('name');
            $user->syncRoles($roles);
        }

        return redirect()->route('users.index')
            ->with('success', 'Usuario creado correctamente');
    }

    public function edit(User $user)
    {
        $areas = Area::all();
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles', 'areas'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'area_id' => $validated['area_id'],
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        if ($request->filled('roles')) {
            $roles = Role::whereIn('id', $request->roles)->pluck('name');
            $user->syncRoles($roles);
        }

        return redirect()->route('users.index')
            ->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propio usuario');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuario eliminado correctamente');
    }
}
