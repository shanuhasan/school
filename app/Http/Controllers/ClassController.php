<?php

namespace App\Http\Controllers;

use App\Models\MstClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ClassController extends Controller
{
    public function index(Request $request){

        $classes = MstClass::getRecords();

        return view('admin.class.index',[
            'classes'=>$classes
        ]);
    }
    public function create(){
        return view('admin.class.create');
    }

    public function store(Request $request){
        
        $validator = Validator::make($request->all(),[
            'name'=>'required|unique:mst_classes',
        ]);
        if($validator->passes()){

            $model = new MstClass();
            $model->name = $request->name;
            $model->status = $request->status;
            $model->created_by = Auth::user()->id;
            $model->save();

            $request->session()->flash('success','Class added successfully.');
            return response()->json([
                'status'=>true,
                'message'=>'Class added successfully.'  
            ]);

        }else{
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()  
            ]);
        }
    }

    public function edit($id , Request $request){

        $class = MstClass::find($id);
        if(empty($class))
        {
            return redirect()->route('class.index');
        }

        return view('admin.class.edit',compact('class'));
        
    }
    public function update($id, Request $request){

        $model = MstClass::find($id);
        if(empty($model))
        {
            $request->session()->flash('error','Class not found.');
            return response()->json([
                'status'=>false,
                'notFound'=>true,
                'message'=>'Class not found.'
            ]);
        }

        $validator = Validator::make($request->all(),[
            'name'=>'required|unique:mst_classes,name,'.$model->id.',id',
        ]);

        if($validator->passes()){

            $model->name = $request->name;
            $model->status = $request->status;
            $model->save();

            $request->session()->flash('success','Class updated successfully.');
            return response()->json([
                'status'=>true,
                'message'=>'Class updated successfully.'  
            ]);

        }else{
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()  
            ]);
        }
    }
    public function destroy($id, Request $request){
        $model = MstClass::find($id);
        if(empty($model))
        {
            $request->session()->flash('error','Class not found.');
            return response()->json([
                'status'=>true,
                'message'=>'Class not found.'
            ]);
        }

        $model->is_deleted = 1;
        $model->save();

        $request->session()->flash('success','Class deleted successfully.');

        return response()->json([
            'status'=>true,
            'message'=>'Class deleted successfully.'
        ]);

    }
}
