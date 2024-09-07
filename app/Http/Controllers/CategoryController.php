<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Skill;
use App\Models\TeacherSkill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
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
            'name' => 'required|string|max:255|unique:categories',
        ]);

        try {
            Category::create([
                'name' => $request->name
            ]);
    
            // make flash message
            session()->flash('success', 'Category created successfully');
            return redirect()->route('skill.index');
        } catch (\Throwable $th) {

            // make flash message
            session()->flash('error', $th->getMessage());
            // return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'.$category->id,
        ]);

        try {
            $category->update($validated);
    
            // make flash message
            session()->flash('success', 'Category updated successfully');
            return redirect()->route('skill.index');
        } catch (\Throwable $th) {

            // make flash message
            session()->flash('error', $th->getMessage());
            // return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            DB::transaction(function () use ($category) {
                $skills = Skill::where('category_id', $category->id)->get();
                foreach ($skills as $skill) {
                    TeacherSkill::where('skill_id', $skill->id)->delete();
                }
                $category->skills()->delete();
                $category->delete();
            });

            // make flash message
            session()->flash('success', 'Category deleted successfully');
            return redirect()->back()->with('success', 'Category deleted successfully');
        } catch (\Throwable $th) {
            return $th->getMessage();
            // make flash message
            session()->flash('error', $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
