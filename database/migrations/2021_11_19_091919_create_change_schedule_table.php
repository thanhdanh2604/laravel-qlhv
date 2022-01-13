<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChangeScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('change_schedule', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_student');
            $table->integer('id_teacher');
            $table->integer('duyet');
            $table->string('noidung', 500);
            $table->integer('id_class');
            $table->integer('time');
            $table->date('old_date');
            $table->date('new_date');
            $table->date('off_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('change_schedule');
    }
}
