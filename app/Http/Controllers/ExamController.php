<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\User;
use App\Models\MstClass;
use App\Models\ClassSubject;
use App\Models\ExamSchedule;
use Illuminate\Http\Request;
use App\Models\AssignClassTeacher;
use App\Models\MarkRegister;
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

    public function marksRegister(Request $request)
    {
        $getClass = MstClass::getClass();
        $getExams = Exam::getRecoards();

        $subjects = $students = [];
        if (!empty($request->class_id) && !empty($request->exam_id)) {
            $subjects = ExamSchedule::getSubjects($request->exam_id, $request->class_id);
            $students = User::findByClassId($request->class_id);
        }

        return view('admin.exam.marks_register', [
            'getClass' => $getClass,
            'getExams' => $getExams,
            'subjects' => $subjects,
            'students' => $students,
        ]);
    }

    public function marksRegisterStore(Request $request)
    {
        $error = 0;
        foreach ($request->marks as $mark) {
            $examSchedule = ExamSchedule::findById($mark['id']);
            $fullMarks = $examSchedule->marks;
            $passingMarks = $examSchedule->passing_marks;

            // $classWork = !empty($mark['class_work']) ? $mark['class_work'] : 0;
            // $homeWork = !empty($mark['home_work']) ? $mark['home_work'] : 0;
            // $testWork = !empty($mark['test_work']) ? $mark['test_work'] : 0;
            $exam = !empty($mark['exam']) ? $mark['exam'] : 0;

            // $totalMarks = $classWork + $homeWork + $testWork + $exam;
            $totalMarks = $exam;

            if ($fullMarks >= $totalMarks) {
                $check = MarkRegister::findByStudentIdExamIdClassIdAndSubjectId($request->student_id, $request->exam_id, $request->class_id, $mark['subject_id']);

                if (!empty($check)) {
                    $model = $check;
                } else {
                    $model = new MarkRegister();
                }

                $model->student_id = $request->student_id;
                $model->exam_id = $request->exam_id;
                $model->class_id = $request->class_id;
                $model->subject_id = $mark['subject_id'];
                // $model->class_work = $classWork;
                // $model->home_work = $homeWork;
                // $model->test_work = $testWork;
                $model->exam = $exam;
                $model->marks = $fullMarks;
                $model->passing_marks = $passingMarks;
                $model->created_by = Auth::user()->id;
                $model->save();
            } else {
                $error = 1;
            }
        }
        if ($error == 0) {
            $request->session()->flash('success', 'Marks Register successfully saved.');
            return response()->json([
                'status' => true,
                'message' => 'Marks Register successfully saved.'
            ]);
        } else {
            $request->session()->flash('error', 'Some Marks not save. Becouse Some Total Marks Greater then Full Marks.');
            return response()->json([
                'status' => false,
                'message' => 'Some Marks not save. Becouse Some Total Marks Greater then Full Marks.'
            ]);
        }
    }

    public function marksRegisterSingleStore(Request $request)
    {
        $id = $request->id;
        $examSchedule = ExamSchedule::findById($id);
        $fullMarks = $examSchedule->marks;
        $passingMarks = $examSchedule->passing_marks;

        $classWork = !empty($request->classWork) ? $request->classWork : 0;
        $homeWork = !empty($request->homeWork) ? $request->homeWork : 0;
        $testWork = !empty($request->testWork) ? $request->testWork : 0;
        $exam = !empty($request->exam) ? $request->exam : 0;

        $totalMarks = $classWork + $homeWork + $testWork + $exam;

        if ($fullMarks >= $totalMarks) {
            $check = MarkRegister::findByStudentIdExamIdClassIdAndSubjectId($request->studentId, $request->examId, $request->classId, $request->subjectId);

            if (!empty($check)) {
                $model = $check;
            } else {
                $model = new MarkRegister();
                $model->created_by = Auth::user()->id;
            }

            $model->student_id = $request->studentId;
            $model->exam_id = $request->examId;
            $model->class_id = $request->classId;
            $model->subject_id = $request->subjectId;
            // $model->class_work = $classWork;
            // $model->home_work = $homeWork;
            // $model->test_work = $testWork;
            $model->exam = $exam;
            $model->marks = $fullMarks;
            $model->passing_marks = $passingMarks;
            $model->save();

            $request->session()->flash('success', 'Marks Register successfully saved.');
            return response()->json([
                'status' => true,
                'message' => 'Marks Register successfully saved.'
            ]);
        } else {
            $request->session()->flash('error', 'Your Total Marks Greater then Full Marks.');
            return response()->json([
                'status' => false,
                'message' => 'Your Total Marks Greater then Full Marks.'
            ]);
        }
    }

    // for student panel
    public function studentExamTimetable()
    {
        $classId = Auth::user()->class_id;
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

        return view('student.exam_timetable', [
            'data' => $data,
        ]);
    }

    public function studentExamResult()
    {
        $studentId = Auth::user()->id;
        $exam = MarkRegister::getExamByStudentId($studentId);

        $data = [];
        foreach ($exam as $item) {
            $subArr['exam_name'] = getExamName($item->exam_id);

            $getExamSubject = MarkRegister::findByExamIdAndStudentId($item->exam_id, $studentId);

            $subjects = [];
            foreach ($getExamSubject as $vl) {
                $ed = [];
                $ed['subject_name'] = getSubjectName($vl->subject_id);
                $ed['class_work'] = $vl->class_work;
                $ed['home_work'] = $vl->home_work;
                $ed['test_work'] = $vl->test_work;
                $ed['exam'] = $vl->exam;
                // $ed['total_score'] = $vl->class_work + $vl->home_work + $vl->test_work + $vl->exam;
                $ed['total_score'] = $vl->exam;
                $ed['marks'] = $vl->marks;
                $ed['passing_marks'] = $vl->passing_marks;
                $subjects[] = $ed;
            }
            $subArr['subjects'] = $subjects;
            $data[] = $subArr;
        }

        return view('student.exam_result', [
            'data' => $data,
        ]);
    }

    // for teacher panel
    public function teacherExamTimetable()
    {
        $teacherId = Auth::user()->id;
        $getClass = AssignClassTeacher::findByTeacherId($teacherId);

        $data = [];
        foreach ($getClass as $item) {
            $dataC = [];
            $dataC['class_name'] = getClassName($item->class_id);

            $exam = ExamSchedule::findByClassId($item->class_id);

            $examArr = [];
            foreach ($exam as $vl) {
                $dataE = [];
                $dataE['exam_name'] = getExamName($vl->exam_id);

                $getExamTimetable = ExamSchedule::findByExamIdAndClassId($vl->exam_id, $item->class_id);
                $subjectArr = [];
                foreach ($getExamTimetable as $vl) {
                    $dataS = [];
                    $dataS['subject_name'] = getSubjectName($vl->subject_id);
                    $dataS['exam_date'] = $vl->exam_date;
                    $dataS['start_time'] = $vl->start_time;
                    $dataS['end_time'] = $vl->end_time;
                    $dataS['room_no'] = $vl->room_no;
                    $dataS['marks'] = $vl->marks;
                    $dataS['passing_marks'] = $vl->passing_marks;
                    $subjectArr[] = $dataS;
                }
                $dataE['subject'] = $subjectArr;
                $examArr[] = $dataE;
            }
            $dataC['exam'] = $examArr;
            $data[] = $dataC;
        }

        // pre($data);

        return view('teacher.exam_timetable', [
            'data' => $data,
        ]);
    }

    public function marksRegisterTeacher(Request $request)
    {
        $teacherId = Auth::user()->id;
        $getClass = AssignClassTeacher::findByTeacherId($teacherId);
        $getExams = ExamSchedule::findByTeacherId($teacherId);
        // pre($getExams);
        // $getExams = Exam::getRecoards();

        $subjects = $students = [];
        if (!empty($request->class_id) && !empty($request->exam_id)) {
            $subjects = ExamSchedule::getSubjects($request->exam_id, $request->class_id);
            $students = User::findByClassId($request->class_id);
        }

        return view('teacher.marks_register', [
            'getClass' => $getClass,
            'getExams' => $getExams,
            'subjects' => $subjects,
            'students' => $students,
        ]);
    }

    // for parent panel
    public function parentChildrenExamTimetable($studentGuid)
    {
        $student = User::findByGuid($studentGuid);
        $classId = $student->class_id;
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

        return view('parent.exam_timetable', [
            'data' => $data,
            'student' => $student,
        ]);
    }
}
