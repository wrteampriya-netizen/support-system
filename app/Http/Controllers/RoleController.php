<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;


class RoleController extends Controller
{
    //
    public function showrole()
    {
        $permissions = Permission::all();
        return view('Role.create', compact('permissions'));
    }
    public function index()
    {
        return view('Role.index');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $role = Role::create([
            'name' => $request->name,
        ]);
        $role->syncPermissions($request->permission);
        return redirect()->route('role.index')->with('success', 'role id inserted');
    }

    public function fetch()
    {
        $data = Role::with('permissions')->get();
        return response()->json($data);
    }
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('role.edit', compact('role', 'permissions', 'rolePermissions'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $role = Role::findOrFail($id);
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permission);
        return redirect()->route('role.index')->with('success', 'permission is updated');
    }
    public function destory($id)
    {
        $permission = Role::findOrFail($id);
        $permission->delete();
        return redirect()->route('role.index')->with('success', 'permission is updated');
    }

    public function User_data()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();
        return view('Role.User', compact('users', 'roles'));
    }

    public function role_assign(Request $request, $id){
        $user=User::findOrFail($id);
       $user->syncRoles([$request->role]);
        return redirect()->back()->with('success','role assigned');

    }
}

    //
