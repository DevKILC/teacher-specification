<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\models\Skill;
use App\Models\TeacherSkill;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class TeacherSkillController extends Controller
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
        // Retrieve skills and teacher ID
        $skills = $request->input('skill_id');
        $id_teacher = $request->input('teacher_id');
        
        try {

            $request->validate([
                'teacher_id' => 'required|exists:teachers,id',
                'skill_id' => 'required|array', // Change id_skill to skill_id
                'skill_id.*' => 'exists:skills,id', // Validate each skill selected
            ]);


            // Add new skills to the teacher
            foreach ($skills as $skill) {
                TeacherSkill::create([
                    'teacher_id' => $id_teacher,
                    'skill_id' => $skill,
                ]);
            }

            // Success message and redirect
            session()->flash('success', 'Skill added successfully');
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
    public function show(Teacher $teachers)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teachers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($teacher_skill)
    {
        try {
            // Cari data teacher_skill berdasarkan ID yang diberikan
            $teacherSkill = TeacherSkill::find($teacher_skill);
    
            // Jika tidak ditemukan, lempar error dan kembalikan pesan error
            if (!$teacherSkill) {
                session()->flash('error', 'Skill not found.');
                return redirect()->back();
            }
    
            // Jika ditemukan, hapus skill tersebut
            $teacherSkill->delete();
    
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