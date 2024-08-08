<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
