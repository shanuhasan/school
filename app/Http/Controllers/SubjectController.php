<?php

namespace App\Http\Controllers;

use App\Models\MstSubject;
use App\Models\ClassSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    public function index(Request $request){

        $subjects = MstSubject::getRecords();

        return view('admin.subject.index',[
            'subjects'=>$subjects
        ]);
    }

    public function create(){
        return view('admin.subject.create');
    }

    public function store(Request $request){
        
        $validator = Validator::make($request->all(),[
            // 'name'=>'required|unique:mst_subjects',
            'name'=>'required',
            'status'=>'required',
            'type'=>'required',
        ]);
        if($validator->passes()){

            $model = new MstSubject();
            $model->name = $request->name;
            $model->status = $request->status;
            $model->type = $request->type;
            $model->created_by = Auth::user()->id;
            $model->save();

            $request->session()->flash('success','Subject added successfully.');
            return response()->json([
                'status'=>true,
                'message'=>'Subject added successfully.'  
            ]);

        }else{
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()  
            ]);
        }
    }

    public function edit($id , Request $request){

        $subject = MstSubject::find($id);
        if(empty($subject))
        {
            return redirect()->route('subject.index');
        }

        return view('admin.subject.edit',compact('subject'));
        
    }

    public function update($id, Request $request){

        $model = MstSubject::find($id);
        if(empty($model))
        {
            $request->session()->flash('error','Subject not found.');
            return response()->json([
                'status'=>false,
                'notFound'=>true,
                'message'=>'Subject not found.'
            ]);
        }

        $validator = Validator::make($request->all(),[
            // 'name'=>'required|unique:mst_subjects,name,'.$model->id.',id',
            'name'=>'required',
            'status'=>'required',
            'type'=>'required',
        ]);

        if($validator->passes()){

            $model->name = $request->name;
            $model->status = $request->status;
            $model->type = $request->type;
            $model->save();

            $request->session()->flash('success','Subject updated successfully.');
            return response()->json([
                'status'=>true,
                'message'=>'Subject updated successfully.'  
            ]);

        }else{
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()  
            ]);
        }
    }
    
    public function destroy($id, Request $request){
        $model = MstSubject::find($id);
        if(empty($model))
        {
            $request->session()->flash('error','Subject not found.');
            return response()->json([
                'status'=>true,
                'message'=>'Subject not found.'
            ]);
        }

        $model->is_deleted = 1;
        $model->save();

        $request->session()->flash('success','Subject deleted successfully.');

        return response()->json([
            'status'=>true,
            'message'=>'Subject deleted successfully.'
        ]);

    }

    // for student panel
    public function studentSubjects(Request $request){

        $subjects = ClassSubject::studentSubjects();

        return view('student.subject',[
            'subjects'=>$subjects
        ]);
    }
    
}
