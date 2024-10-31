<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Skill;
use App\Models\Teacher;
use App\Models\TeacherSkill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('skill.index', [
            'skills' => Skill::with('category')->orderBy('created_at', 'desc')->get(),
            'categories' => Category::orderBy('created_at', 'desc')->get(),

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
            // return redirect()->back()->withErrors($e->validator->errors())->withInput();
            session()->flash('error', $e->validator->errors()->first());
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:ONLINE,OFFLINE',
        ]);

        try {

            $skill->update($validated);

            // make flash message
            session()->flash('success', 'Skill updated successfully');
            return redirect()->route('skill.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation exceptions
            // return redirect()->back()->withErrors($e->validator->errors())->withInput();
            session()->flash('error', $e->validator->errors()->first());
        } catch (\Exception $e) {
            // Handle general exceptions
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill)
    {
        try {

            DB::transaction(function () use ($skill) {
                // hapus skill
                $skill->delete();
                // hapus teacher_skill
                TeacherSkill::where('skill_id', $skill->id)->delete();
            });

            // Berikan pesan sukses dan redirect ke halaman sebelumnya
            session()->flash('success', 'Skill deleted successfully');
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
