<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\C_subject;

use Illuminate\Http\Request;

use App\Models\subject;

class C_subject extends Controller
{
    //
    function get_all_subjects(){
        $data_all_subject = subject::all()->sortByDesc('id');
        return view('pages.subject.subjects',[
            'subjects'=>$data_all_subject
        ]
        );
    }
    function update_subject(Request $request){
      $id_subject = $request->input('id_subject');
      $field = $request->input('field');
      $value = $request->input('value');

      $data_subject = subject::find($id_subject);
      $data_subject->$field = $value;
      $data_subject->save();
      return response()->json([
        'status' => 'success'
      ]);
    }
    function create_subject(Request $request){
      $subject_name= $request->input('subject_name');
      $subject_note = $request->input('note');
      // subject::create([
      //   'name' => $subject_name,
      //   'des' =>  $subject_note
      // ]);
      subject::updateOrCreate(
        [
            'name' => $subject_name
        ],
        [
            'des' => $subject_note
        ]
        );
      return response()->json([
        'status' => 'success'
      ]);
    }
    function delete_subjects(Request $request){
      $id_subject = $request->input('id_subject');
      subject::find($id_subject)->delete();
      return response()->json([
        'status' => 'success'
      ]);
    }
}
