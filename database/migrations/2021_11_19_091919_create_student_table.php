<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student', function (Blueprint $table) {
            $table->integer('id_student', true);
            $table->string('id_class', 200);
            $table->string('full_name', 500);
            $table->string('avatar', 200);
            $table->text('skype');
            $table->string('address', 500);
            $table->integer('gender');
            $table->date('birthday');
            $table->string('phone', 200);
            $table->string('email', 200)->nullable();
            $table->text('username');
            $table->string('pass_student', 500);
            $table->string('parent_name', 500);
            $table->string('parent_phone', 200)->nullable();
            $table->string('parent_email', 200);
            $table->string('note', 500);
            $table->string('pack_of_hour', 10);
            $table->string('time_left', 2000)->default('0');
            $table->string('lichhoc', 500);
            $table->longText('buy_history');
            $table->integer('reserve')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student');
    }
}
