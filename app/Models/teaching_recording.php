<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class teaching_recording extends Model
{
    use HasFactory;
    protected $table = 'teaching_recording';
    protected $timestamps = false;
    protected $primaryKey = 'id';
}
