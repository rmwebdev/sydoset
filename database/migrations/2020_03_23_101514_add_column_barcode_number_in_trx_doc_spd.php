<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnBarcodeNumberInTrxDocSpd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trx_documents_spd', function (Blueprint $table) {
            //
            $table->string('barcode_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trx_documents_spd', function (Blueprint $table) {
            //
            $table->dropColumn('barcode_number');
        });
    }
}
