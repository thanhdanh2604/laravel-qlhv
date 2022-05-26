<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_teaching_recording;
use App\Models\student;
use App\Models\teacher;
use App\Models\subject;

class calendar extends Controller
{
    //
    public function index(){

        return view('pages.calendar.calendar');
    }

}
