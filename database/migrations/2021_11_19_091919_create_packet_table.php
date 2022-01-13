<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packet', function (Blueprint $table) {
            $table->integer('id_packet', true);
            $table->string('name_packet', 50);
            $table->integer('id_subject');
            $table->integer('id_teacher');
            $table->integer('packet_time');
            $table->integer('bonus_time');
            $table->integer('price');
            $table->mediumText('note');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packet');
    }
}
