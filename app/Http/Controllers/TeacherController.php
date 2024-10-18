<?php

namespace App\Http\Controllers;
use App\Models\Skill;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $allTeachers = Teacher::all();
        $allSkills =  Skill::all();
        
        $teachers = $request->id ? Teacher::with('teacherSkills.skills','certifications')->find($request->id) : Teacher::dummyData();
    
        
        // Validasi skill jika $teachers dan teacherSkills ada, jika tidak gunakan collection kosong
        $teachersSkillsGetValidation = $teachers && $teachers->teacherSkills
            ? $teachers->teacherSkills->pluck('skills.id')
            : collect([]);
            

        return view('teacher.index', [
            'teachers' => $teachers,
            'allTeachers' => $allTeachers,
            'allSkills' => $allSkills,
            'teachersSkillsGetValidation' => $teachersSkillsGetValidation,
        ]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher, $teacher_skill)
    {
    }
}