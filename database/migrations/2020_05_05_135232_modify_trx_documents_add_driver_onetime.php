<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyTrxDocumentsAddDriverOnetime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('trx_documents', function (Blueprint $table) {
            $table->string('others_msg_name')->nullable();
            $table->string('others_msg_hp')->nullable();
        });
        Schema::table('trx_documents_spd', function (Blueprint $table) {
            $table->string('others_msg_name')->nullable();
            $table->string('others_msg_hp')->nullable();
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
