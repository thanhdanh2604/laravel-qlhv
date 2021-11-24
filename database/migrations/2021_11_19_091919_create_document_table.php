<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document', function (Blueprint $table) {
            $table->integer('id_document', true);
            $table->text('name');
            $table->integer('id_folder');
            $table->integer('id_topic');
            $table->text('link_view');
            $table->integer('status')->default(1);
            $table->integer('type_of_file')->default(0)->comment('Định dạng file, bài tập hay là tài liệu');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document');
    }
}
