<?php

namespace App\Http\Controllers;

use App\Http\Middleware\TrackUserActivity;
use App\Models\Sessions;
use App\Models\User;
use App\Models\UserManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    public function index()
    { // Fetch all users and their sessions
        $users = UserManagement::get(); // Pastikan ada relasi 'sessions' pada model User

        // Get all sessions
        $sessions = Sessions::all();

        // Get session lifetime from configuration (in minutes)
        $sessionLifetime = (int) config('session.lifetime');

        foreach ($users as $user) {
            // Fetch the latest session for this user
            $userSession = $sessions->where('user_id', $user->id)->first();

            $isOnline = false;

            // Check if the session exists
            if ($userSession) {
                $lastActivity = \Carbon\Carbon::parse($userSession->last_activity);
                $expired = $lastActivity->addMinutes($sessionLifetime)->isPast(); // Check if session is expired

                $isOnline = !$expired; // If not expired, user is online
            }

            // Add properties to the user object
            $user->is_online = $isOnline;
            $user->last_seen = $userSession ? \Carbon\Carbon::parse($userSession->last_activity)->diffForHumans() : 'Never';
        }

        // Pass the data to the view
        return view('user-management.index', ['users' => $users]);
    }

    public function detailEditPermission($id)
    {
        $user = User::find($id);

        // Ambil semua permissions yang sudah dimiliki oleh user
        $userPermissions = $user->permissions()->pluck('id')->toArray();

        // Map semua permission, tambahkan properti `selected` jika user sudah memiliki permission tersebut
        $permissions = Permission::all()->map(function ($permission) use ($userPermissions) {
            $permission->selected = in_array($permission->id, $userPermissions);
            return $permission;
        });

        return view('user-management.edit-permission', [
            'user' => $user,
            'permissions' => $permissions, // Pass mapped permissions ke view
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
