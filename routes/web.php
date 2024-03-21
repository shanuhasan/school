<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamController;
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
use App\Http\Controllers\ClassTimetableController;
use App\Http\Controllers\AssignClassTeacherController;

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

Route::group(['middleware' => ['admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');

    Route::get('/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
    Route::post('/change-password', [ProfileController::class, 'changePasswordProcess'])->name('profile.changePasswordProcess');

    //admins
    Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
    Route::get('/admins/create', [AdminController::class, 'create'])->name('admins.create');
    Route::post('/admins/store', [AdminController::class, 'store'])->name('admins.store');
    Route::get('/admins/{id}/edit', [AdminController::class, 'edit'])->name('admins.edit');
    Route::put('/admins/{id}', [AdminController::class, 'update'])->name('admins.update');
    Route::get('/admins/{id}', [AdminController::class, 'destroy'])->name('admins.delete');

    //teachers
    Route::get('/teacher', [TeacherController::class, 'index'])->name('teacher.index');
    Route::get('/teacher/create', [TeacherController::class, 'create'])->name('teacher.create');
    Route::post('/teacher/store', [TeacherController::class, 'store'])->name('teacher.store');
    Route::get('/teacher/{id}/edit', [TeacherController::class, 'edit'])->name('teacher.edit');
    Route::put('/teacher/{id}', [TeacherController::class, 'update'])->name('teacher.update');
    Route::get('/teacher/{id}', [TeacherController::class, 'destroy'])->name('teacher.delete');

    //students
    Route::get('/student', [StudentController::class, 'index'])->name('student.index');
    Route::get('/student/create', [StudentController::class, 'create'])->name('student.create');
    Route::post('/student/store', [StudentController::class, 'store'])->name('student.store');
    Route::get('/student/{id}/edit', [StudentController::class, 'edit'])->name('student.edit');
    Route::put('/student/{id}', [StudentController::class, 'update'])->name('student.update');
    Route::get('/student/{id}', [StudentController::class, 'destroy'])->name('student.delete');

    //parents
    Route::get('/parent', [ParentController::class, 'index'])->name('parent.index');
    Route::get('/parent/create', [ParentController::class, 'create'])->name('parent.create');
    Route::post('/parent/store', [ParentController::class, 'store'])->name('parent.store');
    Route::get('/parent/{id}/edit', [ParentController::class, 'edit'])->name('parent.edit');
    Route::put('/parent/{id}', [ParentController::class, 'update'])->name('parent.update');
    Route::get('/parent/{id}', [ParentController::class, 'destroy'])->name('parent.delete');

    Route::get('/parent/my-student/{parent_id}', [ParentController::class, 'myStudent'])->name('parent.student.index');
    Route::get('/parent/asssign-student/{student_id}/{parent_id}', [ParentController::class, 'assignStudentToParent'])->name('parent.student_assign');
    Route::get('/parent/asssign-student-delete/{student_id}', [ParentController::class, 'assignStudentToParentDelete'])->name('parent.student_assign_delete');

    //classes
    Route::get('/class', [ClassController::class, 'index'])->name('class.index');
    Route::get('/class/create', [ClassController::class, 'create'])->name('class.create');
    Route::post('/class/store', [ClassController::class, 'store'])->name('class.store');
    Route::get('/class/{id}/edit', [ClassController::class, 'edit'])->name('class.edit');
    Route::put('/class/{id}', [ClassController::class, 'update'])->name('class.update');
    Route::get('/class/{id}', [ClassController::class, 'destroy'])->name('class.delete');

    //subjects
    Route::get('/subject', [SubjectController::class, 'index'])->name('subject.index');
    Route::get('/subject/create', [SubjectController::class, 'create'])->name('subject.create');
    Route::post('/subject/store', [SubjectController::class, 'store'])->name('subject.store');
    Route::get('/subject/{id}/edit', [SubjectController::class, 'edit'])->name('subject.edit');
    Route::put('/subject/{id}', [SubjectController::class, 'update'])->name('subject.update');
    Route::get('/subject/{id}', [SubjectController::class, 'destroy'])->name('subject.delete');

    //assign subjects
    Route::get('/assign-subject', [ClassSubjectController::class, 'index'])->name('assign_subject.index');
    Route::get('/assign-subject/create', [ClassSubjectController::class, 'create'])->name('assign_subject.create');
    Route::post('/assign-subject/store', [ClassSubjectController::class, 'store'])->name('assign_subject.store');
    Route::get('/assign-subject/{id}/edit', [ClassSubjectController::class, 'edit'])->name('assign_subject.edit');
    Route::post('/assign-subject/{id}', [ClassSubjectController::class, 'update'])->name('assign_subject.update');
    Route::get('/assign-subject/{id}/single-edit', [ClassSubjectController::class, 'singleEdit'])->name('assign_subject.single-edit');
    Route::put('/assign-subject-single/{id}', [ClassSubjectController::class, 'singleUpdate'])->name('assign_subject.single-update');
    Route::get('/assign-subject/{id}', [ClassSubjectController::class, 'destroy'])->name('assign_subject.delete');

    //assign class teacher
    Route::get('/assign-class-teacher', [AssignClassTeacherController::class, 'index'])->name('assign_class_teacher.index');
    Route::get('/assign-class-teacher/create', [AssignClassTeacherController::class, 'create'])->name('assign_class_teacher.create');
    Route::post('/assign-class-teacher/store', [AssignClassTeacherController::class, 'store'])->name('assign_class_teacher.store');
    Route::get('/assign-class-teacher/{id}/edit', [AssignClassTeacherController::class, 'edit'])->name('assign_class_teacher.edit');
    Route::post('/assign-class-teacher/{id}', [AssignClassTeacherController::class, 'update'])->name('assign_class_teacher.update');
    Route::get('/assign-class-teacher/{id}/single-edit', [AssignClassTeacherController::class, 'singleEdit'])->name('assign_class_teacher.single-edit');
    Route::put('/assign-class-teacher-single/{id}', [AssignClassTeacherController::class, 'singleUpdate'])->name('assign_class_teacher.single-update');
    Route::get('/assign-class-teacher/{id}', [AssignClassTeacherController::class, 'destroy'])->name('assign_class_teacher.delete');

    //class timetable
    Route::get('/class-timetable', [ClassTimetableController::class, 'index'])->name('class_timetable.index');
    Route::post('/class-timetable/get-subject', [ClassTimetableController::class, 'getSubject'])->name('class_timetable.getSubject');


    Route::post('/class-timetable/store', [ClassTimetableController::class, 'store'])->name('class_timetable.store');
    Route::get('/class-timetable/{id}/edit', [ClassTimetableController::class, 'edit'])->name('class_timetable.edit');
    Route::post('/class-timetable/{id}', [ClassTimetableController::class, 'update'])->name('class_timetable.update');
    Route::get('/class-timetable/{id}/single-edit', [ClassTimetableController::class, 'singleEdit'])->name('class_timetable.single-edit');
    Route::put('/class-timetable-single/{id}', [ClassTimetableController::class, 'singleUpdate'])->name('class_timetable.single-update');
    Route::get('/class-timetable/{id}', [ClassTimetableController::class, 'destroy'])->name('class_timetable.delete');

    //examination
    Route::get('/exam', [ExamController::class, 'index'])->name('exam.index');
    Route::get('/exam/create', [ExamController::class, 'create'])->name('exam.create');
    Route::post('/exam/store', [ExamController::class, 'store'])->name('exam.store');
    Route::get('/exam/{id}/edit', [ExamController::class, 'edit'])->name('exam.edit');
    Route::put('/exam/{id}', [ExamController::class, 'update'])->name('exam.update');
    Route::get('/exam/{id}', [ExamController::class, 'destroy'])->name('exam.delete');



    Route::get('/exam_schedule', [ExamController::class, 'examSchedule'])->name('exam_schedule.index');
    Route::post('/exam_schedule/store', [ExamController::class, 'storeSchedule'])->name('exam_schedule.store');
});


Route::group(['middleware' => ['teacher'], 'prefix' => 'teacher', 'as' => 'teacher.'], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');

    Route::get('/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
    Route::post('/change-password', [ProfileController::class, 'changePasswordProcess'])->name('profile.changePasswordProcess');

    Route::get('/my-student', [StudentController::class, 'myStudent'])->name('my_student');
    Route::get('/my-class-subject', [AssignClassTeacherController::class, 'myClassSubject'])->name('my_class_subject');
    Route::get('/class-timetable/{class_id}/{subject_id}', [ClassTimetableController::class, 'teacherClassTimetable'])->name('timetable');

    Route::get('/exam_timetable', [ExamController::class, 'teacherExamTimetable'])->name('exam_timetable');
});

Route::group(['middleware' => ['student'], 'prefix' => 'student', 'as' => 'student.'], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');

    Route::get('/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
    Route::post('/change-password', [ProfileController::class, 'changePasswordProcess'])->name('profile.changePasswordProcess');

    Route::get('/subject', [SubjectController::class, 'studentSubjects'])->name('subject');
    Route::get('/timetable', [ClassTimetableController::class, 'timetable'])->name('timetable');
    Route::get('/exam_timetable', [ExamController::class, 'studentExamTimetable'])->name('exam_timetable');
});

Route::group(['middleware' => ['parent'], 'prefix' => 'parent', 'as' => 'parent.'], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');

    Route::get('/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
    Route::post('/change-password', [ProfileController::class, 'changePasswordProcess'])->name('profile.changePasswordProcess');

    Route::get('/my-children', [ParentController::class, 'myChildren'])->name('children');
    Route::get('/my-children/subjects/{student_id}', [SubjectController::class, 'parentChildrenSubject'])->name('children.subject');
    Route::get('/my-children/exam_timetable/{student_id}', [ExamController::class, 'parentChildrenExamTimetable'])->name('children.exam_timetable');

    Route::get('/my-children/subjects/class-timetable/{class_id}/{subject_id}/{student_id}', [ClassTimetableController::class, 'parentClassTimetable'])->name('timetable');
});


Route::post('/upload-image', [UploadImageController::class, 'create'])->name('temp-images.create');

require __DIR__ . '/auth.php';
