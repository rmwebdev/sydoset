<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyDocPelengkapSettingsMappingMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('doc_pelengkap_settings', function (Blueprint $table) {
            $table->string('mst_customer_id')->references('id')->on('mst_customers')->nullable(); // use this for field after specific column.
            $table->string('document_type_id')->references('id')->on('mst_document_types')->nullable(); // use this for field after specific column. 
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
