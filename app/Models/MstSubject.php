<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MstSubject extends Model
{
    use HasFactory;

    static public function getRecords(){

        $subjects = self::select('mst_subjects.*','users.name as created_by_name')
                        ->join('users','users.id','mst_subjects.created_by')
                        ->where('mst_subjects.is_deleted',0);

        if(!empty(Request::get('name')))
        {
            $subjects = $subjects->where('mst_subjects.name','like','%'.Request::get('name').'%');
        }
        if(!empty(Request::get('type')))
        {
            $subjects = $subjects->where('mst_subjects.type','=',Request::get('type'));
        }

        $subjects = $subjects->orderBy('mst_subjects.id','DESC')
                        ->paginate(10);
        return  $subjects;
    }

    static public function getSubject(){

        $subjects = self::select('mst_subjects.*')
                        ->where('mst_subjects.is_deleted',0)
                        ->where('mst_subjects.status',1)
                        ->orderBy('mst_subjects.name','ASC')
                        ->get();
        return  $subjects;
    }
}
