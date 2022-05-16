<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class calendar extends Controller
{
    //
    public function index(){
        return view('pages.calendar.calendar');
    }
}
