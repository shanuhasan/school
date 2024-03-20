<?php

namespace App\Models;

use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Exam extends Model
{
    use HasFactory;

    static public function getExams()
    {

        $exams = self::select('exams.*')
            ->where('is_deleted', 0);

        if (!empty(Request::get('name'))) {
            $exams = $exams->where('name', 'like', '%' . Request::get('name') . '%');
        }

        $exams = $exams->orderBy('id', 'DESC')
            ->paginate(10);
        return  $exams;
    }
}
