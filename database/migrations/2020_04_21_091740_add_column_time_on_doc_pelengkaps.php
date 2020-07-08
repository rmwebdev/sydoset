<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTimeOnDocPelengkaps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('trx_doc_pelengkaps', function (Blueprint $table) {
            $table->time('jam')->nullable();
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
        Schema::table('trx_doc_pelengkaps', function (Blueprint $table) {
            //
            $table->dropColumn('jam');
        });
    }
}
