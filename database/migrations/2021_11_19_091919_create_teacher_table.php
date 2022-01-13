<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher', function (Blueprint $table) {
            $table->integer('id_teacher', true);
            $table->string('fullname', 500);
            $table->integer('rd_team')->default(0);
            $table->string('phone', 100);
            $table->string('email', 500);
            $table->text('username');
            $table->string('pass_prof', 500);
            $table->integer('hesoluong');
            $table->string('address', 200);
            $table->date('birthday');
            $table->integer('gender');
            $table->string('note');
            $table->string('link_cv', 200);
            $table->string('image', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher');
    }
}
