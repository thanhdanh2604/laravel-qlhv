<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class teacher_payment extends Model
{
    use HasFactory;
    protected $table="teacher_payment";
    protected $primaryKey="id";
    public $timestamps = false;

}
