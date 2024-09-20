<?php

namespace App\Http\Controllers;

use App\Models\ModelHasPermission;
use App\Models\RequestPermission;
use App\Models\User;
use App\Models\UserManagement;
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

        // Ambil data request permission yang belum diproses

           // ambil data untuk history
        //    jika role Administrator maka show semua data 
        if (Auth::check() && Auth::user()->hasRole('Administrator')) {
            $histories = RequestPermission::with('user','permissions')
            ->orderBy('created_at', 'desc')
            ->get();
        } else {
            // Jika bukan role administrator, hanya tampilkan history yang dimiliki user ini
            $histories = RequestPermission::with('user','permissions')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        }

        //    Mengmemperlihatkan data permisi yang dimiliki oleh user
       
        $showPermission = ModelHasPermission::with('userManagement','permission')->where('model_id', Auth::id())->get();


        return view('permission.index', [
            'showPermission' => $showPermission,
            'histories' => $histories,
            'userId' => Auth::id(),
            'permissions' => Permission::all(),
            'roles' => Role::all()
        ]);
    }

    public function accept($id)
    {
        try {
            // Cari permintaan permission berdasarkan ID
            $permissionRequest = RequestPermission::find($id);

            $user_id = User::find($permissionRequest->user_id);
            $permission = Permission::find($permissionRequest->permission_id);

            // Ubah status menjadi "Accept"
            $permissionRequest->stats = 'Accept';
            $permissionRequest->updated_by = Auth::user()->name; // Menyimpan user ID yang menerima permintaan
            $permissionRequest->save();

            // Menambahkan permisi ke user yang menerima permintaan
            $user_id->givePermissionTo($permission);

            // session notifikasi
            session()->flash('success', 'Permission request accepted successfully');
            return redirect()->back();

        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /*
     * Method to decline a permission request
     */
    public function decline($id)
    {
        try {
            // Cari permintaan permission berdasarkan ID
            $permissionRequest = RequestPermission::find($id);

            // Ubah status menjadi "Decline"
            $permissionRequest->stats = 'Decline';
            $permissionRequest->updated_by = Auth::user()->name; // Menyimpan user ID yang menolak permintaan
            $permissionRequest->save();

            session()->flash('success', 'Permission request declined successfully');
            return redirect()->back();

        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
            return redirect()->back();
        }
    }
    /*
        * Store a newly created resource in storage.
    */
    public function store(Request $request)
    {
        try{
        $request->validate([
            'name' => 'required|string|unique:permissions,name',
        ]);

        Permission::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        session()->flash('success', 'Permission created successfully');
        return redirect()->back();

    } catch (\Exception $e) {
        session()->flash('error', 'Error: ' . $e->getMessage());
        return redirect()->back();
    }
    }


    /*
        * Remove the specified resource from storage.
    */
    public function destroy($id)
    {
        try {
            DB::table('permissions')->where('id', $id)->delete();

            // hapus permission yang berkaitan dari user
            ModelHasPermission::where('permission_id', $id)->delete();

            
            // hapus permission yang berkaitan dari usermanagement
            UserManagement::where('permission_id', $id)->delete();

            
            // hapus permission yang berkaitan dari request permission
            RequestPermission::where('permission_id', $id)->delete();

            
            // hapus permission yang berkaitan dengan role
            DB::table('role_has_permissions')->where('permission_id', $id)->delete();

            
            // hapus permission yang berkaitan dengan user
            DB::table('model_has_permissions')->where('permission_id', $id)->delete();

            
            // hapus permission yang berkaitan dengan user management
            DB::table('user_management')->where('permission_id', $id)->delete();

            
            // hapus permission yang berkaitan dengan request permission
            DB::table('request_permission')->where('permission_id', $id)->delete();

            session()->flash('success', 'Permission deleted successfully');
            return redirect()->back();

        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
            return redirect()->back();
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


            session()->flash('success', 'Permission updated successfully');
            return redirect()->back();

        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /*
        * Store a newly created resource in storage.
    */
    public function storeRole(Request $request)
    {
        try{
        $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);

        Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        session()->flash('success', 'Role created successfully');
        return redirect()->back();

    } catch (\Exception $e) {
        session()->flash('error', 'Error: ' . $e->getMessage());
        return redirect()->back();
    }
}


    /*
        * Remove the specified resource from storage.
    */
    public function destroyRole($id)
    {
        try {
            DB::table('roles')->where('id', $id)->delete();

            // hapus role dari user
            User::whereHas('roles', function ($query) use ($id) {
                $query->where('role_id', $id);
            })->update(['role_id' => null]);

            session()->flash('success', 'Role deleted successfully');
            return redirect()->back();

        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
            return redirect()->back();
        }

    }
