<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\MstClass;
use App\Models\ClassSubject;
use App\Models\ExamSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        $exams = Exam::getExams();

        return view('admin.exam.index', [
            'exams' => $exams
        ]);
    }

    public function create()
    {
        return view('admin.exam.create');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
        ]);

        if ($validator->passes()) {
            $model = new Exam();
            $model->name = $request->name;
            $model->note = $request->note;
            $model->status = $request->status;
            $model->created_by = Auth::user()->id;
            $model->save();
            session()->flash('success', 'Exam added successfully.');
            return response()->json([
                'status' => true
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit($id, Request $request)
    {

        $exam = Exam::find($id);
        if (empty($exam)) {
            return redirect()->route('admin.exam.index');
        }

        return view('admin.exam.edit', compact('exam'));
    }

    public function update($id, Request $request)
    {

        $model = Exam::find($id);
        if (empty($model)) {
            $request->session()->flash('error', 'Exam not found.');
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Exam not found.'
            ]);
        }

        $validator = Validator::make($request->all(), [
            // 'email' => 'required|email|unique:users,email,' . $id . ',id',
            'name' => 'required|min:3',
        ]);

        if ($validator->passes()) {
            $model->name = $request->name;
            $model->note = $request->note;
            $model->status = $request->status;
            // $model->created_by = Auth::user()->id;
            $model->save();
            $request->session()->flash('success', 'Exam updated successfully.');
            return response()->json([
                'status' => true,
                'message' => 'Exam updated successfully.'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function destroy($id, Request $request)
    {
        $model = Exam::find($id);
        if (empty($model)) {
            $request->session()->flash('error', 'Exam not found.');
            return response()->json([
                'status' => true,
                'message' => 'Exam not found.'
            ]);
        }

        $model->is_deleted = 1;
        $model->save();

        $request->session()->flash('success', 'Exam deleted successfully.');

        return response()->json([
            'status' => true,
            'message' => 'Exam deleted successfully.'
        ]);
    }

    public function examSchedule(Request $request)
    {
        $getClass = MstClass::getClass();
        $getExams = Exam::getRecoards();

        $data = [];
        if (!empty($request->class_id) && !empty($request->exam_id)) {
            $classSub = ClassSubject::findByClassId($request->class_id);
            foreach ($classSub as $item) {
                $arr = [];
                $arr['subject_id'] = $item->subject_id;
                $arr['class_id'] = $item->class_id;

                $model = ExamSchedule::findByExamIdClassIdAndSubjectId($request->exam_id, $request->class_id, $item->subject_id);
                if (!empty($model)) {
                    $arr['exam_date'] = $model->exam_date;
                    $arr['start_time'] = $model->start_time;
                    $arr['end_time'] = $model->end_time;
                    $arr['room_no'] = $model->room_no;
                    $arr['marks'] = $model->marks;
                    $arr['passing_marks'] = $model->passing_marks;
                } else {
                    $arr['exam_date'] = '';
                    $arr['start_time'] = '';
                    $arr['end_time'] = '';
                    $arr['room_no'] = '';
                    $arr['marks'] = '';
                    $arr['passing_marks'] = '';
                }

                $data[] = $arr;
            }
        }

        return view('admin.exam.shedule', [
            'getClass' => $getClass,
            'getExams' => $getExams,
            'data' => $data,
            // 'getSubjects' => $getSubjects,
            // 'week' => $week,
        ]);
    }

    public function storeSchedule(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class_id' => 'required',
            'exam_id' => 'required',
        ]);
        if ($validator->passes()) {

            ExamSchedule::where('class_id', $request->class_id)->where('exam_id', $request->exam_id)->delete();
            foreach ($request->schedule as $schedule) {

                if (!empty($schedule['subject_id']) && !empty($schedule['exam_date']) && !empty($schedule['start_time']) && !empty($schedule['end_time']) && !empty($schedule['room_no']) && !empty($schedule['marks']) && !empty($schedule['passing_marks'])) {
                    $model = new ExamSchedule();
                    $model->exam_id = $request->exam_id;
                    $model->class_id = $request->class_id;
                    $model->subject_id = $schedule['subject_id'];
                    $model->exam_date = $schedule['exam_date'];
                    $model->start_time = $schedule['start_time'];
                    $model->end_time = $schedule['end_time'];
                    $model->room_no = $schedule['room_no'];
                    $model->marks = $schedule['marks'];
                    $model->passing_marks = $schedule['passing_marks'];
                    $model->created_by = Auth::user()->id;
                    $model->save();
                }
            }

            $request->session()->flash('success', 'Exam Schedule successfully saved.');
            return response()->json([
                'status' => true,
                'message' => 'Exam Schedule successfully saved.'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
}
