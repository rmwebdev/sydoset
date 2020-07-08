<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxDocPelengkapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_doc_pelengkaps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('document_number')->references('number')->on('trx_document');
            $table->string('type_id')->references('id')->on('mst_document_types');
            $table->string('tanggal_dokumen');
            $table->string('nilai')->nullable();
            $table->string('remark')->nullable();
            $table->boolean('is_exist');
            $table->boolean('is_delete');
            $table->string('user_id');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_doc_pelengkaps');
    }
}
