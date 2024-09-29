<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MstClass;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

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

    public function saveAttendance(Request $request)
    {
        $check = Attendance::check($request->studentId, $request->classId, $request->attendance_date);

        if (!empty($check)) {
            $model = $check;
        } else {
            $model = new Attendance();
            $model->student_id = $request->studentId;
            $model->class_id = $request->classId;
            $model->attendance_date = $request->attendance_date;
            $model->created_by = Auth::user()->id;
        }


        $model->attendance_type = $request->attendance_type;
        $model->save();

        $json['message'] = 'Attendance Successfully Marked.';

        echo json_encode($json);
    }

    public function attendanceReport(Request $request)
    {
        $getClass = MstClass::getClass();
        $data = Attendance::getRecords();
        return view('admin.attendance.report', [
            'getClass' => $getClass,
            'data' => $data,
        ]);
    }
}
