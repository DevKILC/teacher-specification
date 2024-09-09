<?php

namespace App\Http\Controllers;
use App\Models\Record;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua teachers dan categories
        $allTeachers = DB::table('teachers')->get();
        $categories = DB::table('activity_categories')->get();
    
        // Ambil start dan end dari request, jika tersedia
        $start = $request->input('start');
        $end = $request->input('end');
    
        // Filter activities berdasarkan tanggal jika start dan end disediakan
        if ($start && $end) {
            $allActivities = Record::with(['teachers', 'category']) // Pastikan relasi menggunakan nama yang benar
                ->whereBetween('date', [$start, $end])
                ->get();
        } else {
            // Jika tidak ada filter tanggal, ambil semua activities
            $allActivities = Record::with(['teachers', 'category'])->get();
        }
    
        // Kirim data ke view
        return view('record.index', [
            'allTeachers' => $allTeachers,
            'categories' => $categories,
            'allActivities' => $allActivities,
        ]);
    }
    
    public function store(Request $request)
    {   
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
            Record::create([
                'teacher_id' => $request->id,
                'activity' => $request->activity,
                'category_id' => $request->category_id,
                'date' => $request->date,
            ]);


            // Success message and redirect
            session()->flash('success', 'Activity added successfully');
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
  
}
