<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        if(Auth::user()->role == 1)
        {
            return view('admin.dashboard');
        }
        else if(Auth::user()->role == 2)
        {
            return view('teacher.dashboard');
        }
        else if(Auth::user()->role == 3)
        {
            return view('student.dashboard');
        }
        else if(Auth::user()->role == 4)
        {
            return view('parent.dashboard');
        }
        
    }
}
