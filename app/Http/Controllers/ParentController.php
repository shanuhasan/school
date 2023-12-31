<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Media;
use App\Models\MstClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ParentController extends Controller
{
    // for admin panel
    public function index(Request $request)
    {
        $parents = User::getParents();

        $getClass = MstClass::getClass();
        return view('admin.parent.index',[
            'parents'=>$parents,
            'getClass'=>$getClass,
        ]);
    }

    public function create(){

        $getClass = MstClass::getClass();
        return view('admin.parent.create',[
            'getClass' => $getClass
        ]);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'name'=>'required|min:3',
            'status'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:5|confirmed',
        ]);

        if($validator->passes())
        {
            $model = new User();
            $model->name = $request->name;
            $model->phone = $request->phone;
            $model->address = $request->address;
            $model->city = $request->city;
            $model->pincode = $request->pincode;
            $model->gender = $request->gender;
            $model->email = $request->email;
            $model->occupation = $request->occupation;
            $model->role = 4;
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

            session()->flash('success','Parent added successfully.');
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
            return redirect()->route('admin.parent.index');
        }
        $getClass = MstClass::getClass();

        return view('admin.parent.edit',[
            'user'=>$user,
            'getClass'=>$getClass,
        ]);        
    }

    public function update($id, Request $request){

        $model = User::find($id);
        if(empty($model))
        {
            $request->session()->flash('error','Parent not found.');
            return response()->json([
                'status'=>false,
                'notFound'=>true,
                'message'=>'Parent not found.'
            ]);
        }

        $validator = Validator::make($request->all(),[
            'email'=>'required|email|unique:users,email,'.$id.',id',
            'name'=>'required|min:3',
            'status'=>'required',
        ]);

        if($validator->passes()){

            $model->name = $request->name;
            $model->phone = $request->phone;
            $model->address = $request->address;
            $model->city = $request->city;
            $model->pincode = $request->pincode;
            $model->status = $request->status;
            $model->occupation = $request->occupation;

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

            $request->session()->flash('success','Parent updated successfully.');
            return response()->json([
                'status'=>true,
                'message'=>'Parent updated successfully.'  
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
            $request->session()->flash('error','Parent not found.');
            return response()->json([
                'status'=>true,
                'message'=>'Parent not found.'
            ]);
        }

        $model->is_deleted = 1;
        $model->save();

        $request->session()->flash('success','Parent deleted successfully.');

        return response()->json([
            'status'=>true,
            'message'=>'Parent deleted successfully.'
        ]);

    }

    public function myStudent($id)
    {
        $parent = User::find($id);
        $students = User::getSearchStudent();
        $parentStudents = User::getParentStudent($id);

        return view('admin.parent.my-student',[
            'students'=>$students,
            'parentStudents'=>$parentStudents,
            'parentId' => $id,
            'parent' => $parent,
        ]);
    }

    public function assignStudentToParent($student_id,$parent_id)
    {
        $student = User::find($student_id);
        $student->parent_id =$parent_id;
        $student->save();
        return redirect()->back()->with('success','Student Successfully Assign.');
    }

    public function assignStudentToParentDelete($student_id)
    {
        $student = User::find($student_id);
        $student->parent_id = NULL;
        $student->save();
        return redirect()->back()->with('success','Assign Student Successfully Deleted.');
    }

    // for parent panel
    public function myChildren()
    {
        $id = Auth::user()->id;
        $model = User::getParentStudent($id);

        return view('parent.my-children',[
            'model' => $model,
        ]);
    }
}
