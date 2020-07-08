<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyTrxDocPelengkaps2 extends Migration
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
            $table->string('doc_pelengkap_id')->after('id')->references('id')->on('mst_doc_pelengkaps'); // use this for field after specific column.
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
            $table->dropColumn('doc_pelengkap_name');
        });
    }
}
