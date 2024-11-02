<?php
namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\TeacherSkill;
use App\Models\Category;
use App\Models\Skill;
use App\Models\Record;
use App\Models\CategoryActivity;
use App\Models\Certification;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil semua data guru
        $teachers = Teacher::with('certifications')->get();
        // menghitung data
        $teachersCount = Teacher::count();
        $skillCount = Skill::count();
        $categoryCount = Category::count();
        $activityCount = Record::count();
        $categoryActivityCount = CategoryActivity::count();
        $teacherSkillCount = TeacherSkill::count();
        $certification = Certification::count();

        $totalCount = $teachersCount + $skillCount + $categoryCount + $activityCount + $categoryActivityCount + $teacherSkillCount + $certification;

        // Mengambil semua kategori
        $allCategories = Category::with('skills')->get();
        $teacherSkills = TeacherSkill::with('skills.category')->get(); // with skills and category relationship

        // Menyiapkan labels (nama kategori)
        $labels = [];
        $resultsOffline = [];
        $resultsOnline = [];

        foreach ($allCategories as $category) {
            $labels[] = $category->name;

            // Offline
            $qualifiedTeacherCountOffline = $this->countQualifiedTeachers($teacherSkills, $category, 'OFFLINE');
            $resultsOffline[] = $qualifiedTeacherCountOffline;

            // Online
            $qualifiedTeacherCountOnline = $this->countQualifiedTeachers($teacherSkills, $category, 'ONLINE');
            $resultsOnline[] = $qualifiedTeacherCountOnline;
        }

        return view('dashboard.index', [
            'teachers' => $teachers,
            'teachersCount' => $teachersCount,
            'labels' => $labels,
            'dataOffline' => $resultsOffline,
            'dataOnline' => $resultsOnline,
            'totalCount' => $totalCount,
            'skillCount' => $skillCount,
            'teacherSkillCount' => $teacherSkillCount,
            'categoryCount' => $categoryCount,
            'activityCount' => $activityCount,
            'categoryActivityCount' => $categoryActivityCount,
            'certification' => $certification,
            'allCategories' => $allCategories,
        ]);
    }

    // Method to count qualified teachers based on category and type
    private function countQualifiedTeachers($teacherSkills, $category, $type) {
        $teacherSkillsInCategory = $teacherSkills->filter(function ($teacherSkill) use ($category, $type) {
            return $teacherSkill->skills->category->id === $category->id && $teacherSkill->skills->type === $type;
        });

        // Group skills by teacher ID
        $groupedByTeacher = $teacherSkillsInCategory->groupBy('teacher_id');

        // Count teachers with more than 3 distinct categories
        return $groupedByTeacher->filter(function ($skills) {
            return $skills->pluck('skills.category_id')->count() >= 3; // Use unique() for distinct categories
        })->count();
    }
}
