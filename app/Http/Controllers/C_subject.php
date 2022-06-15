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
        $data_all_subject = subject::all();
        return view('pages.subject.subjects',[
            'subjects'=>$data_all_subject
        ]
        );
    }
}
