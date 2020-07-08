<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTglArsipSerahTerima extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('trx_documents_spd', function (Blueprint $table) {
            $table->date('tgl_arsip')->nullable();
            $table->date('tgl_serah_terima')->nullable();
        });
        Schema::table('trx_documents', function (Blueprint $table) {
            $table->date('tgl_arsip')->nullable();
            $table->date('tgl_serah_terima')->nullable();
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
    }
}
