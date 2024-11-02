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
        // menhitung data
        $teachersCount = Teacher::count();
        $skillCount =  Skill::count();
        $categoryCount = Category::count();
        $activityCount =  Record::count();
        $categoryActivityCount = CategoryActivity::count();
        $teacherSkillCount = TeacherSkill::count();
        $certification = Certification::count();

        $totalCount = $teachersCount + $skillCount + $categoryCount + $activityCount + $categoryActivityCount + $teacherSkillCount + $certification;


        // Mengambil semua kategori
        $allCategories = Category::with('skills')->get();

        $teacherSkills = TeacherSkill::with('skills.category')->get();  // with skills and category relationship

     

    // Menyiapkan labels (nama kategori)
$labels = [];

// Menyiapkan data jumlah skill berdasarkan kategori dan tipe untuk setiap label
$dataOffline = [];
$dataOnline = [];

foreach ($allCategories as $category) {
    $labels[] = $category->name;

    // Offline
    $teacherSkillsInCategory = $teacherSkills->filter(function ($teacherSkill) use ($category) {
        return $teacherSkill->skills->category->id === $category->id &&  $teacherSkill->skills->type === 'OFFLINE';
    });

    // Group skills by teacher ID
    $groupedByTeacher = $teacherSkillsInCategory->groupBy('teacher_id');

    // Count teachers with more than 3 distinct categories
    $qualifiedTeacherCount = $groupedByTeacher->filter(function ($skills) {
        return $skills->pluck('skills.category_id')->count() >= 3;
    })->count();

    // Add result to the output array
    $resultsOffline[] = [
        'total_teacher' => $qualifiedTeacherCount,
    ];

    // Online
    $teacherSkillsInCategory = $teacherSkills->filter(function ($teacherSkill) use ($category) {
        return $teacherSkill->skills->category->id === $category->id &&  $teacherSkill->skills->type === 'ONLINE';
    });

    // Group skills by teacher ID
    $groupedByTeacher = $teacherSkillsInCategory->groupBy('teacher_id');

    // Count teachers with more than 3 distinct categories
    $qualifiedTeacherCount = $groupedByTeacher->filter(function ($skills) {
        return $skills->pluck('skills.category_id')->count() >= 3;
    })->count();

    // Add result to the output array
    $resultsOnline[] = [
        'total_teacher' => $qualifiedTeacherCount,
    ];
  
}

        return view('dashboard.index', [
            'teachers' => $teachers,
            'teachersCount' => $teachersCount,
            'labels' => $labels,
            'dataOffline' => $resultsOffline['total_teacher'],
            'dataOnline' => $resultsOnline['total_teacher'],
            'totalCount' => $totalCount,
            'skillCount' => $skillCount,
            'teacherSkillCount' => $teacherSkillCount,
            'categoryCount' => $categoryCount,
            'activityCount' => $activityCount,
            'categoryActivityCount' => $categoryActivityCount,
            'teacherSkillCount' => $teacherSkillCount,
            'certification' => $certification,
            'allCategories' => $allCategories,

        ]);
    }
}
