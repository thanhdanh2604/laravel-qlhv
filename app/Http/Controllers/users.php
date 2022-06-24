<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class users extends Controller
{
    //
    function index(){
      $data_user = User::all();
      return view('pages.user.users',['data_users'=>$data_user]);
    }
}
