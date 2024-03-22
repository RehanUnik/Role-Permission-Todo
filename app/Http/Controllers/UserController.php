<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(Request $request)
    {

        $roles = Role::all();
        $role = $request->role ?? "";
        $search = $request->search ?? "";

        $usersQuery = User::query();

        if ($role !== "") {
            $usersQuery->whereHas('roles', function ($query) use ($role) {
                $query->where('name', $role);
            });
        }

        if ($search !== "") {
            $usersQuery->orWhere('name', 'LIKE', "%$search%");
        }

        $users = $usersQuery->paginate(5);

        return view('users.users', compact('users', 'roles'));

        // if ($role != "" || $search != "") {
        //     $users = User::whereHas('roles', function ($query) use ($role) {
        //         $query->where('name', $role);
        //     })->orwhere('name', 'LIKE', "$search")
        //         ->paginate(5);
        //     return view('users.users', compact('users', 'roles'));
        // }


        // $users = User::paginate(5);
        // return view('users.users', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|alpha|min:3',
            'email' => 'required|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/|email|unique:users',
            'password' => 'required|regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/|confirmed',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if (!empty($request->roles)) {
            $roleNames = $request->roles;
            $roleIds = Role::whereIn('name', $roleNames)->pluck('id');
            $user->roles()->sync($roleIds);
        }

        return to_route('users')->with('success', 'User Created');
    }

    public function edit($id)
    {
        $user = User::find($id);
        $allRoles = Role::all();
        $userRoles  = Role::join('user_roles', 'user_roles.role_id', 'roles.id')
            ->select('roles.id', 'roles.name')
            ->where('user_roles.user_id', $id)
            ->get();

        return view('users.edit', compact('user', 'allRoles', 'userRoles'));

        // dd($roles->name);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found');
        }

        $request->validate([
            'name' => 'required|alpha|min:3',
            'email' => 'required|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/|email|unique:users,email,' . $id,
            'password' => 'nullable|regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/|confirmed',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
        ]);

        if (!empty($request->roles)) {
            $roleNames = $request->roles;
            $roleIds = Role::whereIn('name', $roleNames)->pluck('id');
            $user->roles()->sync($roleIds);
        } else {
            // If no roles are selected, you might want to detach existing roles
            $user->roles()->detach();
        }

        return redirect()->route('users')->with('success', 'User updated successfully');
    }
}
