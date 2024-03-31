<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    static public function getAdmins()
    {

        $admins = self::select('users.*')
            ->where('role', 1)
            // ->where('id', '!=', Auth::user()->id)
            ->where('is_deleted', 0);

        if (!empty(Request::get('name'))) {
            $admins = $admins->where('name', 'like', '%' . Request::get('name') . '%');
        }
        if (!empty(Request::get('email'))) {
            $admins = $admins->where('email', 'like', '%' . Request::get('email') . '%');
        }

        $admins = $admins->orderBy('id', 'DESC')
            ->paginate(10);
        return  $admins;
    }

    static public function getStudents()
    {

        $students = self::select('users.*')
            ->where('role', 3)
            ->where('is_deleted', 0);

        if (!empty(Request::get('name'))) {
            $students = $students->where('name', 'like', '%' . Request::get('name') . '%');
        }

        if (!empty(Request::get('last_name'))) {
            $students = $students->where('last_name', 'like', '%' . Request::get('last_name') . '%');
        }

        if (!empty(Request::get('class_id'))) {
            $students = $students->where('class_id', '=', Request::get('class_id'));
        }

        if (!empty(Request::get('email'))) {
            $students = $students->where('email', 'like', '%' . Request::get('email') . '%');
        }

        $students = $students->orderBy('id', 'DESC')
            ->paginate(10);
        return  $students;
    }

    static public function getParents()
    {

        $parents = self::select('users.*')
            ->where('role', 4)
            ->where('is_deleted', 0);

        if (!empty(Request::get('name'))) {
            $parents = $parents->where('name', 'like', '%' . Request::get('name') . '%');
        }

        if (!empty(Request::get('email'))) {
            $parents = $parents->where('email', 'like', '%' . Request::get('email') . '%');
        }

        $parents = $parents->orderBy('id', 'DESC')
            ->paginate(10);
        return  $parents;
    }

    static public function getSearchStudent()
    {
        // dd(Request::all());
        if (!empty(Request::get('id')) || !empty(Request::get('name')) || !empty(Request::get('last_name'))  || !empty(Request::get('email'))) {
            $students = self::select('users.*')
                ->where('users.role', 3)
                ->where('users.is_deleted', 0);

            if (!empty(Request::get('id'))) {
                $students = $students->where('users.id', '=', Request::get('id'));
            }

            if (!empty(Request::get('name'))) {
                $students = $students->where('users.name', 'like', '%' . Request::get('name') . '%');
            }

            if (!empty(Request::get('last_name'))) {
                $students = $students->where('users.last_name', 'like', '%' . Request::get('last_name') . '%');
            }

            if (!empty(Request::get('email'))) {
                $students = $students->where('users.email', 'like', '%' . Request::get('email') . '%');
            }

            $students = $students->orderBy('users.id', 'DESC')
                ->limit(50)
                ->get();
            return  $students;
        }
    }

    static public function getParentStudent($parentId)
    {
        $students = self::select('users.*')
            ->where('users.role', 3)
            ->where('users.parent_id', $parentId)
            ->where('users.is_deleted', 0)
            ->orderBy('users.id', 'DESC')
            ->limit(50)
            ->get();
        return  $students;
    }

    static public function getTeachers()
    {

        $teachers = self::select('users.*')
            ->where('role', 2)
            ->where('is_deleted', 0);

        if (!empty(Request::get('name'))) {
            $teachers = $teachers->where('name', 'like', '%' . Request::get('name') . '%');
        }

        if (!empty(Request::get('email'))) {
            $teachers = $teachers->where('email', 'like', '%' . Request::get('email') . '%');
        }

        $teachers = $teachers->orderBy('id', 'DESC')
            ->paginate(10);
        return  $teachers;
    }

    static public function getClassTeachers()
    {

        $teachers = self::select('users.*')
            ->where('role', 2)
            ->where('is_deleted', 0)
            ->where('status', 1);

        $teachers = $teachers->orderBy('id', 'DESC')
            ->get();
        return  $teachers;
    }

    static public function getSingle($guid)
    {

        $user = self::select('users.*')
            ->where('guid', $guid)
            ->where('is_deleted', 0)
            ->where('status', 1)
            ->first();
        return  $user;
    }

    static public function getTeacherStudents($teacher_id)
    {

        return self::select('users.*')
            ->join('mst_classes', 'mst_classes.id', 'users.class_id')
            ->join('assign_class_teachers', 'assign_class_teachers.class_id', 'mst_classes.id')
            ->where('role', '=', 3)
            ->where('users.is_deleted', '=', 0)
            ->where('assign_class_teachers.is_deleted', '=', 0)
            ->where('assign_class_teachers.status', '=', 1)
            ->where('assign_class_teachers.teacher_id', '=', $teacher_id)
            ->orderBy('users.id', 'desc')
            ->groupBy('users.id')
            ->paginate(20);
    }

    static public function findByGuid($guid)
    {
        $user = self::where('guid', $guid)->first();
        return  $user;
    }

    static public function findByClassId($classId)
    {
        return self::where('class_id', $classId)
            ->where('is_deleted', '=', '0')
            ->where('role', '=', '3')
            ->orderBy('name', 'ASC')
            ->get();
    }
}
