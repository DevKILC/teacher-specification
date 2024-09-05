<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class DahsboardController extends Controller
{
    function index(){
        
        $teachers =  Teacher::with('certifications')->get();
        $TeachersCount = Teacher::count();

        $labels = ['Bulan 1', 'Bulan 2', 'Bulan 3', 'Bulan 4', 'Bulan 5','Bulan 6','Camp','IELTS'];
        $data = [ 10,40,70,90,20,100,30,40];

        return view('dashboard.index',[
            'teachers' => $teachers,
            'TeachersCount' => $TeachersCount,
            'labels' => $labels,
            'data' => $data
        ]);
    }
}
