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

    static public function getExamTimetable($teacherId)
    {
        return self::select('exam_schedules.*', 'mst_classes.name as class_name', 'mst_subjects.name as subject_name', 'exams.name as exam_name')
            ->join('assign_class_teachers', 'assign_class_teachers.class_id', '=', 'exam_schedules.class_id')
            ->join('mst_classes', 'mst_classes.id', 'exam_schedules.class_id')
            ->join('mst_subjects', 'mst_subjects.id', 'exam_schedules.subject_id')
            ->join('exams', 'exams.id', 'exam_schedules.exam_id')
            ->where('assign_class_teachers.teacher_id', $teacherId)
            ->get();
    }
}
