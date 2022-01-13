<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class student extends Model
{
    function get_all_student(){
        $array = DB::table('student')->get();
        foreach ($array as $value) {
            var_dump($value);
        }
    }


}
