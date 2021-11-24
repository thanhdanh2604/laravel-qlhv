<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_payment', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_teacher');
            $table->text('date_checked');
            $table->text('luong_cua_thang');
            $table->integer('so_tien');
            $table->integer('he_so_luong');
            $table->integer('so_gio');
            $table->float('chuyen_tien', 10, 0)->default(0);
            $table->text('ngay_gio_chuyen');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher_payment');
    }
}
