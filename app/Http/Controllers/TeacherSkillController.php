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
       
        $allTeachers = Teacher::all();
        $allSkills =DB::table('skills')->get();
        
        // Langsung ambil teacher berdasarkan id, atau null jika tidak ada
        $teachers = Teacher::with('teacherSkills.skills')
            ->find($request->id);
    
        // Validasi skill jika $teachers dan teacherSkills ada, jika tidak gunakan collection kosong
        $teachersSkillsGetValidation = $teachers && $teachers->teacherSkills
            ? $teachers->teacherSkills->pluck('skills.skill_id')
            : collect([]);
    
return $allSkills;
        return view('teacher.index', [
            'teachers' => $teachers,
            'allTeachers' => $allTeachers,
            'allSkills' => $allSkills,
            'teachersSkillsGetValidation' => $teachersSkillsGetValidation,
        ]);
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Ambil array id_skill dari checkbox
        $skills = $request->input('skill_id');
        $id_teacher = $request->input('teacher_id');
        
        // Validasi input
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'skill_id' => 'required|array',
            'skill_id.*' => 'exists:skills,id_skill', // Validasi untuk setiap skill yang dipilih
        ]);
        
        try {
            // Siapkan array untuk push data
            $data = [];
            
            // Menggunakan array push untuk mengumpulkan data
            foreach ($skills as $id_skill) {
                array_push($data, [
                    'teacher_id' => $id_teacher,
                    'skill_id' => $id_skill,
                ]);
            }
            
            // Batch insert semua data sekaligus
            DB::table('teacher_skills')->insert($data);
            
            // Redirect dengan pesan sukses
            return redirect()->route('teacher.index', ['id' => $id_teacher])
                ->with('success', 'Skills added successfully');
        } catch (\Exception $e) {
            // Redirect dengan pesan gagal jika terjadi exception
            return redirect()->route('teacher.index', ['id' => $id_teacher])
                ->with('error', 'Failed to add skills. Please try again.');
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
    public function destroy(Request $request)
    {
        // Validasi input
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'skill_id' => 'required|exists:skills,id_skill',
        ]);
    
        try {
            // Menghapus skill dari teacher
            DB::table('teacher_skills')
                ->where('teacher_id', $request->teacher_id)
                ->where('skill_id', $request->skill_id)
                ->delete();
    
            // Redirect dengan pesan sukses
            return redirect()->route('delete-teacher-skill', ['id' => $request->teacher_id])
                ->with('success', 'Skill deleted successfully.');
        } catch (\Exception $e) {
            // Redirect dengan pesan gagal jika terjadi exception
            return redirect()->route('delete-teacher-skill', ['id' => $request->teacher_id])
                ->with('error', 'Failed to delete skill.');
        }
    }
    
    }

