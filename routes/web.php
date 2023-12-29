<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UploadImageController;

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

    //admins
    Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
    Route::get('/admins/create',[AdminController::class,'create'])->name('admins.create');
    Route::post('/admins/store',[AdminController::class,'store'])->name('admins.store');
    Route::get('/admins/{id}/edit',[AdminController::class,'edit'])->name('admins.edit');
    Route::put('/admins/{id}',[AdminController::class,'update'])->name('admins.update');
    Route::get('/admins/{id}',[AdminController::class,'destroy'])->name('admins.delete');

    //classes
    Route::get('/class', [ClassController::class, 'index'])->name('class.index');
    Route::get('/class/create',[ClassController::class,'create'])->name('class.create');
    Route::post('/class/store',[ClassController::class,'store'])->name('class.store');
    Route::get('/class/{id}/edit',[ClassController::class,'edit'])->name('class.edit');
    Route::put('/class/{id}',[ClassController::class,'update'])->name('class.update');
    Route::get('/class/{id}',[ClassController::class,'destroy'])->name('class.delete');
});

Route::group(['middleware'=>['teacher'],'prefix'=>'teacher','as'=>'teacher.'],function(){
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
});

Route::group(['middleware'=>['student'],'prefix'=>'student','as'=>'student.'],function(){
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
});

Route::group(['middleware'=>['parent'],'prefix'=>'parent','as'=>'parent.'],function(){
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
});


Route::post('/upload-image',[UploadImageController::class,'create'])->name('temp-images.create');

require __DIR__.'/auth.php';

// Route::group(['middleware'=>['auth:admin'],'prefix'=>'admin','as'=>'admin.'],function(){
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// });


// require __DIR__.'/adminauth.php';
