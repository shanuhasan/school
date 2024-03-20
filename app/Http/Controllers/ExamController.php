<?php

namespace App\Http\Controllers;

use App\Models\Exam;
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
}
