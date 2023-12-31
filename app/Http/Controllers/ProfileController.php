<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Media;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    public function edit()
    {
        $userId = Auth::user()->id;
        $user = User::where('id',$userId)->first();

        return view('profile.edit', [
            'user'=>$user,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required'
        ]);

        if($validator->passes())
        {
            $user = User::find(Auth::user()->id);
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->city = $request->city;
            $user->pincode = $request->pincode;
            $user->permanent_address = $request->permanent_address;
            $user->gender = $request->gender;
            $user->dob = $request->dob;

            if(!empty($request->image_id)){
                $tempImage = Media::find($request->image_id);
                $extArray = explode('.',$tempImage->name);
                $ext = last($extArray);

                $newImageName = $user->id .time(). '.'.$ext;
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

                $user->image = $newImageName;
                $user->save();

            }
            
            $user->save();

            return redirect()->back()->with('success','Profile updated successfully.');
        }else{
            return Redirect::back()->withErrors($validator);
        }
    }

    public function changePassword()
    {
        return view('profile.change-password');

    }

    public function changePasswordProcess(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'old_password'=>'required',
            'new_password'=>'required|min:5',
            'confirm_password'=>'required|same:new_password',
        ]);

        if($validator->passes())
        {
            $user = User::select('id','password')->where('id',Auth::user()->id)->first();

            if (!Hash::check($request->old_password,$user->password))
            {
                return redirect()->back()->with('error','Your old password is incorrect, please try again.');    
            }

            User::where('id',Auth::user()->id)->update(['password'=>Hash::make($request->new_password)]);

            return redirect()->back()->with('success','You have successfully change your password.');

        }else{
            return Redirect::back()->withErrors($validator);
        }

    }
}
