<?php


namespace App\Http\Controllers\teaching_recording;
use App\Http\Controllers\Controller;

use App\Http\Controllers\teaching_recording\details_teaching_recording;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\M_teaching_recording;
use App\Models\student;
use App\Models\teacher;
use App\Models\subject;

use Barryvdh\DomPDF\Facade\Pdf;

class teaching_recordings extends Controller
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
                $student = $request->input('student');//lớp 1-1
                break;
            case 2:
                $student = json_encode($request->input('group_student'));
                break;
                //Lớp group
            case 0:
                $student = $request->input('student');//lớp trail
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

        $data_study_info = details_teaching_recording::getStudyInfo($id);
        if($data_teaching_recording->teaching_history!=null){
            $data_teaching_history_sort = details_teaching_recording::sortTeachingHistory( $data_teaching_recording->teaching_history);
        }else{
            $data_teaching_history_sort = null;// Trường hợp chưa tạo lịch học
        }

        switch ($data_teaching_recording->type) {
            case 0: // Lớp group
                $data_student = DB::table('student')->where('id_student',$data_teaching_recording->id_student)->first();
                $allStudent = student::all();
                return view('pages.teaching_recording.detail-teaching_recording',[
                    'teaching_recording'=>$data_teaching_recording,
                    'obj_teaching_history'=>$data_teaching_history_sort,
                    'subjects'=>$data_subject,
                    'study_info'=>$data_study_info,
                    'teachers'=>$data_teacher,
                    'students'=>$data_student,
                    'allStudent'=> $allStudent
                ]);
                break;
            case 1: // Lớp 1-1
                $data_student = DB::table('student')->where('id_student',$data_teaching_recording->id_student)->first();
                $allStudent = student::all();
                return view('pages.teaching_recording.detail-teaching_recording',[
                    'teaching_recording'=>$data_teaching_recording,
                    'obj_teaching_history'=>$data_teaching_history_sort,
                    'subjects'=>$data_subject,
                    'study_info'=>$data_study_info,
                    'teachers'=>$data_teacher,
                    'students'=>$data_student,
                    'allStudent'=> $allStudent
                ]);
                break;
            case 2: // Lớp Group

                $data_student = student::all();
                return view('pages.teaching_recording.detail-group-teaching_recording',
                [
                    'teaching_recording'=>$data_teaching_recording,
                    'subjects'=>$data_subject,
                    'study_info'=>$data_study_info,
                    'teachers'=>$data_teacher,
                    'students'=>$data_student
                ]);
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
    public function edit(Request $request)
    {
        $id_nkgd = $request->input('id_nkgd');
        $key = $request->input('key');
        $key_value = $request->input('key_value');
        DB::table('teaching_recording')->where('id', $id_nkgd)
                    ->update([$key=>$key_value]);

        return response()->json([
            'status'=>'success'
        ]);
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
    /**
     * Export pdf file  
     * @param  int  $id
     *
     */
    public function export_pdf_file(){
      $pdf = PDF::loadView('test',['id'=>3])->setOptions(['defaultFont' => 'sans-serif']);
      return $pdf->download('invoice.pdf');
    }
    public function view_teaching_recording_report($id_nkgd){
        $month = isset($_GET['month'])?$_GET['month']:null;
        $data  = M_teaching_recording::find($id_nkgd);
        $students = student::pluck('full_name','id_student');
        $teachers = teacher::pluck('fullname','id_teacher');
        $subjects = subject::pluck('name','id');
        $study_info = details_teaching_recording::getStudyInfo($id_nkgd);
         //Lấy giờ thực tế để so sánh với giờ fill ra vì thỉnh thoản có trường hợp bé HỌC TRƯỚC giờ ghi trong hóa đơn
        $giodahoc =  $study_info['study_hours'];
        $time_left =  $study_info['time_left'];
        // Lấy tên học sinh
        if($data->type==2){
          $json_id_students = json_decode($data->id_student);
          $student_name="";
          foreach ($json_id_students as  $value_id_student) {
            $student_name .= (isset($students[$value_id_student])?$students[$value_id_student]:'')."</br>";
          };
        }elseif($data->type==1){
          $student_name = isset($students[$data->id_student])?$students[$data->id_student]:'';
        }
        // Lấy gói giờ gần nhất
        $obj_renew_history = json_decode($data->renew_history);
        $amount_of_hours_last_package =  end($obj_renew_history)->so_gio;
        
        if($month!=null){
          //Báo cáo theo tháng
          $current_year = substr($month,0,4);
          $current_month = substr($month,5,7);
          $amount_of_months = date('t',strtotime('01-'.$current_month.'-'.$current_year));
          $start = strtotime($current_month."/01/".$current_year);
          $end = strtotime($current_month."/".$amount_of_months."/".$current_year);
        }else{
          //Lấy giờ bắt đầu và kết thúc nếu được set hoặc lấy của gói gần nhất
          $start = isset($_GET['start'])?$_GET['start']:strtotime(end($obj_renew_history)->ngay_bat_dau);;
          $end = isset($_GET['end'])?$_GET['end']:strtotime('Today');
        }


        // Lấy các buổi dựa vào $start và $end lưu vào mảng mới
        $obj_teaching_history = json_decode($data->teaching_history);
        $array_new_teaching_history=array();
        $array_temp=array();
        foreach ($obj_teaching_history as $object_mon) {
          $teacherName = isset($teachers[$object_mon->ma_giao_vien])?$teachers[$object_mon->ma_giao_vien]:'';
          $subjectName = isset($subjects[$object_mon->ma_mon])?$subjects[$object_mon->ma_mon]:'';
          foreach ($object_mon->lich_hoc_du_kien as $chi_tiet_buoi_hoc) {
            
              if($chi_tiet_buoi_hoc->time>=$start&& $chi_tiet_buoi_hoc->time<=$end){
                $chi_tiet_buoi_hoc->teacher_name = $teacherName;
                $chi_tiet_buoi_hoc->subject_name = $subjectName;
                // $chi_tiet_buoi_hoc->date = $time;
                $array_new_teaching_history[]=$chi_tiet_buoi_hoc;
              }
            
          }
        }
      return view('pages.teaching_recording.view_report',[
        'data'=>$data,
        'student_name'=>$student_name,
        'start'=>$start,
        'end'=>$end,
        'month'=>$month,
        'id_nkgd'=>$id_nkgd,
        'amount_of_hours_last_package'=>$amount_of_hours_last_package,
        'array_new_teaching_history'=>$array_new_teaching_history,
        'time_left'=>$time_left
      ]);
    }
    public function export_report_teaching_recording($id_nkgd){
      $month = isset($_GET['month'])?$_GET['month']:null;
      $data  = M_teaching_recording::find($id_nkgd);
      $students = student::pluck('full_name','id_student');
      $teachers = teacher::pluck('fullname','id_teacher');
      $subjects = subject::pluck('name','id');
      $study_info = details_teaching_recording::getStudyInfo($id_nkgd);
       //Lấy giờ thực tế để so sánh với giờ fill ra vì thỉnh thoản có trường hợp bé HỌC TRƯỚC giờ ghi trong hóa đơn
      $giodahoc =  $study_info['study_hours'];
      $time_left =  $study_info['time_left'];
      // Lấy tên học sinh
      if($data->type==2){
        $json_id_students = json_decode($data->id_student);
        $student_name="";
        foreach ($json_id_students as  $value_id_student) {
          $student_name .= (isset($students[$value_id_student])?$students[$value_id_student]:'')."</br>";
        };
      }elseif($data->type==1){
        $student_name = isset($students[$data->id_student])?$students[$data->id_student]:'';
      }
      // Lấy gói giờ gần nhất
      $obj_renew_history = json_decode($data->renew_history);
      $amount_of_hours_last_package =  end($obj_renew_history)->so_gio;
      
      if($month!=null){
        //Báo cáo theo tháng
        $current_year = substr($month,0,4);
        $current_month = substr($month,5,7);
        $amount_of_months = date('t',strtotime('01-'.$current_month.'-'.$current_year));
        $start = strtotime($current_month."/01/".$current_year);
        $end = strtotime($current_month."/".$amount_of_months."/".$current_year);
      }else{
        //Lấy giờ bắt đầu và kết thúc nếu được set hoặc lấy của gói gần nhất
        $start = isset($_GET['start'])?$_GET['start']:strtotime(end($obj_renew_history)->ngay_bat_dau);;
        $end = isset($_GET['end'])?$_GET['end']:strtotime('Today');
      }


      // Lấy các buổi dựa vào $start và $end lưu vào mảng mới
      $obj_teaching_history = json_decode($data->teaching_history);
      $array_new_teaching_history=array();
      $array_temp=array();
      foreach ($obj_teaching_history as $object_mon) {
        $teacherName = isset($teachers[$object_mon->ma_giao_vien])?$teachers[$object_mon->ma_giao_vien]:'';
        $subjectName = isset($subjects[$object_mon->ma_mon])?$subjects[$object_mon->ma_mon]:'';
        foreach ($object_mon->lich_hoc_du_kien as $chi_tiet_buoi_hoc) {
          
            if($chi_tiet_buoi_hoc->time>=$start&& $chi_tiet_buoi_hoc->time<=$end){
              $chi_tiet_buoi_hoc->teacher_name = $teacherName;
              $chi_tiet_buoi_hoc->subject_name = $subjectName;
              // $chi_tiet_buoi_hoc->date = $time;
              $array_new_teaching_history[]=$chi_tiet_buoi_hoc;
            }
          
        }
      }
      $pdf = PDF::loadView('pages.teaching_recording.export_report',[
        'data'=>$data,
        'student_name'=>$student_name,
        'start'=>$start,
        'end'=>$end,
        'month'=>$month,
        'id_nkgd'=>$id_nkgd,
        'amount_of_hours_last_package'=>$amount_of_hours_last_package,
        'array_new_teaching_history'=>$array_new_teaching_history,
        'time_left'=>$time_left
      ])->setOptions(['defaultFont' => 'Roboto']);
      return $pdf->stream();
  }
}
