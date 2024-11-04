<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Skill;
use App\Models\TeacherSkill;
use App\Models\welcomeView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WelcomeViewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        // $categories = Category::get();
        // $skills = Skill::get();

        $categories = Category::all();  // or however you're fetching categories
        $teacherSkills = TeacherSkill::with('skills.category')->get();  // with skills and category relationship

        $results = [];

        foreach ($categories as $category) {
            // Filter teacherSkills for the current category
            $teacherSkillsInCategory = $teacherSkills->filter(function ($teacherSkill) use ($category) {
                return $teacherSkill->skills->category->id === $category->id;
            });

            // Group skills by teacher ID
            $groupedByTeacher = $teacherSkillsInCategory->groupBy('teacher_id');

            // Count teachers with more than 3 distinct categories
            $qualifiedTeacherCount = $groupedByTeacher->filter(function ($skills) {
                return $skills->pluck('skills.category_id')->count() >= 3;
            })->count();

            // Add result to the output array
            $results[] = [
                'name' => $category->name,
                'id' => $category->id,
                'total_teacher' => $qualifiedTeacherCount,
            ];
        }
        $skills = Skill::get();
        // Loop through each skill and count teacher skills for each one
        foreach ($skills as $skill) {
            $teacherSkillCountPerSkill = TeacherSkill::where('skill_id', $skill->id)
                ->whereNull('deleted_at')
                ->count();

            // Store count for each skill
            $teacherSkillCounts[$skill->id] = $teacherSkillCountPerSkill;
        };

        // Start with a base query including eager loading
        $query = TeacherSkill::with('teachers.certifications', 'skills.category');

        // Apply filters conditionally using `when` based on the presence and non-empty value of each parameter
        $query->when($request->filled('category_name') && $request->filled('skill_name'), function ($q) use ($request) {
            // If both category_name and skill_name are provided
            $q->whereHas('skills', function ($skillQuery) use ($request) {
                $skillQuery->where('category_id', $request->category_name)
                    ->where('skill_id', $request->skill_name);
            });
        })->when($request->filled('category_name') && !$request->filled('skill_name'), function ($q) use ($request) {
            // If only category_name is provided
            $q->whereHas('skills', function ($skillQuery) use ($request) {
                $skillQuery->where('category_id', $request->category_name);
            });
        })->when(!$request->filled('category_name') && $request->filled('skill_name'), function ($q) use ($request) {
            // If only skill_name is provided
            $q->whereHas('skills', function ($skillQuery) use ($request) {
                $skillQuery->where('skill_id', $request->skill_name);
            });
        });

        // Execute the query and get results
        $teachers = $query->get();



        return view('welcome', [
            'categories' => $results,
            'skills' => $skills,
            'teachers' => $teachers,
            'teacher_skill_count' => $teacherSkillCounts,
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
    public function show(welcomeView $welcomeView)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, welcomeView $welcomeView)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(welcomeView $welcomeView)
    {
        //
    }
}
