<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class teacher extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data_teacher = DB::table('teacher')->orderBy('id_teacher', 'desc')->get();
        $data_subject = DB::table('subject')->orderBy('id','desc')->get();
        return view('pages.teacher.teachers',['teachers'=>$data_teacher,'subjects'=>$data_subject]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate input data
        $validate = $request->validate([
            'fullname'=> ['required','max:255'],
            'phone'=>['unique:teacher']
        ]);
        //Create Teacher
        $name = $request->input('fullname');
        $id_class = $request->input('ma_lop');
        $email= $request->input('email');
        $phone = $request->input('mobileno');
        $birthday = $request->input('birthday');
        $gender = $request->input('gender');
        $note = $request->input('noteprof');
        $array_subject = json_encode($request->input('teaching_subjects'));

        DB::table('teacher')->insert([
           'fullname' => $name,
           'email' => $email,
           'birthday'=>$birthday,
           'phone'=>$phone,
           'username'=>$email,
           'pass_prof'=>$phone,
           'hesoluong'=>0,
           'address'=>'',
           'gender'=> $gender,
           'note'=>$note,
           'teaching_subject'=>$array_subject
        ]);

        return redirect()->action([teacher::class, 'index']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Show deatail infomation of Teacher
        $data_teacher = DB::table('teacher')->where('id_teacher',$id)->first();
        $data_subject = DB::table('subject')->orderBy('id','desc')->get();
        return view('pages.teacher.edit-teacher',['teacher'=>$data_teacher,'subjects'=>$data_subject]);
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
        DB::table('teacher')->where('id_teacher', $id)
                    ->update([$column=>$data_column]);
        return redirect()->route('teacher_detail',['id' => $id]);
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
        $name = $request->input('fullname');
        $address = $request->input('address');
        $email= $request->input('email');
        $phone = $request->input('mobileno');
        $birthday = $request->input('birthday');
        $gender = $request->input('gender');
        $note = $request->input('noteprof');
        $hesoluong = $request->input('hesoluong');
        if ($request->input('rd_team')==null)
        {
            $rd_team = 0;
        }else{
            $rd_team =  1;
        };
        $json_subjects = json_encode($request->input('teaching_subjects'));

        //update infomation of Teacher
        $affected = DB::table('teacher')
              ->where('id_teacher', $id)
              ->update([
                  'fullname' => $name,
                  'address' => $address,
                  'email' => $email,
                  'phone' => $phone,
                  'birthday' => $birthday,
                  'gender' => $gender,
                  'note' => $note,
                  'hesoluong' => $hesoluong,
                  'teaching_subject' => $json_subjects,
                  'rd_team'=>$rd_team
                ]);
        return redirect()->route('teacher_detail',['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_teacher)
    {
        //Delete record on table
        DB::table('teacher')->where('id_teacher', '=', $id_teacher)->delete();
        return redirect()->route('teachers');
    }
    public function json_get_currect_subject_teacher($id_teacher){
        $json_teaching_subjects = DB::table('teacher')->where('id_teacher', '=', $id_teacher)->first('teaching_subject');
        $data_subjects = DB::table('subject')->pluck('name','id');
        $array_final= array();
        foreach (json_decode($json_teaching_subjects->teaching_subject) as $id_teaching_subject) {
            $array_temp=array();
            $array_temp['name']=$data_subjects[$id_teaching_subject];
            $array_temp['id']=$id_teaching_subject;
            $array_final[] = $array_temp;
        }
        echo json_encode($array_final);
    }
    // Phần dưới dùng để chuyển bản 'packet' qua cột 'Teaching_subject' trên bản teacher, dùng cho việc chuyển dữ liệu qua phiên bản laravel mới không có nhu cầu sử dụng có thể xóa
    public function packet_hour_to_subjects(){
        $data_teacher = DB::table('teacher')->get();
        foreach($data_teacher as $value){
            $array_temp = array();
            // Lấy packet where id_teacher bằng id_teacher trên vòng lặp
            $data_subject_teacher = DB::table('packet')->where('id_teacher','=',$value->id_teacher)->get(['id_subject','id_teacher']);
            // Thêm vào mảng rỗng đã tạo
            foreach ($data_subject_teacher as $value_subject) {
                $array_temp[]=$value_subject->id_subject;
            }
            $json_temp = json_encode($array_temp);
            // Export ra json và lưu vào database
            DB::table('teacher')->where('id_teacher','=',$value->id_teacher)->update([
                'teaching_subject'=>$json_temp
            ]);

        }
    }
}
