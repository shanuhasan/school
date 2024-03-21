<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Media;
use App\Models\MstClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $teachers = User::getTeachers();

        $getClass = MstClass::getClass();
        return view('admin.teacher.index', [
            'teachers' => $teachers,
            'getClass' => $getClass,
        ]);
    }

    public function create()
    {

        $getClass = MstClass::getClass();
        return view('admin.teacher.create', [
            'getClass' => $getClass
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'phone' => 'required',
            'gender' => 'required',
            'status' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|confirmed',
        ]);

        if ($validator->passes()) {
            $model = new User();
            $model->guid = GUIDv4();
            $model->name = $request->name;
            $model->phone = $request->phone;
            $model->address = $request->address;
            $model->city = $request->city;
            $model->pincode = $request->pincode;
            $model->permanent_address = $request->permanent_address;
            $model->gender = $request->gender;
            $model->email = $request->email;
            $model->dob = $request->dob;
            $model->admission_date = $request->admission_date;
            $model->role = 2;
            $model->status = $request->status;
            $model->password = Hash::make($request->password);

            //save image
            if (!empty($request->image_id)) {
                $tempImage = Media::find($request->image_id);
                $extArray = explode('.', $tempImage->name);
                $ext = last($extArray);

                $newImageName = $model->id . time() . '.' . $ext;
                $sPath = public_path() . '/media/' . $tempImage->name;
                $dPath = public_path() . '/uploads/user/' . $newImageName;
                File::copy($sPath, $dPath);

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

            session()->flash('success', 'Teacher added successfully.');
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

    public function edit($guid)
    {
        $teacher = User::findByGuid($guid);
        if (empty($teacher)) {
            return redirect()->route('admin.teacher.index');
        }
        $getClass = MstClass::getClass();

        return view('admin.teacher.edit', [
            'teacher' => $teacher,
            'getClass' => $getClass,
        ]);
    }

    public function update($id, Request $request)
    {
        $model = User::find($id);
        if (empty($model)) {
            $request->session()->flash('error', 'Teacher not found.');
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Teacher not found.'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email,' . $id . ',id',
            'name' => 'required|min:3',
            'phone' => 'required',
            'gender' => 'required',
            'status' => 'required',
        ]);

        if ($validator->passes()) {

            $model->name = $request->name;
            $model->phone = $request->phone;
            $model->address = $request->address;
            $model->city = $request->city;
            $model->pincode = $request->pincode;
            $model->permanent_address = $request->permanent_address;
            $model->gender = $request->gender;
            $model->status = $request->status;
            $model->dob = $request->dob;
            $model->admission_date = $request->admission_date;

            if ($request->password != "") {
                $model->password = Hash::make($request->password);
            }

            $model->save();

            $oldImage = $model->image;

            //save image
            if (!empty($request->image_id)) {
                $tempImage = Media::find($request->image_id);
                $extArray = explode('.', $tempImage->name);
                $ext = last($extArray);

                $newImageName = $model->id . time() . '.' . $ext;
                $sPath = public_path() . '/media/' . $tempImage->name;
                $dPath = public_path() . '/uploads/user/' . $newImageName;
                File::copy($sPath, $dPath);

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
                File::delete(public_path() . '/uploads/user/' . $oldImage);
            }

            $request->session()->flash('success', 'Teacher updated successfully.');
            return response()->json([
                'status' => true,
                'message' => 'Teacher updated successfully.'
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
        $model = User::find($id);
        if (empty($model)) {
            $request->session()->flash('error', 'Teacher not found.');
            return response()->json([
                'status' => true,
                'message' => 'Teacher not found.'
            ]);
        }

        $model->is_deleted = 1;
        $model->save();

        $request->session()->flash('success', 'Teacher deleted successfully.');

        return response()->json([
            'status' => true,
            'message' => 'Teacher deleted successfully.'
        ]);
    }
}
