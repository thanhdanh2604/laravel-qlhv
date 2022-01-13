<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class teaching_recording extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = DB::table('teaching_recording')->orderBy('id', 'desc')->get();
        $data_student = DB::table('student')->pluck('full_name','id_student');
        $data_teacher = DB::table('teacher')->pluck('fullname','id_teacher');
        return view('pages.teaching_recording.teaching_recordings',[
            'teaching_recordings'=>$data,
            'students'=>$data_student,
            'teachers'=>$data_teacher
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        //Validate input data
        $validate = $request->validate([
            'name'=> ['required','max:255'],
            'type_class'=>['required'],
            'ma_lop'=>['required']
        ]);
        //Create Teacher
        $name = $request->input('name');
        $type = $request->input('type_class');
        $ma_lop = $request->input('ma_lop');
        switch ($type) {
            case 1:
                $student = $request->input('student');
                break;
            case 2:
                $student = json_encode($request->input('group_student'));
                break;
            default:
                die("Sai type Class!");
                break;
        }
        DB::table('teaching_recording')->insert([
           'name' => $name,
           'type' => $type,
           'ma_lop'=>$ma_lop,
           'id_student'=>$student
        ]);
        return redirect()->route('teaching_recordings');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
         //Show deatail infomation of teaching_recording
         $data_teaching_recording = DB::table('teaching_recording')->where('id',$id)->first();
         $data_subject = DB::table('subject')->pluck('name','id');
        $data_teacher = DB::table('teacher')->pluck('fullname','id_teacher');

        $data_study_info = $this->getStudyInfo($id);
        switch ($data_teaching_recording->type) {
            case 1:
                $data_student = DB::table('student')->where('id_student',$data_teaching_recording->id_student)->first();
                return view('pages.teaching_recording.detail-teaching_recording',['teaching_recording'=>$data_teaching_recording,'subjects'=>$data_subject,'study_info'=>$data_study_info,'teachers'=>$data_teacher,'students'=>$data_student]);
                break;
            case 2:
                $data_student = array();
                return view('pages.teaching_recording.detail-group-teaching_recording',['teaching_recording'=>$data_teaching_recording,'subjects'=>$data_subject,'study_info'=>$data_study_info,'teachers'=>$data_teacher,'students'=>$data_student]);
            default:
                die("Dữ liệu lỗi!");
                break;
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$column,$id)
    {
        //Xử lý cập nhập trường nhất định trong table
        $data_column = $request->input($column);
        DB::table('teaching_recording')->where('id', $id)
                    ->update([$column=>$data_column]);

         return redirect()->route('teaching_recording_detail',['id' => $id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Delete record on table
        DB::table('teaching_recording')->where('id', '=', $id)->delete();
        return redirect()->route('teaching_recordings');
    }
    public function getStudyInfo($id){
        $study_hour = 0;
        $data_teaching_recording = DB::table('teaching_recording')->where('id',$id)->first();
        $objdd = json_decode($data_teaching_recording->teaching_history);
        if ($objdd==null) {
            $study_hour = 0;// Check lỗi
            $time_left = 0;
        }
        else{
            if ($data_teaching_recording->type==1) {
                foreach ($objdd as $key => $value) {
                    foreach ($value->lich_hoc_du_kien as $key1 => $value1) {
                        foreach ($value1 as $key2 => $value2) {
                            if (isset($value2->hours)&& $value2->dd_student==1&& !isset($value1->finish)) {
                                $study_hour+= $value2->hours;
                            }
                        }
                    }
                }
            $time_left = $data_teaching_recording->total_hours- $study_hour;
            }
            elseif($data_teaching_recording->type==2) {
            $study_hour=0;
            foreach ($objdd as $key => $value) {
                foreach ($value->lich_hoc_du_kien as $key1 => $value1) {
                foreach ($value1 as $key2 => $value2) {
                    foreach ($value2->dd_student as $key3 => $value3) {
                        if (isset($value2->hours)&& $value3==1) {
                        $study_hour+= $value2->hours;
                        break;
                        }
                    }
                }
                }
            }
            $time_left= $data_teaching_recording->total_hours- $study_hour;
            // Hiện tại lớp nhóm trung tâm không tính giờ riêng từng bạn, trong trường hợp sau này có thay đổi tính giờ từng bạn thì vòng lặp đầu lặp thêm mảng danh sách học viên và thêm điều kiện ở vòng if là được
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
        $name = $request->input('name');
        $ma_lop = $request->input('malop');
        $newdate = $request->input('newdate');
        $starttime = $request->input('starttime');
        $endtime = $request->input('endtime');
        $id = $request->input('id');
        $id_student = $request->input('idstudent');
        $id_prof = $request->input('idprof');
        $id_subject = $request->input('mamonhoc');
        $string_date =  $newdate." ".$starttime;
        echo date('d-m-Y F Y h:i:s A',strtotime($string_date));
    }
}
