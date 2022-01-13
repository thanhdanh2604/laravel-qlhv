<?php

use Illuminate\Support\Facades\Route;
<<<<<<< Updated upstream
=======
use App\Http\Controllers\ban_tin;
use App\Http\Controllers\teacher;
use App\Http\Controllers\student;
use App\Http\Controllers\teaching_recording;
use App\Http\Controllers\api;


>>>>>>> Stashed changes

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => 'auth'], function(){
	Route::get('/', [ban_tin::class, 'index'])->name('/');

<<<<<<< Updated upstream
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

=======
    Route::prefix('teachers')->group(function () {
        Route::get('/', [teacher::class, 'index'])->name('teachers');
        Route::get('/detail/{id}', [teacher::class, 'show'])->name('teacher_detail');
        Route::get('/delete/{id}', [teacher::class,'destroy']);
        Route::get('/add_new',[teacher::class,'store']);
        Route::get('/update/{id}', [teacher::class,'update']);
        Route::get('/update/{colum}/{id}', [teacher::class,'edit']);
        Route::get('/packet_hour_to_subjects',[teacher::class,'packet_hour_to_subjects']);// TODO: xài xong có thể xóa
        Route::get('/json_get_currect_subject_teacher/{id}', [teacher::class,'json_get_currect_subject_teacher'])->name('get_current_subjects');
    });
    Route::prefix('students')->group(function () {
        Route::get('/', [student::class, 'index'])->name('students');
        Route::get('/detail/{id}', [student::class, 'show'])->name('student_detail');
        Route::get('/delete/{id}', [student::class,'destroy']);
        Route::get('/add_new',[student::class,'store']);
        Route::get('/update/{id}', [student::class,'update']);
        Route::get('/update/{colum}/{id}', [student::class,'edit']);
        Route::get('/select_column_student/{id}/{column}',[student::class,'select_column_student']);
    });
    Route::prefix('teaching_recordings')->group(function () {
        Route::get('/', [teaching_recording::class, 'index'])->name('teaching_recordings');
        Route::get('/detail/{id}', [teaching_recording::class, 'show'])->name('teaching_recording_detail');
        Route::get('/delete/{id}', [teaching_recording::class,'destroy']);
        Route::get('/add_new',[teaching_recording::class,'store']);
        Route::get('/update/{id}', [teaching_recording::class,'update']);
        Route::get('/edit/{colum}/{id}', [teaching_recording::class,'edit']);
        Route::prefix('/add')->group(function () {
            Route::get('/subject', [teaching_recording::class,'add_new_teacher_and_subject'])->name('add_new_subject');
            Route::get('/day', [teaching_recording::class,'add_day_teaching_history'])->name('add_day_teaching_history');
        });

    });
});
Route::get('/fix_nested_object', [teaching_recording::class,'fix_nested_object']);

Route::get('/get_number_of_like',[api::class,'get_number_of_like']);

>>>>>>> Stashed changes
require __DIR__.'/auth.php';
