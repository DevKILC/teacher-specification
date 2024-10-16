<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\restoreSkillAndCategory;
use App\Models\Skill;
use Illuminate\Http\Request;

class RestoreSkillAndCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('skill.index', [
            'skills' => Skill::withTrashed()->with('category')->get(),
            'categories' => Category::withTrashed()->get(),

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(restoreSkillAndCategory $restoreSkillAndCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, restoreSkillAndCategory $restoreSkillAndCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(restoreSkillAndCategory $restoreSkillAndCategory)
    {
        //
    }
}
