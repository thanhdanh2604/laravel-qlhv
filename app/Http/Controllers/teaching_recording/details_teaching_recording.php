<?php

namespace App\Http\Controllers\teaching_recording;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\M_teaching_recording;

class details_teaching_recording extends Controller
{
    public static function getStudyInfo($id){
        $study_hour = 0;
        $data_teaching_recording = DB::table('teaching_recording')->where('id',$id)->first();
        $objdd = json_decode($data_teaching_recording->teaching_history);
        if ($objdd==null) {
            $study_hour = 0;// Check lỗi
            $time_left = 0;
        }
        else{
            if ($data_teaching_recording->type==1) {
                foreach ($objdd as  $mon_hoc) {
                    foreach ($mon_hoc->lich_hoc_du_kien as $buoi_hoc) {
                        if (isset($buoi_hoc->hours)&& $buoi_hoc->dd_student==1&& !isset($mon_hoc->finish)) {
                            $study_hour+= $buoi_hoc->hours;
                        }
                    }
                }
                $time_left = $data_teaching_recording->total_hours- $study_hour;
            }
            elseif($data_teaching_recording->type==2) {
                $study_hour=0;
                foreach ($objdd as $mon_hoc) {
                    foreach ($mon_hoc->lich_hoc_du_kien as $buoi_hoc) {
                        foreach ($buoi_hoc->dd_student as $id_hoc_sinh => $diem_danh_hoc_sinh) {
                            if (isset($buoi_hoc->hours)&& $diem_danh_hoc_sinh==1) {
                                $study_hour+= $buoi_hoc->hours;
                                break;
                            }
                        }
                    }
                }
                $time_left= $data_teaching_recording->total_hours- $study_hour;
            // Hiện tại lớp nhóm trung tâm không tính giờ riêng từng bạn, trong trường hợp sau này có thay đổi tính giờ từng bạn thì vòng lặp đầu lặp thêm mảng danh sách học viên và thêm điều kiện ở vòng if là được chi tiết có thể xem file json
        }

        }
        $array_time_study = array();
        $array_time_study = [
            'study_hours'=>$study_hour,
            'time_left'=>$time_left
        ];
        return $array_time_study;
    }
    public function add_new_teacher_and_subject( Request $request){

        $validate = $request->validate([
            'id_nkgd'=> ['required'],
            'id_subject'=>['required'],
            'id_teacher'=>['required']
        ]);

        $id = $request->input('id_nkgd');
        $id_subject = $request->input('id_subject');
        $id_teacher = $request->input('id_teacher');

        //Lấy dữ liệu teaching history cũ
        $data_nkgd = DB::table('teaching_recording')->where('id', '=', $id)->first();

        $obj_teaching_history = json_decode($data_nkgd->teaching_history);
        //Kiểm tra môn có bị trùng hay không
        if($obj_teaching_history!=null){
            foreach ($obj_teaching_history as $value) {
                if($value->ma_giao_vien==$id_teacher&&$value->ma_mon == $id_subject){
                    die("Môn học đã bị trùng, vui lòng kiểm tra lại!");
                }else{
                    continue;
                };
            }
        }
        // Kiểm tra lớp nhóm hay lớp 1-vs-1
        $type = $data_nkgd->type;

        // Tạo obj giáo viên mới vào teaching_history
        $objsubject = array();
        $objsubject['ma_mon'] = $id_subject;
        $objsubject['ma_giao_vien'] = $id_teacher;
        $objsubject['lich_hoc_du_kien'] = array();

        // xử lý nếu history rỗng và lưu vào csdl
        if ($obj_teaching_history==null) {
            $array_new = array();
            array_push($array_new,$objsubject);
            $newjson = json_encode($array_new);
            DB::table('teaching_recording')->where('id', $id)->update(['teaching_history'=>$newjson]);
            return redirect()->route('teaching_recording_detail',['id'=>$id]);
        }
        if($obj_teaching_history!=null){
            array_unshift($obj_teaching_history, $objsubject);
            $newjson = json_encode($obj_teaching_history);
            DB::table('teaching_recording')->where('id', $id)->update(['teaching_history'=>$newjson]);
            return redirect()->route('teaching_recording_detail',['id'=>$id]);
        }
    }
    public function add_day_teaching_history(Request $request){

        $validate = $request->validate([
            'malop'=>['required'],
            'newdate'=>['required'],
            'starttime'=>['required'],
            'endtime'=>['required'],
            'idstudent'=>['required'],
            'idprof'=>['required'],
        ]);

        $obj_add_date = array();
        $obj_add_date['date'] = date('d-M-Y',strtotime($request->input('newdate')));
        $obj_add_date['starttime'] = $request->input('starttime');
        $obj_add_date['endtime'] = $request->input('endtime');
        $obj_add_date['id'] = $request->input('id');
        $obj_add_date['dd_student'] = 0;
        $obj_add_date['dd_prof'] = 0;
        $obj_add_date['add_date']=true;

        // Lấy chuỗi json cũ kiểm tra có trùng không thêm obj mới vào
        $data_teaching_history = M_teaching_recording::where('id',$request->input('id'))->first();
        $obj_teaching_history = json_decode($data_teaching_history->teaching_history);

        foreach ($obj_teaching_history as $mon_hoc) {
           if($mon_hoc->ma_giao_vien ==$request->input('idprof') && $mon_hoc->ma_mon ==$request->input('mamonhoc')){
                foreach ($mon_hoc->lich_hoc_du_kien as $buoi_hoc) {
                    if($obj_add_date['date'] === $buoi_hoc->date && $obj_add_date['starttime'] === $buoi_hoc->starttime ){
                        break;// Thoát vòng lặp
                    }else{
                        array_push($mon_hoc->lich_hoc_du_kien,$obj_add_date);
                    }
                }
           }
        }

        $data_teaching_history->teaching_history = json_encode($obj_teaching_history);
        $data_teaching_history->save();
        return redirect()->route('teaching_recording_detail',['id'=>$request->input('id')]);
    }

    public function add_day_range_teaching_history(Request $request){

        $validate = $request->validate([
            'id'=>['required'],
            'id_student'=>['required'],
            'start_date'=>['required'],
            'end_date'=>['required'],
            'lich_hoc'=>['required'],
            'select_packet'=>['required']
        ]);
        // Lấy chuỗi packet ra đầu tiên là mã gv, phần tử thứ 2 là mã môn hộc
        $array_packet = explode('_', $request->select_packet);
        $id_teacher = $array_packet[0];
        $id_subject = $array_packet[1];
        //Lấy mảng danh sách ngày thực tế trong giờ học
        $startDate = strtotime($request->input('start_date'));
        $endDate = strtotime($request->input('end_date'));
        $obj_lich_hoc = json_decode($request->input('lich_hoc'));
        //tao moi array và lặp phần lịch học của mỗi phần tử mảng, xuất ra biến $thungay tất cả các ngày theo lịch

        $array_date_range = array();
        $days=array('thu2'=>'Monday','thu3' => 'Tuesday','thu4' => 'Wednesday','thu5'=>'Thursday','thu6' =>'Friday','thu7' => 'Saturday','CN'=>'Sunday');
        foreach ($obj_lich_hoc as $thungay => $hours) {
            for($i = strtotime($days[$thungay], $startDate); $i <= $endDate; $i = strtotime('+1 week', $i)){
                $temp_array=array();
                $temp_array['id'] = $request->id;
                $temp_array['starttime'] = $hours->start;
                $temp_array['endtime'] = $hours->end;
                $temp_array['dd_student'] = 0;
                $temp_array['dd_prof'] = 0;
                $temp_array['date'] = date('d-M-Y',$i);
                $array_date_range[]=$temp_array;
            }
        }
       // Lấy chuỗi json cũ thêm obj mới vào
        $data_teaching_history = M_teaching_recording::where('id',$request->input('id'))->first();

        $obj_teaching_history = json_decode($data_teaching_history->teaching_history);
        /*
        * Kiểm tra có buổi nào trùng với lịch học cũ không, nếu có thì bỏ qua
        */
        foreach ($obj_teaching_history as $mon_hoc) {
            if($mon_hoc->ma_giao_vien ==$id_teacher && $mon_hoc->ma_mon ==$id_subject){
                    foreach ($mon_hoc->lich_hoc_du_kien as $buoi_hoc) {
                        foreach ($array_date_range as $buoi_hoc_moi) {
                                if($buoi_hoc_moi['date'] === $buoi_hoc->date
                                && $buoi_hoc_moi['starttime'] === $buoi_hoc->starttime ){
                                    break;// Bỏ qua những buổi bị trùng
                                }else{
                                    array_push($mon_hoc->lich_hoc_du_kien,$buoi_hoc_moi);
                                }
                        }
                    }
            }
        }

        $data_teaching_history->teaching_history = json_encode($obj_teaching_history);
        $data_teaching_history->save();
        return redirect()->route('teaching_recording_detail',['id'=>$request->input('id')]);
    }
    /*
    * Delete function
    */
    public function delete_date_of_subject(Request $request){
        $validate = $request->validate([
            'id_nkgd'=> ['required'],
            'id_subject'=>['required'],
            'id_teacher'=>['required'],
            'time'=>['required']
        ]);
        $id = $request->input('id_nkgd');
        $id_subject = $request->input('id_subject');
        $id_teacher = $request->input('id_teacher');
        $time = $request->input('time');

        // Lấy dữ liệu teaching history cũ
        $data_teaching_recording = M_teaching_recording::find($request->input('id_nkgd'));

        $obj_teaching_history = json_decode($data_teaching_recording->teaching_history);

        foreach ($obj_teaching_history as $mon_hoc) {
           if($mon_hoc->ma_giao_vien ==$request->input('id_teacher') && $mon_hoc->ma_mon ==$request->input('id_subject')){
                foreach ($mon_hoc->lich_hoc_du_kien as $key=>$buoi_hoc) {
                    if($time == $buoi_hoc->time){
                        // unset($mon_hoc->lich_hoc_du_kien[$key]);// Không sử dụng unset vì khi json encode nó tự ghi khóa vào
                        array_slice($mon_hoc->lich_hoc_du_kien,$key,1);
                        break;
                    }else{
                        continue;
                    }
                }
           }
        }
        $new_json = json_encode($obj_teaching_history);
        $data_teaching_recording->teaching_history = $new_json;
        $data_teaching_recording->save();
    }
    /*
    * Đây là hàm fix lại chuỗi json teaching history khắc phục các vấn đề cũ, khi đưa lên hosting nhớ chạy ctrinh này trước
    * No return, No param
    */
    public function new_teaching_history_json(){
        // $data = M_teaching_recording::all();
        // foreach ($data as $nkgd) {
        //     $obj_teaching_history = json_decode($nkgd->teaching_history);
        //         foreach($obj_teaching_history as $value){
        //             $array_temp=array();
        //             foreach ($value->lich_hoc_du_kien as $classes) {
        //                 foreach ($classes as $time => $detail_class) {
        //                     $detail_class->date = date('d-M-Y',$time);//
        //                     $array_temp[]=$detail_class;
        //                 }
        //             }
        //             $value->lich_hoc_du_kien = $array_temp;
        //         }
        //     $json_save = json_encode($obj_teaching_history);
        //     $nkgd->teaching_history = $json_save;
        //     $nkgd->save();
        // }
        /*
        * Phần dưới là thêm thuộc tính time chứa dạng time của buổi học bao gồm ngày và giờ bắt đầu
         */
        $data = M_teaching_recording::all();
        foreach ($data as $nkgd) {
            $obj_teaching_history = json_decode($nkgd->teaching_history);
                foreach($obj_teaching_history as $value){
                    $array_temp=array();
                    foreach ($value->lich_hoc_du_kien as $classes) {
                        if(!empty($classes->starttime)){
                            $classes->time = strtotime($classes->date." ".$classes->starttime);
                        }
                    }
                }
            $json_save = json_encode($obj_teaching_history);
            $nkgd->teaching_history = $json_save;
            $nkgd->save();
        }
    }
    /*
    Sort phần teaching history theo ngày của mỗi nhật ký giảng dạy
    @input chuỗi json của teaching history
    @output mảng teaching history
    */
    public function sortTeachingHistory($json_teaching_history){
        $obj_teaching_history = json_decode($json_teaching_history);
        foreach ($obj_teaching_history as $mon_hoc) {
            usort($mon_hoc->lich_hoc_du_kien, function($a,$b){
                return (strtotime($a->date) < strtotime($b->date))?-1: 1;
            });
        }
        return $obj_teaching_history;
    }

}
