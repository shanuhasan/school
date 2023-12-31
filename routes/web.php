<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UploadImageController;
use App\Http\Controllers\ClassSubjectController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::group(['middleware'=>['admin'],'prefix'=>'admin','as'=>'admin.'],function(){
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');

    Route::get('/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
    Route::post('/change-password', [ProfileController::class, 'changePasswordProcess'])->name('profile.changePasswordProcess');

    //admins
    Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
    Route::get('/admins/create',[AdminController::class,'create'])->name('admins.create');
    Route::post('/admins/store',[AdminController::class,'store'])->name('admins.store');
    Route::get('/admins/{id}/edit',[AdminController::class,'edit'])->name('admins.edit');
    Route::put('/admins/{id}',[AdminController::class,'update'])->name('admins.update');
    Route::get('/admins/{id}',[AdminController::class,'destroy'])->name('admins.delete');

    //teachers
    Route::get('/teacher', [TeacherController::class, 'index'])->name('teacher.index');
    Route::get('/teacher/create',[TeacherController::class,'create'])->name('teacher.create');
    Route::post('/teacher/store',[TeacherController::class,'store'])->name('teacher.store');
    Route::get('/teacher/{id}/edit',[TeacherController::class,'edit'])->name('teacher.edit');
    Route::put('/teacher/{id}',[TeacherController::class,'update'])->name('teacher.update');
    Route::get('/teacher/{id}',[TeacherController::class,'destroy'])->name('teacher.delete');

    //students
    Route::get('/student', [StudentController::class, 'index'])->name('student.index');
    Route::get('/student/create',[StudentController::class,'create'])->name('student.create');
    Route::post('/student/store',[StudentController::class,'store'])->name('student.store');
    Route::get('/student/{id}/edit',[StudentController::class,'edit'])->name('student.edit');
    Route::put('/student/{id}',[StudentController::class,'update'])->name('student.update');
    Route::get('/student/{id}',[StudentController::class,'destroy'])->name('student.delete');

    //parents
    Route::get('/parent', [ParentController::class, 'index'])->name('parent.index');
    Route::get('/parent/create',[ParentController::class,'create'])->name('parent.create');
    Route::post('/parent/store',[ParentController::class,'store'])->name('parent.store');
    Route::get('/parent/{id}/edit',[ParentController::class,'edit'])->name('parent.edit');
    Route::put('/parent/{id}',[ParentController::class,'update'])->name('parent.update');
    Route::get('/parent/{id}',[ParentController::class,'destroy'])->name('parent.delete');

    Route::get('/parent/my-student/{parent_id}', [ParentController::class, 'myStudent'])->name('parent.student.index');
    Route::get('/parent/asssign-student/{student_id}/{parent_id}', [ParentController::class, 'assignStudentToParent'])->name('parent.student_assign');
    Route::get('/parent/asssign-student-delete/{student_id}', [ParentController::class, 'assignStudentToParentDelete'])->name('parent.student_assign_delete');

    //classes
    Route::get('/class', [ClassController::class, 'index'])->name('class.index');
    Route::get('/class/create',[ClassController::class,'create'])->name('class.create');
    Route::post('/class/store',[ClassController::class,'store'])->name('class.store');
    Route::get('/class/{id}/edit',[ClassController::class,'edit'])->name('class.edit');
    Route::put('/class/{id}',[ClassController::class,'update'])->name('class.update');
    Route::get('/class/{id}',[ClassController::class,'destroy'])->name('class.delete');
    
    //subjects
    Route::get('/subject', [SubjectController::class, 'index'])->name('subject.index');
    Route::get('/subject/create',[SubjectController::class,'create'])->name('subject.create');
    Route::post('/subject/store',[SubjectController::class,'store'])->name('subject.store');
    Route::get('/subject/{id}/edit',[SubjectController::class,'edit'])->name('subject.edit');
    Route::put('/subject/{id}',[SubjectController::class,'update'])->name('subject.update');
    Route::get('/subject/{id}',[SubjectController::class,'destroy'])->name('subject.delete');

    //assign subjects
    Route::get('/assign-subject', [ClassSubjectController::class, 'index'])->name('assign_subject.index');
    Route::get('/assign-subject/create',[ClassSubjectController::class,'create'])->name('assign_subject.create');
    Route::post('/assign-subject/store',[ClassSubjectController::class,'store'])->name('assign_subject.store');
    Route::get('/assign-subject/{id}/edit',[ClassSubjectController::class,'edit'])->name('assign_subject.edit');
    Route::post('/assign-subject/{id}',[ClassSubjectController::class,'update'])->name('assign_subject.update');
    Route::get('/assign-subject/{id}/single-edit',[ClassSubjectController::class,'singleEdit'])->name('assign_subject.single-edit');
    Route::put('/assign-subject-single/{id}',[ClassSubjectController::class,'singleUpdate'])->name('assign_subject.single-update');
    Route::get('/assign-subject/{id}',[ClassSubjectController::class,'destroy'])->name('assign_subject.delete');
});


Route::group(['middleware'=>['teacher'],'prefix'=>'teacher','as'=>'teacher.'],function(){
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');

    Route::get('/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
    Route::post('/change-password', [ProfileController::class, 'changePasswordProcess'])->name('profile.changePasswordProcess');
});

Route::group(['middleware'=>['student'],'prefix'=>'student','as'=>'student.'],function(){
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');

    Route::get('/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
    Route::post('/change-password', [ProfileController::class, 'changePasswordProcess'])->name('profile.changePasswordProcess');
});

Route::group(['middleware'=>['parent'],'prefix'=>'parent','as'=>'parent.'],function(){
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');

    Route::get('/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
    Route::post('/change-password', [ProfileController::class, 'changePasswordProcess'])->name('profile.changePasswordProcess');
});


Route::post('/upload-image',[UploadImageController::class,'create'])->name('temp-images.create');

require __DIR__.'/auth.php';

// Route::group(['middleware'=>['auth:admin'],'prefix'=>'admin','as'=>'admin.'],function(){
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// });


// require __DIR__.'/adminauth.php';
