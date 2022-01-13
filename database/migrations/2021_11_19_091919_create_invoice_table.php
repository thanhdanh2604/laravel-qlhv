<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('code_bill');
            $table->integer('type')->nullable()->default(1)->comment('Type 1: chi phí vận hành, văn phòng, Type 2: Reinvest');
            $table->date('date');
            $table->text('info');
            $table->integer('vat');
            $table->integer('bill');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice');
    }
}
