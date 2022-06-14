<?php

namespace App\Http\Controllers\teaching_recording;
// controller
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// call model
use App\Models\M_teaching_recording;
use App\Models\student;


class details_teaching_recording extends Controller
{
    // hàm này kiểm tra thời gian học và thời gian còn lại của nhật ký giảng dạy
    public static function getStudyInfo($id_nkgd){
        $study_hour = 0;
        $time_left=0;
        $data_teaching_recording = DB::table('teaching_recording')->where('id',$id_nkgd)->first();
        $objdd = json_decode($data_teaching_recording->teaching_history);
        if ($objdd==null) {
            $study_hour = 0;// Check lỗi
            $time_left = 0;
        }else{
            if ($data_teaching_recording->type==1) {
                foreach ($objdd as  $mon_hoc) {
                    foreach ($mon_hoc->lich_hoc_du_kien as $buoi_hoc) {
                        if (isset($buoi_hoc->hours)&& !isset($mon_hoc->finish)) {
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
                      if (isset($buoi_hoc->hours)) {
                          $study_hour+= $buoi_hoc->hours;
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
    //* Hàm kiểm tra buổi có bị trùng không
    public function check_duplicate_date($id_nkgd,$id_teacher,$id_student,$date,$start_time){
        // Check trùng buổi
        // Sửa buổi
    }
    /*
     * Add function
     */
    // Nút reset, đổi trạng thái ngày input thành trạng thái chưa thao tác ban đầu
    public function reset_date(Request $request){
        $id = $request->input('id_nkgd');
        $id_subject = $request->input('id_subject');
        $id_teacher = $request->input('id_teacher');
        $time = $request->input('time');
        $status = 'false';
        $data_teaching_recording = M_teaching_recording::find($request->input('id_nkgd'));

        $obj_teaching_history = json_decode($data_teaching_recording->teaching_history);

        foreach ($obj_teaching_history as $mon_hoc) {
           if($mon_hoc->ma_giao_vien ==$request->input('id_teacher') && $mon_hoc->ma_mon ==$request->input('id_subject')){
                foreach ($mon_hoc->lich_hoc_du_kien as $key=>$buoi_hoc) {
                    if($time == $buoi_hoc->time){
                        // unset($mon_hoc->lich_hoc_du_kien[$key]);// Không sử dụng unset vì khi json encode nó tự ghi khóa vào
                        $status = 'success';
                        unset($buoi_hoc->hours);
                        if (isset($buoi_hoc->teacher_hours)) {
                            unset($buoi_hoc->teacher_hours);
                        }
                        if(isset($buoi_hoc->doanh_thu)){
                            unset($buoi_hoc->doanh_thu);
                        }
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
        return response()->json([
            'status' => $status
        ]);
    }
    // Nút edit thời gian
    public function edit_time_date(Request $request){
        $id = $request->input('id_nkgd');
        $id_subject = $request->input('id_subject');
        $id_teacher = $request->input('id_teacher');
        $time = $request->input('time');
        $start_edit_time = $request->input('start_time');
        $end_edit_time = $request->input('end_time');
        $status = 'false';
        $data_teaching_recording = M_teaching_recording::find($request->input('id_nkgd'));
        // if($data_teaching_recording==null){
        //     return response()->json([
        //         'status' => $status
        //     ]);
        // }
        $obj_teaching_history = json_decode($data_teaching_recording->teaching_history);
        foreach ($obj_teaching_history as $mon_hoc) {
            if($mon_hoc->ma_giao_vien ==$request->input('id_teacher') && $mon_hoc->ma_mon ==$request->input('id_subject')){
                 foreach ($mon_hoc->lich_hoc_du_kien as $key=>$buoi_hoc) {
                     if($time == $buoi_hoc->time){
                        $buoi_hoc->starttime=$start_edit_time;
                        $buoi_hoc->endtime=$end_edit_time;
                         $status='success';
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
         return response()->json([
             'status' => $status
         ]);
    }
    // Thêm gói mới hoặc renew gói giờ
    public function add_new_packet_hours(Request $request){

        $id_nkgd = $request->input('id_nkgd');
        $id_student=$request->input('id_student');
        $ten_hoc_sinh=$request->input('ten_hoc_sinh');
        $so_hoa_don=$request->input('so_hoa_don');
        $so_gio=$request->input('so_gio');
        $ngay_bat_dau=$request->input('ngay_bat_dau');
        $ngay_nhan=$request->input('ngay_nhan');
        $so_tien=$request->input('so_tien');
        $reserveAmount = $request->input('bao_luu');
        $obj_renew = [
            'ma_nkgd'=>$id_nkgd,
            'ten_hoc_sinh'=>$ten_hoc_sinh,
            'so_hoa_don'=>$so_hoa_don,
            'so_gio'=>$so_gio,
            'ngay_bat_dau'=>$ngay_bat_dau,
            'ngay_nhan'=>$ngay_nhan,
            'so_tien'=>$so_tien
        ];
        // Thêm giờ vào total hours
        $data_teaching_recording = M_teaching_recording::find($id_nkgd);
        $new_total_hours = $data_teaching_recording->total_hours + $so_gio;
        $data_teaching_recording->total_hours = $new_total_hours;

        // Xóa/trừ tiền bảo lưu nếu có
        if($reserveAmount!=null){
            $obj_renew['bao_luu'] = $reserveAmount;
            $studentInfo = student::find($id_student);
            $oldReserve = $studentInfo->reserve;
            $newReserve = $oldReserve - $reserveAmount;
            $studentInfo->reserve =  $newReserve;
            $studentInfo->save();
        }
        //Thêm chuỗi gắn chuỗi json renew vào renew_history

        if($data_teaching_recording->renew_history==null){
            $new_array = array();
            array_push($new_array,$obj_renew);
            $new_json_edit = json_encode($new_array);
        }
        else {
            $old_array = json_decode($data_teaching_recording->renew_history);
            array_push($old_array,$obj_renew);
            $new_json_edit = json_encode($old_array);
        }
        $status = false;
        if($new_json_edit==null){
            echo "Dữ liệu lỗi";
        }
        else {
            $data_teaching_recording->renew_history = $new_json_edit;
            $data_teaching_recording->save();
            $status = 'success';
            return response()->json([
                'status' => $status
            ]);
        }
    }
    // Thêm môn học kèm theo giáo viên
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
    // Thêm một buổi
    public function add_day_teaching_history(Request $request){

        $obj_add_date = array();
        $obj_add_date['date'] = date('d-M-Y',strtotime($request->input('newdate')));
        $obj_add_date['starttime'] = $request->input('starttime');
        $obj_add_date['endtime'] = $request->input('endtime');
        $obj_add_date['id'] = $request->input('id_nkgd');
        $obj_add_date['time'] = strtotime($obj_add_date['date']." ".$obj_add_date['starttime']);

        $id_teacher = $request->input('id_teacher');
        $id_subject = $request->input('id_subject');
        // Lấy chuỗi json cũ kiểm tra có trùng không thêm obj mới vào
        $data_teaching_history = M_teaching_recording::where('id',$request->input('id_nkgd'))->first();
        $obj_teaching_history = json_decode($data_teaching_history->teaching_history);

        foreach ($obj_teaching_history as $mon_hoc) {
           if($mon_hoc->ma_giao_vien == $id_teacher && $mon_hoc->ma_mon == $id_subject){
                $check_trung_status = false;
                foreach ($mon_hoc->lich_hoc_du_kien as $buoi_hoc) {
                    if(strtotime($obj_add_date['date']) === strtotime($buoi_hoc->date) && $obj_add_date['starttime'] == $buoi_hoc->starttime ){
                        $check_trung_status = true;
                        break;// Thoát vòng lặp
                    }
                }
                if($check_trung_status===false){
                    array_push($mon_hoc->lich_hoc_du_kien,$obj_add_date);
                }
           }else{
            continue;
           }
        }
        if($check_trung_status===true){
            return response()->json([
                'status' => 'false',
                'messenger'=>'Buổi bị trùng'
            ]);
        }elseif($check_trung_status===false){
            $data_teaching_history->teaching_history = json_encode($obj_teaching_history);
            $data_teaching_history->save();
            // return redirect()->route('teaching_recording_detail',['id'=>$request->input('id')]);
            return response()->json([
                'status' => 'success',
                'data'=>$obj_add_date
            ]);
        }
    }
    // Thêm nhiều buổi
    public function add_day_range_teaching_history(Request $request){

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
        $days=array('thu2'=>'Monday','thu3' => 'Tuesday','thu4' => 'Wednesday','thu5'=>'Thursday','thu6' =>'Friday','thu7' => 'Saturday','chunhat'=>'Sunday');
        foreach ($obj_lich_hoc as $thungay => $hours) {
            for($i = strtotime($days[$thungay], $startDate); $i <= $endDate; $i = strtotime('+1 week', $i)){
                $temp_array=array();
                $temp_array['id'] = $request->id;
                $temp_array['starttime'] = $hours->start;
                $temp_array['endtime'] = $hours->end;
                $temp_array['date'] = date('d-M-Y',$i);
                $temp_array['time'] = strtotime(date('d-M-Y',$i)." ".$hours->start);
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
              if($mon_hoc->lich_hoc_du_kien==null){
                  foreach ($array_date_range as $buoi_hoc_moi) {
                      array_push($mon_hoc->lich_hoc_du_kien,$buoi_hoc_moi);
                  }
              }else{
                foreach ($array_date_range as $buoi_hoc_moi) {
                  $flag = false;
                  foreach ($mon_hoc->lich_hoc_du_kien as $buoi_hoc) {
                      if($buoi_hoc_moi['date'] === $buoi_hoc->date
                      && $buoi_hoc_moi['starttime'] === $buoi_hoc->starttime ){
                        $flag = true;
                        break;
                      }
                  }
                  if($flag===false){
                    array_push($mon_hoc->lich_hoc_du_kien,$buoi_hoc_moi);
                  }
                }
              }
            }
        }
        $data_teaching_history->teaching_history = json_encode($obj_teaching_history);
        $data_teaching_history->save();
        return redirect()->route('teaching_recording_detail',['id'=>$request->input('id')])->with('status', 'Thành công');;
    }
    // Thêm note
    public function add_note_of_date(Request $request){

        $id = $request->input('id_nkgd');
        $id_subject = $request->input('id_subject');
        $id_teacher = $request->input('id_teacher');
        $time = $request->input('time');
        $note = $request->input('note');
        $type_note = $request->input('type_note');
        $status = 'false';
        // Lấy dữ liệu teaching history cũ
        $data_teaching_recording = M_teaching_recording::find($request->input('id_nkgd'));
        $obj_teaching_history = json_decode($data_teaching_recording->teaching_history);
        foreach ($obj_teaching_history as $mon_hoc) {
           if($mon_hoc->ma_giao_vien ==$request->input('id_teacher') && $mon_hoc->ma_mon ==$request->input('id_subject')){
                foreach ($mon_hoc->lich_hoc_du_kien as $key=>$buoi_hoc) {
                    if($time == $buoi_hoc->time){
                        $buoi_hoc->note= $note;
                        if($type_note!=null){
                          $buoi_hoc->$type_note= $note;
                        }
                        $status = 'success';
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
        return response()->json([
            'status' => $status
        ]);
    }
    // Hàm xử lý nút điểm danh
    public function add_roll_up_date(Request $request){
        $id = $request->input('id_nkgd');
        $id_subject = $request->input('id_subject');
        $id_teacher = $request->input('id_teacher');
        $time = $request->input('time');
        $hours = $request->input('hours');
        $teacher_hours = $request->input('teacher_hours');
        $status = 'false';
        // Lấy dữ liệu teaching history cũ
        $data_teaching_recording = M_teaching_recording::find($request->input('id_nkgd'));
        $obj_teaching_history = json_decode($data_teaching_recording->teaching_history);
        $data_renew_history = json_decode($data_teaching_recording->renew_history);
        foreach ($obj_teaching_history as $mon_hoc) {
           if($mon_hoc->ma_giao_vien ==$request->input('id_teacher') && $mon_hoc->ma_mon ==$request->input('id_subject')){
                foreach ($mon_hoc->lich_hoc_du_kien as $key=>$buoi_hoc) {
                    if($time == $buoi_hoc->time){
                        //Điểm danh
                        if($teacher_hours!=null){
                            $buoi_hoc->teacher_hours = $teacher_hours;
                        }
                        $buoi_hoc->hours = $hours;
                        // Tính toán doanh thu
                        $doanh_thu = $this->tinh_doanh_thu_cua_ngay($hours,$buoi_hoc->time,$data_renew_history);
                        $buoi_hoc->doanh_thu = $doanh_thu;
                        $status = 'success';
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
        return response()->json([
            'status' => $status,
            'hours'=>$hours,
            'teacher_hours'=>isset($teacher_hours)?$teacher_hours:$hours
        ]);
    }
    // Nút hoàng thành môn học, sẽ ẩn môn học đi
    public function finish_subject(Request $request){
        $id = $request->input('id_nkgd');
        $id_subject = $request->input('id_subject');
        $id_teacher = $request->input('id_teacher');
        $finish = $request->input('finish');
        $data_teaching_recording = M_teaching_recording::find($id);
        $obj_teaching_history = json_decode($data_teaching_recording->teaching_history);
        $status='false';
        foreach ($obj_teaching_history as $mon_hoc) {
            if($mon_hoc->ma_giao_vien == $id_teacher && $mon_hoc->ma_mon ==$id_subject){
                if($finish==='true'){
                    $mon_hoc->finish=true;
                }else{
                    unset($mon_hoc->finish);
                }
                $status='success';
                break;
            }
         }
         $new_json = json_encode($obj_teaching_history);
         $data_teaching_recording->teaching_history = $new_json;
         $data_teaching_recording->save();
         return response()->json([
             'status' => $status
         ]);
    }
    // Nút đổi ngày
    public function change_date(Request $request){
        $id_nkgd = $request->input('id_nkgd');
        $id_subject = $request->input('id_subject');
        $id_teacher = $request->input('id_teacher');
        $id_student = $request->input('id_student');
        $old_time = $request->input('old_time');// Time type
        $new_time = $request->input('new_date');
        $new_start_time = $request->input('start_new_time');
        $new_end_time = $request->input('end_new_time');
        $note_new_time = $request->input('note_new_time');
        // Lấy dữ liệu teaching history cũ
        $data_teaching_recording = M_teaching_recording::find($request->input('id_nkgd'));
        $obj_teaching_history = json_decode($data_teaching_recording->teaching_history);
        $status = 'false';
        foreach ($obj_teaching_history as $mon_hoc) {
            if($mon_hoc->ma_giao_vien ==$request->input('id_teacher') && $mon_hoc->ma_mon ==$request->input('id_subject')){
                 foreach ($mon_hoc->lich_hoc_du_kien as $key=>$buoi_hoc) {
                     if(date("d-m-Y",$old_time) == date("d-m-Y",$buoi_hoc->time)){
                        // edit Time, Date, Start Time, End Time from old to new
                        $buoi_hoc->time = strtotime($new_time);
                        $buoi_hoc->date = $new_time;
                        $buoi_hoc->starttime = $new_start_time;
                        $buoi_hoc->endtime = $new_end_time;
                        $buoi_hoc->note= $note_new_time;
                        $status = 'success';
                     }else{
                         continue;
                     }
                 }
            }
         }
        $new_json = json_encode($obj_teaching_history);
        $data_teaching_recording->teaching_history = $new_json;
        $data_teaching_recording->save();
        $messenger = 'Thành Công!';
        return response()->json([
            'status' => $status,
            'error_messenger' => $messenger
        ]);
    }
    /*
     * Các thao tác trong phần bảo lưu
     */
    public function bao_luu_goi_gio(Request $request){
        $id_student = $request->input('id_student');
        $amount = $request->input('amount');
        $save_hours = $request->input('hours');
        $id_teaching_recording = $request->input('id_nkgd');
        $messenger = '';
        $studentInfo = student::find($id_student);
        $data_teaching_recording = M_teaching_recording::find($id_teaching_recording);
        if($id_student==null||$amount==null){
            $status=false;
            $messenger= "Không có dữ liệu truyền vào!";
        }
        //Lưu 'bảo lưu học phí' của học sinh vào CSDL
        $oldreserve= $studentInfo->reserve;
        if($oldreserve>=0){
            $amount+=$oldreserve;
            $status='success';
            $messenger = "Đã lưu số tiền bảo lưu";
        }else{
            $status='false';
            $messenger = "Dữ liệu bảo lưu sai!";
        }
        $studentInfo->reserve = $amount;
        $studentInfo->save();
        //Trừ số giờ đã bảo lưu trong phần 'Teaching Recording'
        $oldHours = $data_teaching_recording->total_hours;
        $newHours = $oldHours - $save_hours;
        $data_teaching_recording->total_hours= $newHours;
        $data_teaching_recording->save();

        return response()->json([
             'status' => $status,
             'messenger'=>$messenger
         ]);
    }
    public function from_revenue_to_hours(Request $request){
        $id_student = $request->input('id_student');
        $id_teaching_recording = $request->input('id_nkgd');

        $amount_of_money = $request->input('amountOfMoney');
        $hours = $request->input('hours');// Tiền bảo lưu

        $studentInfo = student::find($id_student);
        $data_teaching_recording = M_teaching_recording::find($id_teaching_recording);

        $old_total_hours = $data_teaching_recording->total_hours;
        $new_hours =  $old_total_hours+$hours;
        $data_teaching_recording->total_hours = $new_hours;

        $old_money = $studentInfo->reserve;
        $new_money = $old_money-$amount_of_money;
        $studentInfo->reserve =$new_money;

        $studentInfo->save();
        $data_teaching_recording->save();

        return response()->json([
            'status' => 'success'
        ]);
    }
    public function transfer_revenue(Request $request){

        $id_source_student = $request->input('id_source_student');
        $id_des_student = $request->input('id_des_student');
        $amount_of_money = $request->input('amountOfMoney');

        $sourceStudent = student::find($id_source_student);
        $desStudent = student::find($id_des_student);

        $newMoneySource = $sourceStudent->reserve - $amount_of_money;
        $newMoneyDes = $desStudent->reserve + $amount_of_money;
        if($newMoneySource<0 ||$newMoneyDes<0){
            $status = 'false';
            $messenger = 'Sai dữ liệu, kiểm tra lại input!';
        }else{
            $sourceStudent->reserve = $newMoneySource;
            $sourceStudent->save();
            $desStudent->reserve = $newMoneyDes;
            $desStudent->save();
            $status = 'success';
            $messenger = 'Thành công';
        }
        return reponse()->json([
            'status' => $status,
            'messenger'=>$messenger
        ]);
    }
    /*
     * Phần thêm, xóa LỊCH SỬ DOANH THU
    */
    public function edit_renew_history(Request $request){

        $id_nkgd = $request->input('id_nkgd');
        $key = $request->input('key');//Thứ tự của lịch sử cần chỉnh sửa trong mảng renew_history
        $key_name = $request->input('key_name');
        $value = $request->input('value');

        $data_renew_history = M_teaching_recording::find($request->input('id_nkgd'));
        $obj_renew_history = json_decode($data_renew_history->renew_history);
        $obj_renew_history[$key]->$key_name = $value;
        $new_json = json_encode($obj_renew_history);

        $data_renew_history->renew_history = $new_json;
        if( $data_renew_history== null||$obj_renew_history==null){
            $status = 'false';
        }else{
            $status = 'success';
        }
        $data_renew_history->save();

        return response()->json([
            'status' => $status
        ]);
    }
    public function remove_renew_history(Request $request){

        $id_nkgd = $request->input('id_nkgd');
        $key = $request->input('key');//Thứ tự của lịch sử cần chỉnh sửa trong mảng renew_history

        $data_renew_history = M_teaching_recording::find($request->input('id_nkgd'));
        $obj_renew_history = json_decode($data_renew_history->renew_history);

        if( $data_renew_history== null||$obj_renew_history==null){
            $status = 'false';
            $messenger = 'Lỗi!, liên hệ web admin ';
        }elseif(count($obj_renew_history)==1){
            $status = 'false';
            $messenger = 'Dữ liệu renew history chỉ còn 1 record, xóa có thể gây ảnh hưởng tới việc tính toán doanh thu, vui lòng kiểm tra lại!';
        }else{
            $status = 'success';
            array_splice($obj_renew_history,$key,1);
            $new_json = json_encode($obj_renew_history);
            $data_renew_history->renew_history = $new_json;
            $data_renew_history->save();
            $messenger = 'Thành Công!';
        }
        return response()->json([
            'status' => $status,
            'error_messenger' => $messenger
        ]);
    }

    /*
    * Phần tính toán DOANH THU
    */
    public static function tinh_doanh_thu_cua_ngay($hour,$ngay_can_check,$data_renew_history){
        // Hàm này sẽ xuất số tiền trên
        $sotien= 0 ;
        $ngay_can_check = intval($ngay_can_check);

        // So sánh các khung giờ từ đầu tới cuối đề phòng học vụ điểm danh lại những ngày cũ
        if($data_renew_history!=null &&count($data_renew_history)>1){// lặp từ đầu tới gần cuối
            for ($i=0; $i < count($data_renew_history)-1 ; $i++) {
                $start = strtotime($data_renew_history[$i]->ngay_bat_dau);
                $end = strtotime($data_renew_history[$i+1]->ngay_bat_dau);
                if($ngay_can_check >= $start && $ngay_can_check <= $end ){
                    if(isset($data_renew_history[$i]->bao_luu))
                    { $bao_luu= $data_renew_history[$i]->bao_luu;}else{$bao_luu=0;};
                    $sotien = $hour*(($data_renew_history[$i]->so_tien+$bao_luu)/$data_renew_history[$i]->so_gio);
                    break;
                }
            }
        }
        //So sánh phần tử cuối của mảng tạo khung thời gian từ ngày cuối cùng tới ngày hôm nay

        $get_last_end_value = end($data_renew_history);
        $start = strtotime($get_last_end_value->ngay_bat_dau);
        $end = strtotime('+ 1 month');// Quên lý do vì sao đặt biến end, tạm thời xóa để kiểm tra

        if($ngay_can_check >= $start ){
            if(isset($get_last_end_value->bao_luu))
            { $bao_luu= $get_last_end_value->bao_luu;}else{$bao_luu=0;};
            $sotien = $hour*(($get_last_end_value->so_tien+$bao_luu)/$get_last_end_value->so_gio);
        }
        return $sotien;
    }
    public function syns_revenue(Request $request)// Hàm này đồng bộ lại doanh thu khi chỉnh sửa phần Renew history
    {

        $id_nkgd = $request->input('id_nkgd');
        $data_nkgd = M_teaching_recording::find($request->input('id_nkgd'));
        $status= 'false';
        $data_renew_history = json_decode($data_nkgd->renew_history);
        $obj_teaching_history = json_decode($data_nkgd->teaching_history);

        foreach ($obj_teaching_history as $object_mon) {
            foreach ($object_mon->lich_hoc_du_kien as $chi_tiet_buoi_hoc) {
                if(isset($chi_tiet_buoi_hoc->hours)){
                    $doanh_thu_recheck = $this->tinh_doanh_thu_cua_ngay($chi_tiet_buoi_hoc->hours,$chi_tiet_buoi_hoc->time,$data_renew_history);
                    $chi_tiet_buoi_hoc->doanh_thu = $doanh_thu_recheck;
                }else{
                    continue;
                }
                $status= 'success';
            }
        }
        $json_new = json_encode($obj_teaching_history);
        $data_nkgd->teaching_history= $json_new;
        $data_nkgd->save();
        return response()->json([
            'status' => $status
        ]);
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
        $status = 'false';
        // Lấy dữ liệu teaching history cũ
        $data_teaching_recording = M_teaching_recording::find($request->input('id_nkgd'));

        $obj_teaching_history = json_decode($data_teaching_recording->teaching_history);

        foreach ($obj_teaching_history as $mon_hoc) {
           if($mon_hoc->ma_giao_vien ==$request->input('id_teacher') && $mon_hoc->ma_mon ==$request->input('id_subject')){
                foreach ($mon_hoc->lich_hoc_du_kien as $key=>$buoi_hoc) {
                    if($time == $buoi_hoc->time){
                        // unset($mon_hoc->lich_hoc_du_kien[$key]);// Không sử dụng unset vì khi json encode nó tự ghi khóa vào
                        array_splice($mon_hoc->lich_hoc_du_kien,$key,1);
                        $status = 'success';
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
        return response()->json([
            'status' => $status
        ]);
    }
    public function delete_subject(Request $request){
        $validate = $request->validate([
            'id_nkgd'=> ['required'],
            'id_subject'=>['required'],
            'id_teacher'=>['required']
        ]);
        $id = $request->input('id_nkgd');
        $id_subject = $request->input('id_subject');
        $id_teacher = $request->input('id_teacher');
        $status = 'false';
        // Lấy dữ liệu teaching history cũ
        $data_teaching_recording = M_teaching_recording::find($request->input('id_nkgd'));

        $obj_teaching_history = json_decode($data_teaching_recording->teaching_history);

        foreach ($obj_teaching_history as $key=>$mon_hoc) {
           if($mon_hoc->ma_giao_vien ==$request->input('id_teacher') && $mon_hoc->ma_mon ==$request->input('id_subject')){
                array_splice($obj_teaching_history,$key,1);
                $status = 'success';
                break;
           }
            else{
                continue;
            }
        }
        $new_json = json_encode($obj_teaching_history);
        $data_teaching_recording->teaching_history = $new_json;
        $data_teaching_recording->save();
        return response()->json([
            'status' => $status
        ]);
    }
    /*
    * Đây là hàm fix lại chuỗi json teaching history khắc phục các vấn đề cũ, khi đưa lên hosting nhớ chạy ctrinh này trước
    * No return, No param
    */
    public function new_teaching_history_json(){
        $data = M_teaching_recording::all();
        foreach ($data as $nkgd) {
            $obj_teaching_history = json_decode($nkgd->teaching_history);
            if($nkgd->teaching_history!=null){
                foreach($obj_teaching_history as $value){
                    $array_temp=array();
                    foreach ($value->lich_hoc_du_kien as $classes) {
                        foreach ($classes as $time => $detail_class) {
                            $detail_class->date = date('d-M-Y',$time);
                            if(!empty($detail_class->starttime)){
                                $detail_class->time = strtotime(date('d-M-Y',$time)." ".$detail_class->starttime);
                            }else{
                               $detail_class->time = strtotime(date('d-M-Y',$time)." 12:00AM");
                            }
                            $array_temp[]=$detail_class;
                        }

                    }
                    $value->lich_hoc_du_kien = $array_temp;
                }
                $json_save = json_encode($obj_teaching_history);
                $nkgd->teaching_history = $json_save;
                $nkgd->save();
            }else{
                continue;
            }

        }
        /*
        * Phần dưới là thêm thuộc tính time chứa dạng time của buổi học bao gồm ngày và giờ bắt đầu
         */
        // $data = M_teaching_recording::all();
        // foreach ($data as $nkgd) {
        //     $obj_teaching_history = json_decode($nkgd->teaching_history);
        //         foreach($obj_teaching_history as $value){
        //             $array_temp=array();
        //             foreach ($value->lich_hoc_du_kien as$detail_class) {
        //                 if(!empty($classes->starttime)){
        //                     $classes->time = strtotime($classes->date." ".$classes->starttime);
        //                 }else{
        //                     $classes->time = strtotime($classes->date." 12:00AM");
        //                 }
        //             }
        //         }
        //     $json_save = json_encode($obj_teaching_history);
        //     $nkgd->teaching_history = $json_save;
        //     $nkgd->save();
        // }
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
    public function test(){
        $data= student::find(10);
        $data->reserve= 1;
        $data->save();
        // var_dump( $data);
    }
}
