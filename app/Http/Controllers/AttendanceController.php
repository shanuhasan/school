<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MstClass;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function attendance(Request $request)
    {
        $getClass = MstClass::getClass();

        $students = [];
        if (!empty($request->get('class_id')) && !empty($request->get('attendance_date'))) {
            $students = User::findByClassId($request->class_id);
        }

        return view('admin.attendance.student', [
            'getClass' => $getClass,
            'students' => $students,
        ]);
    }
}
