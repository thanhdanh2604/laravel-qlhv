<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuanlyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quanly', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('username', 50);
            $table->string('password', 100);
            $table->date('birthday');
            $table->string('phone_number', 50);
            $table->integer('permission');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quanly');
    }
}
