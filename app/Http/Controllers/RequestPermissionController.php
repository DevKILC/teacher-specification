<?php

namespace App\Http\Controllers;

use App\Models\RequestPermission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class RequestPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {

    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;
        $username = $user->name;
        $permissionId = $request->permission;

        // Validate if the permission exists
        $permission = Permission::find($permissionId);
        if (!$permission) {
            session()->flash('error', 'Invalid permission selected');
            return redirect()->back();
        }

        // Check if the user already has the requested permission
        if ($user->hasPermissionTo($permission->name)) {
            session()->flash('error', 'You already have this permission');
            return redirect()->back();
        }

        // Check if the user has already requested this permission
        if (RequestPermission::where('user_id', $userId)->where('permission_id', $permissionId)->exists()) {
            session()->flash('error', 'You have already requested this permission');
            return redirect()->back();
        }

        // Create the permission request
        try {
            RequestPermission::create([
                'user_id' => $userId,
                'permission_id' => $permissionId,
                'stats' => 'Pending', // Default request status is 'Pending'
                'created_by' => $username, // Menyimpan user ID yang membuat permintaan
            ]);

            session()->flash('success', 'Permission request sent successfully');
            return redirect()->back();

        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
            return redirect()->back();
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(RequestPermission $requestPermission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RequestPermission $requestPermission)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RequestPermission $requestPermission)
    { 
        try {
            // Cari data request permission berdasarkan ID yang diberikan
            $undoSent = DB::table('request_permission')->where('id',$requestPermission->id )->delete();

    
            // Jika tidak ditemukan, lempar error dan kembalikan pesan error
            if (!$undoSent) {
                session()->flash('error', 'Request not found.');
                return redirect()->back();
            }
    
            // Berikan pesan sukses dan redirect ke halaman sebelumnya
            session()->flash('success', 'Your request deleted successfully');
            return redirect()->back();
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangani error validasi
            session()->flash('error', $e->getMessage());
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
    
        } catch (\Exception $e) {
            // Tangani error lain
          
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

}
