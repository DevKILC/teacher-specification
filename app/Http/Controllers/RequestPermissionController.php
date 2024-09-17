<?php

namespace App\Http\Controllers;

use App\Models\RequestPermission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
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
        $permissionId = $request->permission;

        // Validate if the permission exists
        $permission = Permission::find($permissionId);
        // if (!$permission) {
        //     session()->flash('error', 'Invalid permission selected');
        //     return redirect()->back();
        // }

        // // Check if the user already has the requested permission
        // if ($user->hasPermissionTo($permission->name)) {
        //     session()->flash('error', 'You already have this permission');
        //     return redirect()->back();
        // }

        // // Check if the user has already requested this permission
        // if (RequestPermission::where('user_id', $userId)->where('permission_id', $permissionId)->exists()) {
        //     session()->flash('error', 'You have already requested this permission');
        //     return redirect()->back();
        // }

        // Create the permission request
        try {
            RequestPermission::create([
                'user_id' => $userId,
                'permission_id' => $permissionId,
                'stats' => 'Pending', // Default request status is 'Pending'
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
        //update stats ketika admin mengklik aprove dan reject ketika ditolak
        // $user = Auth::user();
        // if (!$user->hasPermissionTo('update request permissions')) {
        //     abort(403);
        // }
        // $requestPermission->fill($request->all());
        // if ($request->status == 'Approved') {
        //     $requestPermission->user->givePermissionTo($request->permission);
        // } elseif ($request->status == 'Rejected') {
        //     $requestPermission->user->revokePermissionTo($request->permission);
        // }
        // // save status request
        // $requestPermission->save();

        // session()->flash('success', 'Request status updated successfully');
        // return redirect()->route('request-permissions.index');
        // return redirect()->back();
        // return redirect()->route('request-permissions.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RequestPermission $requestPermission)
    {
        //
    }
}
