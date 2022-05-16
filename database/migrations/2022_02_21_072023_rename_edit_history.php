<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameEditHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::table('teaching_recording', function(Blueprint $table) {
            $table->renameColumn('edit_history', 'renew_history');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('teaching_recording', function(Blueprint $table) {
            $table->renameColumn('renew_history', 'edit_history');
        });
    }
}
