<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectRowTeacher extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

            Schema::create('teacher', function (Blueprint $table) {
                $table->string('teaching_subject');
            });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

            Schema::create('teacher', function (Blueprint $table) {
                $table->dropColumn('teaching_subject');
            });

    }
}
