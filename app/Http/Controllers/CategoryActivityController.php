<?php

namespace App\Http\Controllers;

use App\Models\CategoryActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryActivityController extends Controller
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
            'name' => 'required|string|max:255|unique:activity_categories',
        ]);

        try {
            CategoryActivity::create([
                'name' => $request->name
            ]);
    
            // Success message and redirect
            session()->flash('success', 'Category added successfully');
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
