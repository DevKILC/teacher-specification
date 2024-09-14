<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    public function index()
    {
        return view('user-management.index', [
            'users' => User::all(),
        ]);
    }


    public function detailEditPermission($id)
    {
        $user = User::find($id);
        return view('user-management.edit-permission', [
            'user' => $user,
            'permissions' => Permission::all(),
        ]);
    }

    public function updatePermission(Request $request, $id)
    {
        try {
            $user = User::find($id);
            $user->givePermissionTo($request->input('permissions'));
    
            return redirect()->route('user-management.index')->with('success', 'Permission updated successfully');

        } catch (\Throwable $th) {
            return $th->getMessage();
            return redirect()->back()->with('error', 'Failed to update permission: ' . $th->getMessage());
        }
    }

    public function detailEditRole($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        
        $roles = $roles->map(function ($role) use ($user) {
            $role->selected = $user->hasRole($role->name);
            return $role;
        });

        return view('user-management.edit-permission-role', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    public function updateRole($id)
    {
        try {
            $user = User::find($id);
            $user->syncRoles(request()->input('roles'));

            return redirect()->route('user-management.index')->with('success', 'Role updated successfully');

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed to update role: ' . $th->getMessage());
        }
    }
}
