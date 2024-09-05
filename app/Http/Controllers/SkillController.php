<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('skill.index',[
            'skills' => Skill::all(),
            'categories' => Category::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('skill.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:ONLINE,OFFLINE',
        ]);

        try {
    
            Skill::create($validated);
    
            // make flash message
            session()->flash('success', 'Skill created successfully');
            return redirect()->route('skill.index');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation exceptions
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
            
        } catch (\Exception $e) {
            // Handle general exceptions
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Skill $skill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skill $skill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Skill $skill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill)
    {
        //
    }
}
