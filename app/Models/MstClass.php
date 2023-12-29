<?php

namespace App\Models;

use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MstClass extends Model
{
    use HasFactory;

    static public function getRecords(){

        $classes = self::select('mst_classes.*','users.name as created_by_name')
                        ->join('users','users.id','mst_classes.created_by')
                        ->where('mst_classes.is_deleted',0);

        if(!empty(Request::get('name')))
        {
            $classes = $classes->where('mst_classes.name','like','%'.Request::get('name').'%');
        }

        $classes = $classes->orderBy('mst_classes.id','DESC')
                        ->paginate(10);
        return  $classes;
    }
}
