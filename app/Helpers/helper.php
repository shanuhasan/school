<?php

use App\Models\User;
use App\Models\MstClass;
use App\Models\MstSubject;
use Illuminate\Support\Facades\Auth;


function getRoutes()
{
    $routeProfile = $routePassword = $routeDashboard = $routeProfileUpdate = $routePasswordProcess = 'javascript:void(0);';
    if (Auth::user()->getOriginal('role') == 1) {
        $routeDashboard = route('admin.dashboard');
        $routeProfile = route('admin.profile.edit');
        $routeProfileUpdate = route('admin.profile.update');
        $routePassword = route('admin.profile.changePassword');
        $routePasswordProcess = route('admin.profile.changePasswordProcess');
    } elseif (Auth::user()->getOriginal('role') == 2) {
        $routeDashboard = route('teacher.dashboard');
        $routeProfile = route('teacher.profile.edit');
        $routeProfileUpdate = route('teacher.profile.update');
        $routePassword = route('teacher.profile.changePassword');
        $routePasswordProcess = route('teacher.profile.changePasswordProcess');
    } elseif (Auth::user()->getOriginal('role') == 3) {
        $routeDashboard = route('student.dashboard');
        $routeProfile = route('student.profile.edit');
        $routeProfileUpdate = route('student.profile.update');
        $routePassword = route('student.profile.changePassword');
        $routePasswordProcess = route('student.profile.changePasswordProcess');
    } elseif (Auth::user()->getOriginal('role') == 4) {
        $routeDashboard = route('parent.dashboard');
        $routeProfile = route('parent.profile.edit');
        $routeProfileUpdate = route('parent.profile.update');
        $routePassword = route('parent.profile.changePassword');
        $routePasswordProcess = route('parent.profile.changePasswordProcess');
    }

    return [
        'routeProfile'=>$routeProfile,
        'routePassword'=>$routePassword,
        'routeDashboard'=>$routeDashboard,
        'routeProfileUpdate'=>$routeProfileUpdate,
        'routePasswordProcess'=>$routePasswordProcess
    ];
}

function studentClassName($class_id)
{
    $class = MstClass::find($class_id);

    if(empty($class))
    {
        return '';
    }
    return $class->name;
}

function getName($id)
{
    $user = User::find($id);

    if(empty($user))
    {
        return '';
    }
    return $user->name;
}

function getSubjectName($id)
{
    $model = MstSubject::find($id);

    if(empty($model))
    {
        return '';
    }
    return $model->name;
}

function getSubjectDetail($id)
{
    $model = MstSubject::find($id);

    if(empty($model))
    {
        return [];
    }
    return $model;
}

function gender()
{
    $list = [
        'Male' => 'Male',
        'Female' => 'Female',
        'Others' => 'Others',       
    ];

    return $list;
}

function religion()
{
    $list = [
        'Muslim' => 'Muslim',
        'Hindu' => 'Hindu',
        'Others' => 'Others',       
    ];

    return $list;
}

function status()
{
    $list = [
        '1' => 'Active',
        '0' => 'Block',      
    ];

    return $list;
}

