<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Media;
use App\Models\MstClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $students = User::getStudents();

        $getClass = MstClass::getClass();
        return view('admin.student.index',[
            'students'=>$students,
            'getClass'=>$getClass,
        ]);
    }

    public function create(){

        $getClass = MstClass::getClass();
        return view('admin.student.create',[
            'getClass' => $getClass
        ]);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'name'=>'required|min:3',
            'class_id'=>'required',
            'admission_no'=>'required',
            'admission_date'=>'required',
            'gender'=>'required',
            'dob'=>'required',
            'religion'=>'required',
            'status'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:5|confirmed',
        ]);

        if($validator->passes())
        {
            $model = new User();
            $model->name = $request->name;
            $model->phone = $request->phone;
            $model->class_id = $request->class_id;
            $model->address = $request->address;
            $model->city = $request->city;
            $model->pincode = $request->pincode;
            $model->admission_no = $request->admission_no;
            $model->admission_date = $request->admission_date;
            $model->rollno = $request->rollno;
            $model->gender = $request->gender;
            $model->dob = $request->dob;
            $model->caste = $request->caste;
            $model->religion = $request->religion;
            $model->blood_group = $request->blood_group;
            $model->height = $request->height;
            $model->weight = $request->weight;
            $model->email = $request->email;
            $model->role = 3;
            $model->status = $request->status;
            $model->password = Hash::make($request->password);
            
            //save image
            if(!empty($request->image_id)){
                $tempImage = Media::find($request->image_id);
                $extArray = explode('.',$tempImage->name);
                $ext = last($extArray);

                $newImageName = $model->id .time(). '.'.$ext;
                $sPath = public_path().'/media/'.$tempImage->name;
                $dPath = public_path().'/uploads/user/'.$newImageName;
                File::copy($sPath,$dPath);

                //generate thumb
                // $dPath = public_path().'/uploads/user/thumb/'.$newImageName;
                // $img = Image::make($sPath);
                // $img->fit(300, 200, function ($constraint) {
                //     $constraint->upsize();
                // });
                // $img->save($dPath);

                $model->image = $newImageName;
                $model->save();

            }
            $model->save();

            session()->flash('success','Student added successfully.');
            return response()->json([
                'status'=>true
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()
            ]);
        }
    }

    public function edit($id , Request $request){

        $user = User::find($id);
        if(empty($user))
        {
            return redirect()->route('admin.student.index');
        }
        $getClass = MstClass::getClass();

        return view('admin.student.edit',[
            'user'=>$user,
            'getClass'=>$getClass,
        ]);        
    }

    public function update($id, Request $request){

        $model = User::find($id);
        if(empty($model))
        {
            $request->session()->flash('error','Student not found.');
            return response()->json([
                'status'=>false,
                'notFound'=>true,
                'message'=>'Student not found.'
            ]);
        }

        $validator = Validator::make($request->all(),[
            'email'=>'required|email|unique:users,email,'.$id.',id',
            'name'=>'required|min:3',
            'class_id'=>'required',
            'admission_no'=>'required',
            'admission_date'=>'required',
            'gender'=>'required',
            'dob'=>'required',
            'religion'=>'required',
            'status'=>'required',
        ]);

        if($validator->passes()){

            $model->name = $request->name;
            $model->phone = $request->phone;
            $model->class_id = $request->class_id;
            $model->address = $request->address;
            $model->city = $request->city;
            $model->pincode = $request->pincode;
            $model->admission_no = trim($request->admission_no);
            $model->admission_date = $request->admission_date;
            $model->rollno = trim($request->rollno);
            $model->gender = $request->gender;
            $model->dob = $request->dob;
            $model->caste = $request->caste;
            $model->religion = $request->religion;
            $model->blood_group = $request->blood_group;
            $model->height = $request->height;
            $model->weight = $request->weight;
            $model->status = $request->status;

            if($request->password !="")
            {
                $model->password = Hash::make($request->password);
            }

            $model->save();

            $oldImage = $model->image;

            //save image
            if(!empty($request->image_id)){
                $tempImage = Media::find($request->image_id);
                $extArray = explode('.',$tempImage->name);
                $ext = last($extArray);

                $newImageName = $model->id .time(). '.'.$ext;
                $sPath = public_path().'/media/'.$tempImage->name;
                $dPath = public_path().'/uploads/user/'.$newImageName;
                File::copy($sPath,$dPath);

                //generate thumb
                // $dPath = public_path().'/uploads/user/thumb/'.$newImageName;
                // $img = Image::make($sPath);
                // $img->fit(300, 200, function ($constraint) {
                //     $constraint->upsize();
                // });
                // $img->save($dPath);

                $model->image = $newImageName;
                $model->save();

                //delete old image
                // File::delete(public_path().'/uploads/user/thumb/'.$oldImage);
                File::delete(public_path().'/uploads/user/'.$oldImage);
                
            }

            $request->session()->flash('success','Student updated successfully.');
            return response()->json([
                'status'=>true,
                'message'=>'Student updated successfully.'  
            ]);

        }else{
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()  
            ]);
        }
    }

    public function destroy($id, Request $request){
        $model = User::find($id);
        if(empty($model))
        {
            $request->session()->flash('error','Student not found.');
            return response()->json([
                'status'=>true,
                'message'=>'Student not found.'
            ]);
        }

        $model->is_deleted = 1;
        $model->save();

        $request->session()->flash('success','Student deleted successfully.');

        return response()->json([
            'status'=>true,
            'message'=>'Student deleted successfully.'
        ]);

    }
}
