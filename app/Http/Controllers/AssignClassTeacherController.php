<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MstClass;
use App\Models\MstSubject;
use Illuminate\Http\Request;
use App\Models\AssignClassTeacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AssignClassTeacherController extends Controller
{
    public function index(Request $request){

        $getClass = MstClass::getClass();
        $getTeacher = User::getClassTeachers();
        $classTeachers = AssignClassTeacher::getRecords();

        return view('admin.assign_class_teacher.index',[
            'classTeachers'=>$classTeachers,
            'getClass'=>$getClass,
            'getTeacher'=>$getTeacher,
        ]);
    }

    public function create(){

        $getClass = MstClass::getClass();
        $getTeacher = User::getClassTeachers();
        return view('admin.assign_class_teacher.create',[
            'getClass' => $getClass,
            'getTeacher' => $getTeacher,
        ]);
    }

    public function store(Request $request){
        
        $validator = Validator::make($request->all(),[
            'class_id'=>'required',
            'teacher_id'=>'required',
            'status'=>'required',
        ]);
        if($validator->passes()){

            foreach($request->teacher_id as $teacherId)
            {
                //check class teacher alredy exists
                $check = AssignClassTeacher::checkClassTeacher($request->class_id,$teacherId);

                if(!empty($check))
                {
                    $check->status = $request->status;
                    $check->is_deleted = 0;
                    $check->save();

                }else{
                    $model = new AssignClassTeacher();
                    $model->class_id = $request->class_id;
                    $model->teacher_id = $teacherId;
                    $model->status = $request->status;
                    $model->created_by = Auth::user()->id;
                    $model->save();
                }                
            }
            $request->session()->flash('success','Class Assign to Teacher successfully.');
            return response()->json([
                'status'=>true,
                'message'=>'Class Assign to Teacher successfully.'  
            ]);

        }else{
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()  
            ]);
        }
    }

    public function edit($id , Request $request){

        $teacher = AssignClassTeacher::find($id);

        if(empty($teacher))
        {
            return redirect()->route('assign_subject.index');
        }

        $getClass = MstClass::getClass();
        $getTeacher = User::getClassTeachers();

        $teacherIds = AssignClassTeacher::getAssignClassTeacherId($teacher->class_id);

        return view('admin.assign_class_teacher.edit',[
            'teacher' =>$teacher,
            'getClass' =>$getClass,
            'getTeacher' =>$getTeacher,
            'teacherIds' =>$teacherIds,
        ]);
        
    }

    public function update($id, Request $request){

        $model = AssignClassTeacher::find($id);

        // echo "<pre>";print_r($model->class_id);die;
        $validator = Validator::make($request->all(),[
            'class_id'=>'required',
            'teacher_id'=>'required',
            'status'=>'required',
        ]);

        if($validator->passes()){

            AssignClassTeacher::where('class_id',[$model->class_id])->delete();
            AssignClassTeacher::where('class_id',[$request->class_id])->delete();

            foreach($request->teacher_id as $teacherId)
            {
                //check class subject alredy exists
                $check = AssignClassTeacher::checkClassTeacher($request->class_id,$teacherId);

                if(!empty($check))
                {
                    $check->status = $request->status;
                    $check->save();

                }else{
                    $model = new AssignClassTeacher();
                    $model->class_id = $request->class_id;
                    $model->teacher_id = $teacherId;
                    $model->status = $request->status;
                    $model->created_by = Auth::user()->id;
                    $model->save();
                }          
            }
            $request->session()->flash('success','Class Assign to Teacher successfully.');
            return response()->json([
                'status'=>true,
                'message'=>'Class Assign to Teacher successfully.'  
            ]);

        }else{
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()  
            ]);
        }
    }
    
    public function destroy($id, Request $request){
        $model = AssignClassTeacher::find($id);
        if(empty($model))
        {
            $request->session()->flash('error','Class Teacher not found.');
            return response()->json([
                'status'=>true,
                'message'=>'Class Teacher not found.'
            ]);
        }

        $model->is_deleted = 1;
        $model->save();

        $request->session()->flash('success','Class Teacher deleted successfully.');

        return response()->json([
            'status'=>true,
            'message'=>'Class Teacher deleted successfully.'
        ]);

    }

    public function singleEdit($id , Request $request){

        $teacher = AssignClassTeacher::find($id);
        
        if(empty($teacher))
        {
            return redirect()->route('assign_subject.index');
        }

        $getClass = MstClass::getClass();
        $getTeacher = User::getClassTeachers();

        return view('admin.assign_class_teacher.single_edit',[
            'teacher' =>$teacher,
            'getClass' =>$getClass,
            'getTeacher' =>$getTeacher,
        ]);
    }

    public function singleUpdate($id, Request $request){

        $validator = Validator::make($request->all(),[
            'class_id'=>'required',
            'teacher_id'=>'required',
            'status'=>'required',
        ]);

        if($validator->passes()){
            //check class subject alredy exists
            $check = AssignClassTeacher::checkClassTeacher($request->class_id,$request->teacher_id);
            if(!empty($check))
            {
                $check->status = $request->status;
                $check->save();

                $msg = 'Status successfully updated.';

            }else{
                $model = AssignClassTeacher::find($id);
                $model->class_id = $request->class_id;
                $model->teacher_id = $request->teacher_id;
                $model->status = $request->status;
                $model->save();

                $msg = 'Class Assign to Teacher successfully.';
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

    // teacher panel
    public function myClassSubject()
    {
        $classSubject = AssignClassTeacher::getMyClassSubject(Auth::user()->id);
        return view('teacher.my_class_subject',[
            'classSubject'=>$classSubject
        ]);
    }
}
