<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MarkGrade extends Model
{
    use HasFactory;

    static public function getRecords()
    {
        $marksGrades = self::select('mark_grades.*', 'users.name as created_by_name')
            ->join('users', 'users.id', 'mark_grades.created_by');

        if (!empty(Request::get('name'))) {
            $marksGrades = $marksGrades->where('mark_grades.name', 'like', '%' . Request::get('name') . '%');
        }

        $marksGrades = $marksGrades->orderBy('mark_grades.id', 'DESC')
            ->paginate(10);
        return  $marksGrades;
    }

    static public function getGrade($per)
    {
        $return = self::select('mark_grades.*')
            ->where('percent_from', '<=', $per)
            ->where('percent_to', '>=', $per)
            ->first();
        return !empty($return->name) ? $return->name : '';
    }
}
