<?php

namespace App\Http\Controllers\teaching_recording;
use App\Http\Controllers\Controller;

use App\Http\Controllers\teaching_recording\details_teaching_recording;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\M_teaching_recording;

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
        // $data =array();
        // $data_student = array();
        // $data_teacher = array();
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

        $data_study_info = details_teaching_recording::getStudyInfo($id);
        if($data_teaching_recording->teaching_history!=null){
            $data_teaching_history_sort = details_teaching_recording::sortTeachingHistory( $data_teaching_recording->teaching_history);
        }else{
            $data_teaching_history_sort = null;// Trường hợp chưa tạo lịch học
        }

        switch ($data_teaching_recording->type) {
            case 1:
                $data_student = DB::table('student')->where('id_student',$data_teaching_recording->id_student)->first();
                return view('pages.teaching_recording.detail-teaching_recording',[
                    'teaching_recording'=>$data_teaching_recording,
                    'obj_teaching_history'=>$data_teaching_history_sort,
                    'subjects'=>$data_subject,
                    'study_info'=>$data_study_info,
                    'teachers'=>$data_teacher,
                    'students'=>$data_student
                ]);
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
}
