<?php

namespace App\Http\Controllers;

use App\Models\MarkGrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MarksGradeController extends Controller
{
    public function index(Request $request)
    {
        $marksGrade = MarkGrade::getRecords();

        return view('admin.marks_grade.index', [
            'marksGrade' => $marksGrade
        ]);
    }

    public function create()
    {
        return view('admin.marks_grade.create');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:mark_grades',
        ]);
        if ($validator->passes()) {

            $model = new MarkGrade();
            $model->name = $request->name;
            $model->percent_from = $request->percent_from;
            $model->percent_to = $request->percent_to;
            $model->created_by = Auth::user()->id;
            $model->save();

            $request->session()->flash('success', 'Marks Grade added successfully.');
            return response()->json([
                'status' => true,
                'message' => 'Marks Grade added successfully.'
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
        $grade = MarkGrade::find($id);
        if (empty($grade)) {
            return redirect()->route('admin.marks_grade.index');
        }

        return view('admin.marks_grade.edit', compact('grade'));
    }

    public function update($id, Request $request)
    {

        $model = MarkGrade::find($id);
        if (empty($model)) {
            $request->session()->flash('error', 'Marks Grade not found.');
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Marks Grade not found.'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:mark_grades,name,' . $model->id . ',id',
        ]);

        if ($validator->passes()) {

            $model->name = $request->name;
            $model->percent_from = $request->percent_from;
            $model->percent_to = $request->percent_to;
            $model->save();

            $request->session()->flash('success', 'Marks Grade updated successfully.');
            return response()->json([
                'status' => true,
                'message' => 'Marks Grade updated successfully.'
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
        $model = MarkGrade::find($id);
        if (empty($model)) {
            $request->session()->flash('error', 'Marks Grade not found.');
            return response()->json([
                'status' => true,
                'message' => 'Marks Grade not found.'
            ]);
        }

        $model->delete();

        $request->session()->flash('success', 'Marks Grade deleted successfully.');

        return response()->json([
            'status' => true,
            'message' => 'Marks Grade deleted successfully.'
        ]);
    }
}
