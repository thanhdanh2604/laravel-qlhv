<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class student extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data_student = DB::table('student')->orderBy('id_student', 'desc')->get();

        return view('pages.student.students',['students'=>$data_student]);
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
        //Validate input data
        $validate = $request->validate([
            'name'=> ['required','max:255'],
            'phone'=>['unique:student']
        ]);
        //Create student
        $name = $request->input('name');
        $id_class = $request->input('ma_lop');
        $skype = $request->input('skype');
        $address = $request->input('address');
        $email= $request->input('emailstudent');
        $phone = $request->input('mobileno');
        $birthday = $request->input('birthday');
        $parent_name = $request->input('parentname');
        $parent_number = $request->input('numparrent');
        $emailparent = $request->input('emailparent');
        $gender = $request->input('gender');
        $note = $request->input('notestudent');

        DB::table('student')->insert([
           'full_name' => $name,
           'id_class'=>$id_class,
           'skype'=>$skype,
           'email' => $email,
           'birthday'=>$birthday,
           'phone'=>$phone,
           'username'=>$email,
           'address'=>$address,
           'gender'=> $gender,
           'note'=>$note,
           'parent_name'=> $parent_name,
           'parent_phone'=> $parent_number,
           'parent_email'=>$emailparent
        ]);
        return redirect()->action([student::class, 'index']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

         //Show deatail infomation of student
         $data_student = DB::table('student')->where('id_student',$id)->first();
         $data_subject = DB::table('subject')->orderBy('id','desc')->get();
         return view('pages.student.edit-student',['student'=>$data_student,'subjects'=>$data_subject]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Xử lý cập nhập trường nhất định trong table
        $data_column = $request->input($column);
        DB::table('student')->where('id_student', $id)
                    ->update([$column=>$data_column]);
        return redirect()->route('student_detail',['id' => $id]);
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
        //Validate input data
        $validate = $request->validate([
            'name'=> ['required','max:255'],
            'phone'=>['unique:student']
        ]);
        //Create student
        $name = $request->input('name');
        $id_class = $request->input('ma_lop');
        $skype = $request->input('skype');
        $address = $request->input('address');
        $email= $request->input('emailstudent');
        $phone = $request->input('mobileno');
        $birthday = $request->input('birthday');
        $parent_name = $request->input('parentname');
        $parent_number = $request->input('numparrent');
        $emailparent = $request->input('emailparent');
        $gender = $request->input('gender');
        $note = $request->input('notestudent');

        DB::table('student')->where('id_student', $id)->update([
           'full_name' => $name,
           'id_class'=>$id_class,
           'skype'=>$skype,
           'email' => $email,
           'birthday'=>$birthday,
           'phone'=>$phone,
           'username'=>$email,
           'address'=>$address,
           'gender'=> $gender,
           'note'=>$note,
           'parent_name'=> $parent_name,
           'parent_phone'=> $parent_number,
           'parent_email'=>$emailparent
        ]);
        return redirect()->route('student_detail',['id' => $id]);

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
        DB::table('student')->where('id_student', '=', $id)->delete();
        return redirect()->route('students');
    }
    public function select_column_student($id_student,$column){
        $id_student = DB::table('student')->where('id_student', '=', $id_student)->get('id_class');
        echo $id_student[0]->id_class;
    }
}
