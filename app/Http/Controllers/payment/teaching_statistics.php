<?php

namespace App\Http\Controllers\payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// call model
use App\Models\teacher;
use App\Models\M_teaching_recording;
use App\Models\subject;
use App\Models\student;



class teaching_statistics extends Controller
{
    //
    function index(){
        $data_teachers = teacher::get();
        $data_teaching_hours =$this->get_all_teaching_hours();
        return view('pages.payment.teacher_payment.teaching_statistics',[
            'teachers'=>$data_teachers,
            'teaching_hours'=>$data_teaching_hours
        ]);
    }
    function teaching_detail($id_teacher,$start_date=null,$end_date=null,$month=null){

        $data_teaching_recording = M_teaching_recording::pluck('teaching_history');
        $data_teachers = teacher::get();
        $data_students = student::pluck('full_name','id_student');
        $data_subjects = subject::pluck('name','id');

        $detail_teacher = teacher::find($id_teacher);
        $month = isset($_GET['month'])?$_GET['month']:null;
        $start_date = isset($_GET['start_date'])?$_GET['start_date']:null;
        $end_date = isset($_GET['end_date'])?$_GET['end_date']:null;

        if($month!=null){
            $start_date = date('Y-m-01',strtotime($month));
            $end_date = date('Y-m-t',strtotime($month));
            $next_month = mktime(0,0,0,date("m",$month)+1,1,date("Y",$month));
            $pre_month = mktime(0,0,0,date("m",$month)-1,1,date("Y",$month));
        }elseif(($start_date==null)||$end_date==null){
            $start_date = date('Y-m-01',strtotime('last month'));
            $end_date = date('Y-m-t',strtotime('last month'));
            $month=strtotime('last month');
            $next_month = mktime(0,0,0,date("m",$month)+1,1,date("Y",$month));
            $pre_month = mktime(0,0,0,date("m",$month)-1,1,date("Y",$month));
        }

        $details = array();
		foreach ($data_teaching_recording as $value ) {
            $check_have_class_in_month=false;
            $teaching_history_data = json_decode($value);
            if($teaching_history_data ===null){
                continue;
            }else{
                foreach ($teaching_history_data as $each_NKGD) {
                    if ($each_NKGD->ma_giao_vien==$id_teacher) {
                        foreach ($each_NKGD->lich_hoc_du_kien as $chi_tiet_buoi) {
                            if (($chi_tiet_buoi->time>=strtotime($start_date))&&($chi_tiet_buoi->time<=strtotime($end_date)) ) {

                                $check_have_class_in_month == true;
                                break;
                            }
                        }
                    }
                    if ($check_have_class_in_month == true) {
                        $details[]=$each_NKGD;
                    }
                }
            }
        }
        return view('pages.payment.teacher_payment.teaching_detail',[
            'teaching_details'=>$details,
            'teachers'=>$data_teachers,
            'students'=>$data_students,
            'subjects'=>$data_subjects,
            'detail_teacher'=>$detail_teacher,
            'start_date'=> $start_date,
            'end_date'=>$end_date,
            'month'=>$month,
            'next_month'=>$next_month,
            'pre_month'=>$pre_month
        ]);
    }
    function get_all_teaching_hours($start_date=null,$end_date=null){

        $data_teaching_recording = M_teaching_recording::pluck('teaching_history');

        if(($start_date==null)||$end_date==null){
            $start_date = date('Y-m-01',strtotime('last month'));
            $end_date = date('Y-m-t',strtotime('last month'));
        }elseif($month!=null){
            $start_date = date('Y-m-01',strtotime('last month'));
            $end_date = date('Y-m-t',strtotime('last month'));
        }
        $array_temp = array();
		foreach ($data_teaching_recording as $value ) {
            $data1 = json_decode($value);
            if($data1 ===null){
                continue;
            }else{
                foreach ($data1 as $value1) {
                    foreach ($value1->lich_hoc_du_kien as $chi_tiet_buoi) {
                        if (($chi_tiet_buoi->time>=strtotime($start_date))&&($chi_tiet_buoi->time<=strtotime($end_date)) ) {
                            if(isset($chi_tiet_buoi->hours)){
                                if(isset($chi_tiet_buoi->teacher_hours)){
                                    // kiểm tra có giờ dạy riêng không, nếu có lưu lại
                                    $final_hours= $chi_tiet_buoi->teacher_hours;
                                }else{
                                    $final_hours= $chi_tiet_buoi->hours;
                                }
                                if(isset($array_temp[$value1->ma_giao_vien])){
                                    $array_temp[$value1->ma_giao_vien]+=$final_hours;
                                }else{
                                    $array_temp[$value1->ma_giao_vien]=$final_hours;
                                }
                            }
                        }
                    }
                }
            }
		}
		return $array_temp;

    }
}
