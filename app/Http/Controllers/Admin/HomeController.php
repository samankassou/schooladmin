<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $totals['teachers'] = User::role('Enseignant')->count();
        $totals['students'] = Student::count();
        $totals['classrooms'] = Classroom::count();
        return view('admin.dashboard', compact('totals'));
    }
}
