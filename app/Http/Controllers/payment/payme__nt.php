<?php

namespace App\Http\Controllers\payment;

use Illuminate\Http\Request;

use App\Models\M_teaching_recording;

class payment extends Controller
{
    //
    function index(){
        $data_renew_history = M_teaching_recording::fill('id','renew_history');
        var_dump($data_renew_history);
    }
}
