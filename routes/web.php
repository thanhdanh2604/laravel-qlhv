<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ban_tin;
use App\Http\Controllers\teacher;
use App\Http\Controllers\student;
use App\Http\Controllers\teaching_recording\teaching_recordings;
use App\Http\Controllers\teaching_recording\details_teaching_recording;

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
        Route::get('/', [teaching_recordings::class, 'index'])->name('teaching_recordings');
        Route::get('/delete/{id}', [teaching_recordings::class,'destroy']);
        Route::get('/add_new',[teaching_recordings::class,'store']);
        Route::get('/update/{id}', [teaching_recordings::class,'update']);
        Route::get('/edit/{colum}/{id}', [teaching_recordings::class,'edit']);
        Route::prefix('detail')->group(function(){
            /**
             * Các hàm dưới xử lý trong chi tiết nhật ký, chủ yếu thao tác trong cột"teaching_history" trong bản "teaching_recording"
             */
            Route::get('/{id}', [teaching_recordings::class, 'show'])->name('teaching_recording_detail');
            Route::prefix('/add')->group(function () {
                Route::get('/subject', [details_teaching_recording::class,'add_new_teacher_and_subject'])->name('add_new_subject');
                Route::get('/day', [details_teaching_recording::class,'add_day_teaching_history'])->name('add_day_teaching_history');
                Route::get('/day-range', [details_teaching_recording::class,'add_day_range_teaching_history'])->name('add_day_range_teaching_history');
            });
            Route::prefix('/delete')->group(function(){
                Route::get('/subject', [details_teaching_recording::class,'delete_subject'])->name('delete_subject');
                Route::get('/day', [details_teaching_recording::class,'delete_date_of_subject'])->name('delete_day');
            });
        });
    });
});
Route::get('/teaching_recordings/detail/delete/day', [details_teaching_recording::class,'delete_date_of_subject'])->name('delete_day');

// Route::get('/test',function(){
//     $date = '11-Feb-2022';
//     $starttime = '11:00 AM';
//     $time = strtotime($date." ".$starttime);
//     echo date('d-M-Y',$time);
// });
Route::get('/test',[details_teaching_recording::class,'new_teaching_history_json']);

require __DIR__.'/auth.php';
