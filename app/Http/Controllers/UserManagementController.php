<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

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
}
