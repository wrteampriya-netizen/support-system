<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    //
    public function showPermission()
    {
        return view('permission.permission');
    }
    public function store(Request $request)
    {
        $request->validate([
            'permission' => 'required',
        ]);

        $data = Permission::create([
            'name' => $request->permission,

        ]);
        return redirect()->route('permission.index')->with('success', 'permission is inserted');
    }
    public function index()
    {
        return view('permission.index');
    }
    public function fetch()
    {
        $data = Permission::all();

        return response()->json($data);
    }
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('permission.edit', compact('permission'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $permission = Permission::findOrFail($id);
        $permission->update(['name' => $request->name]);
        return redirect()->route('permission.index')->with('success', 'permission is updated');
    }
    public function destory($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return redirect()->route('permission.index')->with('success', 'permission is updated');
    }
}
