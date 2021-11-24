<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\teaching_recording;
use App\Models\student;

class ban_tin extends Controller
{
    //
    public function show(){
        //Lấy data từ modal
        return student::all();

        //Gọi views
        return view('pages.vertical');
    }
}
