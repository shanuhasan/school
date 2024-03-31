<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Week;
use App\Models\ClassSubject;
use App\Models\ExamSchedule;
use Illuminate\Support\Facades\Auth;
use App\Models\ClassSubjectTimetable;

class CalendarController extends Controller
{
    public function index()
    {
        $data['timetable'] = $this->getTimetable(Auth::user()->class_id);
        $data['examTimetable'] = $this->getExamTimetable(Auth::user()->class_id);
        return view('student.calendar', $data);
    }

    public function getTimetable($classId)
    {
        $subjects = ClassSubject::studentSubjects($classId);

        $data = [];
        foreach ($subjects as $subject) {
            $subArr['name'] = getSubjectName($subject->subject_id);
            $getWeek = Week::getRecords();

            $week = [];
            foreach ($getWeek as $vl) {
                $wd = [];
                $wd['week_name'] = $vl->name;
                $wd['calendar_day'] = $vl->calendar_day;
                $model = ClassSubjectTimetable::getClassAndSubject($subject->class_id, $subject->subject_id, $vl->id);
                if (!empty($model)) {
                    $wd['start_time'] = $model->start_time;
                    $wd['end_time'] = $model->end_time;
                    $wd['room_no'] = $model->room_no;
                    $week[] = $wd;
                }
            }
            $subArr['week'] = $week;
            $data[] = $subArr;
        }
        return $data;
    }

    public function getExamTimetable($classId)
    {
        $exam = ExamSchedule::findByClassId($classId);

        $data = [];
        foreach ($exam as $item) {
            $subArr['exam_name'] = getExamName($item->exam_id);

            $getExamTimetable = ExamSchedule::findByExamIdAndClassId($item->exam_id, $classId);

            $examData = [];
            foreach ($getExamTimetable as $vl) {
                $ed = [];
                $ed['subject_name'] = getSubjectName($vl->subject_id);
                $ed['exam_date'] = $vl->exam_date;
                $ed['start_time'] = $vl->start_time;
                $ed['end_time'] = $vl->end_time;
                $ed['room_no'] = $vl->room_no;
                $ed['marks'] = $vl->marks;
                $ed['passing_marks'] = $vl->passing_marks;
                $examData[] = $ed;
            }
            $subArr['examData'] = $examData;
            $data[] = $subArr;
        }
        return $data;
    }

    // parent side
    public function childrenCalendar($guid)
    {
        $student = User::findByGuid($guid);

        $data['timetable'] = $this->getTimetable($student->class_id);
        $data['examTimetable'] = $this->getExamTimetable($student->class_id);
        $data['student'] = $student;
        return view('parent.calendar', $data);
    }
}
