<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxDocPelengkapsSpd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_doc_pelengkaps_spd', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('trx_documents_spd_number')->references('number')->on('trx_documents_spd');
            $table->string('container')->nullable();
            $table->string('fleet')->nullable();
            $table->string('type')->nullable();
            $table->string('container_pengganti')->nullable();
            $table->string('nilai_kuitansi')->nullable();
            $table->boolean('is_available')->nullable();
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
        Schema::dropIfExists('trx_doc_pelengkaps_spd');
    }
}
