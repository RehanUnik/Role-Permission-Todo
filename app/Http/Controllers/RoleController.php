<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('roles.roles', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|alpha',
        ]);

        $role = new Role;
        $role->name = $request->name;
        $role->save();

        return redirect()->back()->with('success', 'Role Created');
    }

    public function edit($id)
    {
        $role = Role::find($id);
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $request->validate([
            'name' => 'required|min:3|alpha',
        ]);

        $role->name = $request->name;
        $role->save();

        return redirect('/roles')->with('success', 'Role Updated');
    }

    public function destroy($id)
    {
        $role = Role::find($id);
        $role->delete();
        return redirect('/roles')->with('success', 'Role Deleted');
    }
}
