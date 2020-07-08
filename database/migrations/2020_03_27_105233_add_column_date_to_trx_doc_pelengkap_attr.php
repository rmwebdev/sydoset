<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDateToTrxDocPelengkapAttr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trx_doc_pelengkap_attributs', function (Blueprint $table) {
            //
            $table->date('date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trx_doc_pelengkap_attributs', function (Blueprint $table) {
            //
            $table->dropColumn('date');
        });
    }
}
