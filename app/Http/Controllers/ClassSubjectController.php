<?php

namespace App\Http\Controllers;

use App\Models\MstClass;
use App\Models\MstSubject;
use App\Models\ClassSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ClassSubjectController extends Controller
{
    public function index(Request $request){

        $getClass = MstClass::getClass();
        $getSubject = MstSubject::getSubject();
        $subjects = ClassSubject::getRecords();

        return view('admin.assign-subject.index',[
            'subjects'=>$subjects,
            'getClass'=>$getClass,
            'getSubject'=>$getSubject,
        ]);
    }

    public function create(){

        $getClass = MstClass::getClass();
        $getSubject = MstSubject::getSubject();
        return view('admin.assign-subject.create',[
            'getClass' => $getClass,
            'getSubject' => $getSubject,
        ]);
    }

    public function store(Request $request){
        
        $validator = Validator::make($request->all(),[
            'class_id'=>'required',
            'subject_id'=>'required',
            'status'=>'required',
        ]);
        if($validator->passes()){

            foreach($request->subject_id as $subjectId)
            {
                //check class subject alredy exists
                $check = ClassSubject::checkClassSubject($request->class_id,$subjectId);

                if(!empty($check))
                {
                    $check->status = $request->status;
                    $check->save();

                }else{
                    $model = new ClassSubject();
                    $model->class_id = $request->class_id;
                    $model->subject_id = $subjectId;
                    $model->status = $request->status;
                    $model->created_by = Auth::user()->id;
                    $model->save();
                }                
            }
            $request->session()->flash('success','Subject Assign to Class successfully.');
            return response()->json([
                'status'=>true,
                'message'=>'Subject Assign to Class successfully.'  
            ]);

        }else{
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()  
            ]);
        }
    }

    public function edit($id , Request $request){

        $subject = ClassSubject::find($id);
        
        if(empty($subject))
        {
            return redirect()->route('assign_subject.index');
        }

        $getClass = MstClass::getClass();
        $getSubject = MstSubject::getSubject();

        $subjectIds = ClassSubject::getAssignSubjectId($subject->class_id);

        return view('admin.assign-subject.edit',[
            'subject' =>$subject,
            'getClass' =>$getClass,
            'getSubject' =>$getSubject,
            'subjectIds' =>$subjectIds,
        ]);
        
    }

    public function update($id, Request $request){

        $model = ClassSubject::find($id);

        // echo "<pre>";print_r($model->class_id);die;
        $validator = Validator::make($request->all(),[
            'class_id'=>'required',
            'subject_id'=>'required',
            'status'=>'required',
        ]);

        if($validator->passes()){

            ClassSubject::where('class_id',[$model->class_id])->delete();
            ClassSubject::where('class_id',[$request->class_id])->delete();

            foreach($request->subject_id as $subjectId)
            {
                //check class subject alredy exists
                $check = ClassSubject::checkClassSubject($request->class_id,$subjectId);

                if(!empty($check))
                {
                    $check->status = $request->status;
                    $check->save();

                }else{
                    $model = new ClassSubject();
                    $model->class_id = $request->class_id;
                    $model->subject_id = $subjectId;
                    $model->status = $request->status;
                    $model->created_by = Auth::user()->id;
                    $model->save();
                }          
            }
            $request->session()->flash('success','Subject Assign to Class successfully.');
            return response()->json([
                'status'=>true,
                'message'=>'Subject Assign to Class successfully.'  
            ]);

        }else{
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()  
            ]);
        }
    }
    
    public function destroy($id, Request $request){
        $model = ClassSubject::find($id);
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

    public function singleEdit($id , Request $request){

        $subject = ClassSubject::find($id);
        
        if(empty($subject))
        {
            return redirect()->route('assign_subject.index');
        }

        $getClass = MstClass::getClass();
        $getSubject = MstSubject::getSubject();

        return view('admin.assign-subject.single_edit',[
            'subject' =>$subject,
            'getClass' =>$getClass,
            'getSubject' =>$getSubject,
        ]);
    }

    public function singleUpdate($id, Request $request){

        $validator = Validator::make($request->all(),[
            'class_id'=>'required',
            'subject_id'=>'required',
            'status'=>'required',
        ]);

        if($validator->passes()){
            //check class subject alredy exists
            $check = ClassSubject::checkClassSubject($request->class_id,$request->subject_id);
            if(!empty($check))
            {
                $check->status = $request->status;
                $check->save();

                $msg = 'Status successfully updated.';

            }else{
                $model = ClassSubject::find($id);
                $model->class_id = $request->class_id;
                $model->subject_id = $request->subject_id;
                $model->status = $request->status;
                $model->save();

                $msg = 'Subject Assign to Class successfully.';
            }

            $request->session()->flash('success',$msg);
            return response()->json([
                'status' => true,
                'message' => $msg  
            ]);

        }else{
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()  
            ]);
        }
    }
}
