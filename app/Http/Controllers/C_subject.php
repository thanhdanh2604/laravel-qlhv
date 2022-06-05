<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\subject;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\subject;

class C_subject extends Controller
{
    //
    function get_all_subjects(){
        $data_all_subject = subject::all();
        return view('pages.subjects',[
            'subjects'=>$data_all_subject
        ]
        );
    }
}
