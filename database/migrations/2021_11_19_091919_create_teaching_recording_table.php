<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachingRecordingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teaching_recording', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('name');
            $table->integer('type');
            $table->text('ma_lop');
            $table->text('lich_hoc');
            $table->float('total_hours', 10, 0)->default(0);
            $table->text('id_student');
            $table->longText('teaching_history');
            $table->integer('finish')->default(1);
            $table->text('edit_history');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teaching_recording');
    }
}
