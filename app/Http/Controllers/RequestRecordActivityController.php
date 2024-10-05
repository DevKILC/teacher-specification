<?php

namespace App\Http\Controllers;

use App\Models\RequestRecordActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequestRecordActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
     
        $user = Auth::user();
        $userId = $user->id;
        $username = $user->name;

      
         // Retrieve skills and teacher ID
        
         // Validasi input
         $request->validate([
            'id' => 'required|exists:teachers,id',
            'activity' => 'required|string|max:255',
            'category_id' => 'required|exists:activity_categories,id',
            'date' => 'required|date',
        ]);

        try {
            // Simpan data aktivitas
            RequestRecordActivity::create([
                'user_id' => $userId,
                'teacher_id' => $request->id,
                'category_id' => $request->category_id,
                'activity' => $request->activity,
                'date' => $request->date,
                'stats' => 'Pending', // Default status is pending until teacher approves or rejects the request
                'created_by' => $username,

            ]);


            // Success message and redirect
            session()->flash('success', 'Activity request send successfully');
            return redirect()->back();

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation exceptions
            session()->flash('error', $e->getMessage());
            return redirect()->back()->withErrors($e->validator->errors())->withInput();

        } catch (\Exception $e) {
            // Handle general exceptions
            session()->flash('error', $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(RequestRecordActivity $requestRecordActivity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RequestRecordActivity $requestRecordActivity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RequestRecordActivity $requestRecordActivity)
    {
        try {
            // Cari data request permission berdasarkan ID yang diberikan
            $undoSent = DB::table('request_record_activities')->where('id',$requestRecordActivity->id )->delete();

    
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
