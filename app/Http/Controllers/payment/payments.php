<?php

namespace App\Http\Controllers\payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\M_teaching_recording;
use App\Models\teacher_payment;
use App\Models\teacher;


class payments extends Controller
{
    //
    function index(){
        //Export student payment renew history
        $data_renew_history = M_teaching_recording::all('renew_history');
        $array_merge=array();
        foreach($data_renew_history as $value){
            if(is_array(json_decode($value['renew_history']))){
                // check array null or empty if yes, skip
                $array_merge=array_merge($array_merge,json_decode($value['renew_history']));
            }
        }
        // sort by ngay_nhan
        usort($array_merge, function($a, $b) {
            return strtotime($b->ngay_nhan) <=> strtotime($a->ngay_nhan);
        });
        //Export teacher payment monthly
        $data_teachers = teacher::pluck('fullname', 'id_teacher');
        $data_teacher_payments = teacher_payment::orderBy('id','DESC')->get();

        return view('pages.payment.payments',[
            'renew_history'=>$array_merge,
            'teachers'=>$data_teachers,
            'payments'=>$data_teacher_payments
        ]);
    }
    function update_once(Request $request){
        $column = $request->input('column');
        $value = $request->input('value');
        $id = $request->input('id');

        $teacher_payment = teacher_payment::find($id);
        $teacher_payment->$column = $value;
        $teacher_payment->save();

        return response()->json([
            'status' => 'success'
        ]);
    }
    function salary_check( Request $request){
      //insert salary check log 
      $teacher_payment = new teacher_payment;
      $teacher_payment->id_teacher = $request->input('id_teacher');
      $teacher_payment->luong_cua_thang = $request->input('luong_cua_thang');
      $teacher_payment->so_tien = $request->input('tien_luong');
      $teacher_payment->he_so_luong = $request->input('he_so_luong');
      $teacher_payment->so_gio = $request->input('so_gio');
      $teacher_payment->date_checked = strtotime('now');
      $teacher_payment->save(); 
    }
}
