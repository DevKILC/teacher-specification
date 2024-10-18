<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use Illuminate\Http\Request;

class CertificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
        ]);
        
        try {
            // Cek apakah teacher sudah memiliki 3 certification
            $teacherCertificationsCount = Certification::where('teacher_id', $request->teacher_id)->count();
        
            if ($teacherCertificationsCount >= 3) {
                // Jika teacher memiliki 3 certification, beri pesan error dan kembalikan
                return redirect()->back()->with('error', 'Teachers already have 3 certifications, cannot add more.');
            }
        
            // Jika belum ada 3 certification, tambahkan data baru
            Certification::create([
                'teacher_id' => $request->teacher_id,
                'name' => $request->name
            ]);
        
            // Pesan sukses dan redirect
            session()->flash('success', 'Certification added successfully');
            return redirect()->back();
        
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Menangani validasi exception
            session()->flash('error', $e->getMessage());
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        
        } catch (\Exception $e) {
            // Menangani exception umum
            session()->flash('error', $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }        

    /**
     * Display the specified resource.
     */
    public function show(Certification $certification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Certification $certification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Certification $certification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Certification $certification)
    {
        //
    }
}
