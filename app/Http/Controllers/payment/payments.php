<?php

namespace App\Http\Controllers\payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\M_teaching_recording;


class payments extends Controller
{
    //
    function index(){
        $data_renew_history = M_teaching_recording::all('id', 'renew_history');

    }
}
