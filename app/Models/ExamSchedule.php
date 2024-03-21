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

    static public function findByClassId($classId)
    {
        return self::where('class_id', $classId)->groupBy('exam_id')->orderBy('id', 'DESC')->get();
    }

    static public function findByExamIdAndClassId($examId, $classId)
    {
        return self::where('exam_id', $examId)->where('class_id', $classId)->orderBy('exam_date', 'ASC')->get();
    }
}
