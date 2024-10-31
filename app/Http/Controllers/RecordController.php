<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Models\RequestRecordActivity;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Jika tidak ada filter tanggal, ambil semua activities
            $allActivities = Record::with(['teachers', 'category'])->get();
        }

        if (Auth::check() && Auth::user()->hasRole('Administrator')) {
            $histories = RequestRecordActivity::with('user','teacher','category_activity')
            ->orderBy('created_at', 'desc')
            ->get();
        } else {
            // Jika bukan role administrator, hanya tampilkan history yang dimiliki user ini
            $histories =  RequestRecordActivity::with('user','teacher','category_activity')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        }
        // Kirim data ke view
        return view('record.index', [
            'histories' => $histories,
            'allTeachers' => $allTeachers,
            'categories' => $categories,
            'allActivities' => $allActivities,
        ]);
    }
    public function accept($record)
    {
        try {
            // Cari permintaan permission berdasarkan ID
            $activityRequest = RequestRecordActivity::find($record);

            // Ubah status menjadi "Accept"
            $activityRequest->stats = 'Accept';
            $activityRequest->updated_by = Auth::user()->name; // Menyimpan user ID yang menolak permintaan
            $activityRequest->save();

            // ketika accept tambahkan data ke record
          if ($activityRequest->stats == 'Accept') {
                    Record::create([
                        'teacher_id' => $activityRequest->id,
                        'activity' => $activityRequest->activity,
                        'category_id' => $activityRequest->category_id,
                        'date' => $activityRequest->date,
                    ]);
                }
                 session()->flash('success', 'Activity request accepted successfully.');
            return redirect()->back();
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangani error validasi
            session()->flash('error', $e->getMessage());
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
    
        } catch (\Exception $e) {
            // Tangani error lain
            session()->flash('error', 'An error occurred: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function decline($record)
    {
        try {
            // Cari permintaan permission berdasarkan ID
            $activityRequest = RequestRecordActivity::find($record);

            // Ubah status menjadi "Decline"
            $activityRequest->stats = 'Decline';
            $activityRequest->updated_by = Auth::user()->name; // Menyimpan user ID yang menolak permintaan
            $activityRequest->save();

            session()->flash('success', 'Request decline successfully');
            return redirect()->back();
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangani error validasi
            session()->flash('error', $e->getMessage());
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
    
        } catch (\Exception $e) {
            // Tangani error lain
            session()->flash('error', 'An error occurred: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
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

    public function storerequest() {
        
    }

    public function destroy($record)
    {
        try {
            // Cari data teacher_skill berdasarkan ID yang diberikan
            $records = Record::find($record);

            // Jika tidak ditemukan, lempar error dan kembalikan pesan error
            if (!$records) {
                session()->flash('error', 'Activity not found.');
                return redirect()->back();
            }

            // Jika ditemukan, hapus skill tersebut
            $records->delete();

            // Berikan pesan sukses dan redirect ke halaman sebelumnya
            session()->flash('success', 'Activity deleted successfully');
            return redirect()->back();
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangani error validasi
            session()->flash('error', $e->getMessage());
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            // Tangani error lain
            session()->flash('error', 'An error occurred: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
