<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /*
        * Display a listing of the resource.
    */
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user(); // Get the authenticated user
            $userId = $user->id; // Access the user's ID
        
            // Retrieve the user with roles and permissions
            $userWithRolesAndPermissions = User::where('id', $userId)
                ->with('roles.permissions') // Eager load roles and permissions
                ->first();
        
        } else {
            // Handle the case where the user is not authenticated
            return response()->json(['error' => 'User not authenticated'], 403);
        }
        
        return view('permission.index', [
            'permissions' => Permission::all(),
            'roles' => Role::all()
        ]);
    }

    /*
        * Store a newly created resource in storage.
    */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name',
        ]);

        Permission::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        return redirect()->back()->with('success', 'Permission created successfully');
    }


    /*
        * Remove the specified resource from storage.
    */
    public function destroy($id)
    {
        try {
            DB::table('permissions')->where('id', $id)->delete();
            return redirect()->back()->with('success', 'Permission deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete permission: ' . $e->getMessage());
        }
    }

    public function detailEditRolePermission($id)
    {
        $permissions = Permission::all();
        $rolePermissions = Role::find($id)->permissions->pluck('id')->toArray();
        $permissions = $permissions->map(function ($permission) use ($rolePermissions) {
            return [
                'id' => $permission->id,
                'name' => $permission->name,
                'checked' => in_array($permission->id, $rolePermissions)
            ];
        });

        return view('permission.edit-permission-role', [
            'role' => Role::find($id),
            'permissions' => $permissions,
        ]);
    }

    public function updateRolePermission(Request $request, $id)
    {
        try {
            $role = Role::find($id);
            $role->syncPermissions($request->input('permissions'));

            return redirect()->route('permission.index')->with('success', 'Role permission updated successfully');

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed to update role permission: ' . $th->getMessage());
        }
    }

    /*
        * Store a newly created resource in storage.
    */
    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);

        Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        return redirect()->back()->with('success', 'Role created successfully');
    }


    /*
        * Remove the specified resource from storage.
    */
    public function destroyRole($id)
    {
        try {
            DB::table('roles')->where('id', $id)->delete();
            return redirect()->back()->with('success', 'Role deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete role: ' . $e->getMessage());
        }
    }

}
