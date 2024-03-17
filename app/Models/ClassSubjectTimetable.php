<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSubjectTimetable extends Model
{
    use HasFactory;

    static public function getClassAndSubject($classId, $subjectId, $weekId)
    {
        return self::where('class_id', $classId)->where('subject_id', $subjectId)->where('week_id', $weekId)->first();
    }
}
