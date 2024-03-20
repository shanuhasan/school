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
        'routeProfile' => $routeProfile,
        'routePassword' => $routePassword,
        'routeDashboard' => $routeDashboard,
        'routeProfileUpdate' => $routeProfileUpdate,
        'routePasswordProcess' => $routePasswordProcess
    ];
}

function studentClassName($class_id)
{
    $class = MstClass::find($class_id);

    if (empty($class)) {
        return '';
    }
    return $class->name;
}

function getName($id)
{
    $user = User::find($id);

    if (empty($user)) {
        return '';
    }
    return $user->name;
}

function getUserFullName($id)
{
    $user = User::find($id);

    if (empty($user)) {
        return '';
    }
    return $user->name . ' ' . $user->last_name;
}


function getSubjectName($id)
{
    $model = MstSubject::find($id);

    if (empty($model)) {
        return '';
    }
    return $model->name;
}

function getClassName($id)
{
    $model = MstClass::find($id);

    if (empty($model)) {
        return '';
    }
    return $model->name;
}

function getSubjectDetail($id)
{
    $model = MstSubject::find($id);

    if (empty($model)) {
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

function GUIDv4($trim = true)
{
    // Windows
    if (function_exists('com_create_guid') === true) {
        if ($trim === true)
            return trim(com_create_guid(), '{}');
        else
            return com_create_guid();
    }

    // OSX/Linux
    if (function_exists('openssl_random_pseudo_bytes') === true) {
        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);    // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);    // set bits 6-7 to 10
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    // Fallback (PHP 4.2+)
    mt_srand((float)microtime() * 10000);
    $charid = strtolower(md5(uniqid(rand(), true)));
    $hyphen = chr(45);                  // "-"
    $lbrace = $trim ? "" : chr(123);    // "{"
    $rbrace = $trim ? "" : chr(125);    // "}"
    $guidv4 = $lbrace .
        substr($charid,  0,  8) . $hyphen .
        substr($charid,  8,  4) . $hyphen .
        substr($charid, 12,  4) . $hyphen .
        substr($charid, 16,  4) . $hyphen .
        substr($charid, 20, 12) .
        $rbrace;
    return $guidv4;
}

function pre($data)
{
    echo "<pre>";
    print_r($data);
    die;
}
