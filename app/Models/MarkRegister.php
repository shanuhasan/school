<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarkRegister extends Model
{
    use HasFactory;

    static public function findByStudentIdExamIdClassIdAndSubjectId($studentId, $examId, $classId, $subjectId)
    {
        return self::where('student_id', '=', $studentId)
            ->where('exam_id', '=', $examId)
            ->where('class_id', '=', $classId)
            ->where('subject_id', '=', $subjectId)
            ->first();
    }
}
