<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassSubject extends Model
{
    use HasFactory;

    static public function getRecords(){

        $subjects = self::select('class_subjects.*','users.name as created_by_name','mst_classes.name as class_name','mst_subjects.name as subject_name')
                        ->join('mst_classes','mst_classes.id','class_subjects.class_id')
                        ->join('mst_subjects','mst_subjects.id','class_subjects.subject_id')
                        ->join('users','users.id','class_subjects.created_by')
                        ->where('class_subjects.is_deleted',0);

        if(!empty(Request::get('class_id')))
        {
            $subjects = $subjects->where('class_subjects.class_id','=',Request::get('class_id'));
        }

        if(!empty(Request::get('subject_id')))
        {
            $subjects = $subjects->where('class_subjects.subject_id','=',Request::get('subject_id'));
        }

        if(!empty(Request::get('status')))
        {
            $subjects = $subjects->where('class_subjects.status','=',Request::get('status'));
        }

        $subjects = $subjects->orderBy('class_subjects.id','DESC')
                        ->paginate(10);
        return  $subjects;
    }

    static public function studentSubjects()
    {
        $subjects = self::select('class_subjects.*')
                            ->where('is_deleted',0)
                            ->where('status',1)
                            ->where('class_id','=',Auth::user()->class_id)
                            ->orderBy('id','DESC')
                            ->get();
        return  $subjects;
    }

    static public function checkClassSubject($classId,$subjectId)
    {
        return self::where('class_id',$classId)
                    ->where('subject_id',$subjectId)
                    ->first();
    }

    static public function getAssignSubjectId($classId)
    {
        return self::where('class_id',$classId)
                    ->where('is_deleted',0)
                    ->get();
    }
}
