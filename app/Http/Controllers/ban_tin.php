<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_teaching_recording;
use App\Models\student;
use App\Models\teacher;
use App\Models\subject;
use App\Http\Controllers\teaching_recording\details_teaching_recording;
class ban_tin extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $days = isset($_GET['days'])?$_GET['days']:'now';
        //Lớp ngày hôm nay
        $today_class = $this->todayclass(strtotime($days));
        $data_student = student::pluck('full_name','id_student');
        $data_teacher = teacher::pluck('fullname','id_teacher');
        $data_subject = subject::pluck('name','id');
        return view('dashboard',[
            'todayClass'=>$today_class,
            'teachers'=>$data_teacher,
            'students'=>$data_student,
            'subjects'=>$data_subject,
            'days'=>$days
        ]);
    }
    public function todayclass($days){
        $data = M_teaching_recording::all();
        $array = array();
        foreach ($data as $value) {
            $diemdanh = json_decode($value['teaching_history']);
            if($diemdanh==null){
            continue;
            }else{
                foreach ($diemdanh as $value1) {
                    foreach ($value1->lich_hoc_du_kien as $buoi_hoc) {
                        if (date('d-m-Y',$buoi_hoc->time) === date('d-m-Y',$days)) {
                            $buoi_hoc->id_prof = $value1->ma_giao_vien;
                            $buoi_hoc->id_student = $value['id_student'];
                            $buoi_hoc->id = $value['id'];
                            $array[] = $buoi_hoc;
                        }
                    }
                }
            }
        }
        usort($array,function($a,$b){
            return $a->time<=>$b->time;
        });
        return($array);
    }

}
