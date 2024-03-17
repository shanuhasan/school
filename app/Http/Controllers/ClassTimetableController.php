<?php

namespace App\Http\Controllers;

use App\Models\Week;
use App\Models\MstClass;
use App\Models\ClassSubject;
use App\Models\ClassSubjectTimetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassTimetableController extends Controller
{
    public function index(Request $request)
    {

        $getClass = MstClass::getClass();

        $getSubjects = [];
        if (!empty($request->class_id)) {
            $getSubjects = ClassSubject::studentSubjects($request->class_id);
        }

        $getWeek = Week::getRecords();

        $week = [];
        foreach ($getWeek as $vl) {
            $wd = [];
            $wd['week_id'] = $vl->id;
            $wd['week_name'] = $vl->name;

            if (!empty($request->class_id) && !empty($request->subject_id)) {
                $model = ClassSubjectTimetable::getClassAndSubject($request->class_id, $request->subject_id, $vl->id);
                if (!empty($model)) {
                    $wd['start_time'] = $model->start_time;
                    $wd['end_time'] = $model->end_time;
                    $wd['room_no'] = $model->room_no;
                } else {
                    $wd['start_time'] = '';
                    $wd['end_time'] = '';
                    $wd['room_no'] = '';
                }
            } else {
                $wd['start_time'] = '';
                $wd['end_time'] = '';
                $wd['room_no'] = '';
            }

            $week[] = $wd;
        }

        return view('admin.class_timetable.index', [
            'getClass' => $getClass,
            'getSubjects' => $getSubjects,
            'week' => $week,
        ]);
    }

    public function getSubject(Request $request)
    {

        $getSubjects = ClassSubject::studentSubjects($request->class_id);

        $html = '<option>Select</option>';
        foreach ($getSubjects as $value) {
            $html .= '<option value="' . $value->subject_id . '">' . getSubjectName($value->subject_id) . '</option>';
        }

        $json['html'] = $html;

        echo json_encode($json);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class_id' => 'required',
            'subject_id' => 'required',
        ]);
        if ($validator->passes()) {

            ClassSubjectTimetable::where('class_id', $request->class_id)->where('subject_id', $request->subject_id)->delete();
            foreach ($request->timetable as $timetable) {

                if (!empty($timetable['week_id']) && !empty($timetable['start_time']) && !empty($timetable['end_time']) && !empty($timetable['room_no'])) {
                    $model = new ClassSubjectTimetable();
                    $model->class_id = $request->class_id;
                    $model->subject_id = $request->subject_id;
                    $model->week_id = $timetable['week_id'];
                    $model->start_time = $timetable['start_time'];
                    $model->end_time = $timetable['end_time'];
                    $model->room_no = $timetable['room_no'];
                    $model->save();
                }
            }

            $request->session()->flash('success', 'Class Timetable successfully saved.');
            return response()->json([
                'status' => true,
                'message' => 'Class Timetable successfully saved.'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
}
