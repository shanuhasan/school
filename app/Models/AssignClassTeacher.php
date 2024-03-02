<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class AssignClassTeacher extends Model
{
    use HasFactory;

    static public function getRecords(){

        $teachers = self::select('assign_class_teachers.*','users.name as created_by_name','mst_classes.name as class_name','teacher.name as teacher_name')
                        ->join('mst_classes','mst_classes.id','assign_class_teachers.class_id')
                        ->join('users','users.id','assign_class_teachers.created_by')
                        ->join('users as teacher','teacher.id','assign_class_teachers.teacher_id')
                        ->where('assign_class_teachers.is_deleted',0);

        if(!empty(Request::get('class_id')))
        {
            $teachers = $teachers->where('assign_class_teachers.class_id','=',Request::get('class_id'));
        }

        if(!empty(Request::get('teacher_id')))
        {
            $teachers = $teachers->where('assign_class_teachers.teacher_id','=',Request::get('teacher_id'));
        }

        if(!empty(Request::get('status')))
        {
            $teachers = $teachers->where('assign_class_teachers.status','=',Request::get('status'));
        }

        $teachers = $teachers->orderBy('assign_class_teachers.id','DESC')
                        ->paginate(10);
        return  $teachers;
    }

    static public function checkClassTeacher($classId,$teacherId)
    {
        return self::where('class_id',$classId)
                    ->where('teacher_id',$teacherId)
                    ->first();
    }

    static public function getAssignClassTeacherId($classId)
    {
        return self::where('class_id',$classId)
                    ->where('is_deleted',0)
                    ->get();
    }

    static public function getMyClassSubject($teacher_id)
    {
        return self::select('assign_class_teachers.*','mst_classes.name as class_name','mst_subjects.name as subject_name','mst_subjects.type as subject_type')
                        ->join('mst_classes','mst_classes.id','assign_class_teachers.class_id')
                        ->join('class_subjects','class_subjects.class_id','mst_classes.id')
                        ->join('mst_subjects','mst_subjects.id','class_subjects.subject_id')
                        ->where('assign_class_teachers.is_deleted','=',0)
                        ->where('assign_class_teachers.status','=',1)
                        ->where('mst_subjects.is_deleted','=',0)
                        ->where('mst_subjects.status','=',1)
                        ->where('class_subjects.is_deleted','=',0)
                        ->where('class_subjects.status','=',1)
                        ->where('assign_class_teachers.teacher_id','=',$teacher_id)
                        ->get();
    }
}
