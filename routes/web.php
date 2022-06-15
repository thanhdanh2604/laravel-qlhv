<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ban_tin;
use App\Http\Controllers\teacher;
use App\Http\Controllers\student;
use App\Http\Controllers\calendar;
use App\Http\Controllers\C_subject;
use App\Http\Controllers\teaching_recording\teaching_recordings;
use App\Http\Controllers\teaching_recording\details_teaching_recording;

use App\Http\Controllers\payment\payments;
use App\Http\Controllers\payment\teaching_statistics;


use Illuminate\Support\Facades\Artisan;


Route::group(['middleware' => 'auth'], function(){
	Route::get('/', [ban_tin::class, 'index'])->name('/');
    route::get('/calendar',[calendar::class,'index'])->name('calendar');// incomplete
    Route::get('/subject',[C_subject::class,'get_all_subjects'])->name('subjects');
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
        Route::post('/edit', [teaching_recordings::class,'edit'])->name('edit_teaching_recording');
        /**
         * report processing
         */
        Route::prefix('report')->group(function () {
          Route::get('/{id}', [teaching_recordings::class,'view_teaching_recording_report'])->name('view_nkgd_report');
          Route::get('/export/{id}', [teaching_recordings::class,'export_report_teaching_recording'])->name('export_report');
        });
        Route::prefix('detail')->group(function(){
            /**
             * Các hàm dưới xử lý trong chi tiết nhật ký, chủ yếu thao tác trong cột"teaching_history" trong bản "teaching_recording"
             */
            Route::get('/{id}', [teaching_recordings::class, 'show'])->name('teaching_recording_detail');
            Route::prefix('/add')->group(function () {
                Route::get('/subject', [details_teaching_recording::class,'add_new_teacher_and_subject'])->name('add_new_subject');
                Route::post('/day', [details_teaching_recording::class,'add_day_teaching_history'])->name('add_day_teaching_history');
                Route::get('/day-range', [details_teaching_recording::class,'add_day_range_teaching_history'])->name('add_day_range_teaching_history');
                // Xử lý trong ngày
                Route::get('/note', [details_teaching_recording::class,'add_note_of_date'])->name('add_note_of_date');
                Route::get('/roll_up',[details_teaching_recording::class,'add_roll_up_date'])->name('roll_up');
            });
            Route::post('/edit_date', [details_teaching_recording::class,'edit_time_date'])->name('edit_time_date');

            Route::post('/change_date',[details_teaching_recording::class,'change_date'])->name('change_date');
            Route::post('/reset',[details_teaching_recording::class,'reset_date'])->name('reset_date');
            Route::prefix('/delete')->group(function(){
                Route::get('/subject', [details_teaching_recording::class,'delete_subject'])->name('delete_subject');
                Route::get('/day', [details_teaching_recording::class,'delete_date_of_subject'])->name('delete_day');
            });
            //Finish subject
            Route::post('/finish',[details_teaching_recording::class,'finish_subject'])->name('finish_subject');
            //Bảo lưu giờ
            Route::prefix('/reserve')->group(function(){
                Route::post('/to_reserve',[details_teaching_recording::class,'bao_luu_goi_gio'])->name('bao_luu_gio');
                Route::post('/to_hours',[details_teaching_recording::class,'from_revenue_to_hours']);
                route::post('/transfer',[details_teaching_recording::class,'transfer_revenue']);
            });
            /**
             * Các hàm xử lý trong phần Renew history
             */
            Route::prefix('/renew_history')->group(function(){
                Route::post('/add',[details_teaching_recording::class,'add_new_packet_hours'])->name('add_renew');
                Route::get('/edit',[details_teaching_recording::class,'edit_renew_history'])->name('edit_renew');
                Route::get('/delete',[details_teaching_recording::class,'remove_renew_history'])->name('delete_renew');
                Route::get('/syns_revenue',[details_teaching_recording::class,'syns_revenue'])->name('dong_bo_doanh_thu');
            });
        });
    });
    Route::prefix('payment')->group(function () {
        Route::get('/',[payments::class,'index'])->name('payment');
        Route::get('/update',[payments::class,'update_once'])->name('payment_update');
        Route::get('/teaching_statistics',[teaching_statistics::class,'index'])->name('teaching_statistics');
        Route::get('/get_all_teaching_hours',[teaching_statistics::class,'get_all_teaching_hours'])->name('get_all_teaching_hours');
        Route::get('/teaching_details/{id_teacher}',[teaching_statistics::class,'teaching_detail'])->name('teaching_details');
        Route::get('/salary_check',[payments::class,'salary_check'])->name('salary_check');
    });
});

// Route::get('/test',function(){
//     $date = '11-Feb-2022';
//     $starttime = '11:00 AM';
//     $time = strtotime($date." ".$starttime);
//     echo date('d-M-Y',$time);
// });

Route::get('/fix_json',[details_teaching_recording::class,'new_teaching_history_json']);
Route::get('/test',[C_subject::class,'get_all_subjects']);
Route::get('/cacheclear', function(){
  artisan::call('cache:clear');
});
Route::get('/conficache', function(){
  artisan::call('config:cache');
});
require __DIR__.'/auth.php';
