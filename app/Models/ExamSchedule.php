<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSchedule extends Model
{
    use HasFactory;

    static public function findByExamIdClassIdAndSubjectId($examId, $classId, $subjectId)
    {
        return self::where('exam_id', $examId)->where('class_id', $classId)->where('subject_id', $subjectId)->first();
    }
}
