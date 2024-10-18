<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Skill;
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


        $allSkills =  Skill::all();
        
        $teachers = $request->id ? Teacher::with('teacherSkills.skills','certifications')->find($request->id) : Teacher::dummyData();
    
        
        // Validasi skill jika $teachers dan teacherSkills ada, jika tidak gunakan collection kosong
        $teachersSkillsGetValidation = $teachers && $teachers->teacherSkills
            ? $teachers->teacherSkills->pluck('skills.id')
            : collect([]);
           

        return view('teacher.addSkillTeacher', [
            'teachers' => $teachers,
            'allSkills' => $allSkills,
            'teachersSkillsGetValidation' => $teachersSkillsGetValidation,
        ]);
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        try {

            $request->validate([
                'teacher_id' => 'required|exists:teachers,id',
                'skill_id' => 'required|array', // Change id_skill to skill_id
                'skill_id.*' => 'required|exists:skills,id',
            ]);

            $skills = $request->input('skill_id');
            $teacher_id = $request->input('teacher_id');
    
            $allTeachers = Teacher::all();
            $allSkills = Skill::get();
            $teachers = Teacher::with('teacherSkills.skills')->find($teacher_id);
            $teachersSkillsGetValidation = $teachers && $teachers->teacherSkills ? $teachers->teacherSkills->pluck('skills.id') : collect([]);

            // Add new skills to the teacher
            foreach ($skills as $skill) {
                TeacherSkill::create([
                    'teacher_id' => $teacher_id,
                    'skill_id' => $skill,
                ]);
            }

            // Success message and redirect
            session()->flash('success', 'Skill added successfully');
            return redirect()->route('teacher.index', [
                'id' => $teacher_id, // Pass the id parameter
            ])->with([
                'teachers' => $teachers,
                'allTeachers' => $allTeachers,
                'allSkills' => $allSkills,
                'teachersSkillsGetValidation' => $teachersSkillsGetValidation,
            ]);

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
    public function show($teacher_id, Request $request)
    { 
        $allSkills = Skill::when($request->skill_name, function ($query, $skill_name) {
            return $query->where(DB::raw('LOWER(name)'), 'like', '%' . $skill_name . '%')
                         ->orWhere(DB::raw('LOWER(type)'), 'like', '%' . $skill_name . '%');
                     
        })->get();
        


        $teachers = Teacher::with('teacherSkills.skills')->find($teacher_id);
        
        // Validasi skill jika $teachers dan teacherSkills ada, jika tidak gunakan collection kosong
        $teachersSkillsGetValidation = $teachers && $teachers->teacherSkills
            ? $teachers->teacherSkills->pluck('skills.id')
            : collect([]);

        return view('teacher.addSkillTeacher', [
            'teachers' => $teachers,
            'allSkills' => $allSkills,
            'teachersSkillsGetValidation' => $teachersSkillsGetValidation,
        ]);
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