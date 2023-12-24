<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // $admins = User::latest()->where('user_type',1)
        //                         ->where('status',1)
        //                         ->where('is_deleted',0);

        // if(!empty($request->get('keyword')))
        // {
        //     $admins = $admins->where('name','like','%'.$request->get('keyword').'%');
        // }

        // $admins = $admins->paginate(10);

        $admins = User::getAdmins();

        return view('admin.admins.index',[
            'admins'=>$admins
        ]);
    }

    public function create(){

        return view('admin.admins.create');
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
            $model->email = $request->email;
            $model->user_type = 1;
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

            session()->flash('success','Admin added successfully.');
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
            return redirect()->route('user.index');
        }

        return view('admin.admins.edit',compact('user'));        
    }

    public function update($id, Request $request){

        $model = User::find($id);
        if(empty($model))
        {
            $request->session()->flash('error','Admin not found.');
            return response()->json([
                'status'=>false,
                'notFound'=>true,
                'message'=>'Admin not found.'
            ]);
        }

        $validator = Validator::make($request->all(),[
            'email'=>'required|email|unique:users,email,'.$id.',id',
            'name'=>'required|min:3',
            'status'=>'required',
        ]);

        if($validator->passes()){

            $model->name = $request->name;
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

            $request->session()->flash('success','Admin updated successfully.');
            return response()->json([
                'status'=>true,
                'message'=>'Admin updated successfully.'  
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
            $request->session()->flash('error','Admin not found.');
            return response()->json([
                'status'=>true,
                'message'=>'Admin not found.'
            ]);
        }

        $model->is_deleted = 1;
        $model->save();

        $request->session()->flash('success','Admin deleted successfully.');

        return response()->json([
            'status'=>true,
            'message'=>'Admin deleted successfully.'
        ]);

    }
}
