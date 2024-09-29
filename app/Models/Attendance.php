<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    const PRESENT = 1;
    const ABSENT = 2;
    const LATE = 3;
    const HALF_DAY = 4;

    static public function check($studentId, $classId, $date)
    {
        return self::where('student_id', '=', $studentId)
            ->where('class_id', '=', $classId)
            ->where('attendance_date', '=', $date)
            ->first();
    }

    static public function getRecords()
    {
        $data =  self::select('attendances.*');

        if (!empty(Request::get('class_id'))) {
            $data = $data->where('class_id', '=', Request::get('class_id'));
        }
        if (!empty(Request::get('attendance_date'))) {
            $data = $data->where('attendance_date', '=', Request::get('attendance_date'));
        }
        if (!empty(Request::get('attendance_type'))) {
            $data = $data->where('attendance_type', '=', Request::get('attendance_type'));
        }
        $data = $data->paginate(50);

        return $data;
    }

    public static function getAttendanceDropdown($key = null)
    {
        $list = [
            self::PRESENT => 'Present',
            self::ABSENT => 'Absent',
            self::LATE => 'Late',
            self::HALF_DAY => 'Half Day'
        ];

        if (isset($list[$key])) {
            return $list[$key];
        }

        return $list;
    }
}
