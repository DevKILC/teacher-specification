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
     

        // Menyiapkan labels (nama kategori)
        $labels = [];

        // Menyiapkan data jumlah skill berdasarkan kategori dan tipe untuk setiap labelss.koreksi
        $dataOffline = [];
        $dataOnline = [];

        foreach ($allCategories as $category) {

            $labels[] = $category->name ;

            $countOffline = TeacherSkill::whereHas('skills', function($query) use ($category) {
                $query->where('category_id', $category->id)
                      ->where('type', 'OFFLINE')
                      ->whereNull('deleted_at');
            })->count();
    
            // Menghitung jumlah teacher_skills untuk tipe ONLINE
            $countOnline = TeacherSkill::whereHas('skills', function($query) use ($category) {
                $query->where('category_id', $category->id)
                      ->where('type', 'ONLINE')
                      ->whereNull('deleted_at');
            })->count();

           
                $dataOffline[] = $countOffline;
                $dataOnline[] = $countOnline;
            
        }

        return view('dashboard.index', [
            'teachers' => $teachers,
            'teachersCount' => $teachersCount,
            'labels' => $labels,
            'dataOffline' => $dataOffline,
            'dataOnline' => $dataOnline,
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
