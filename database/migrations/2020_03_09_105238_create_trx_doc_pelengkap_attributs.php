<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxDocPelengkapAttributs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_doc_pelengkap_attributs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('document_number')->references('number')->on('trx_document');
            $table->string('projects_id')->nullable()->references('id')->on('mst_projects');
            $table->string('attribut')->nullable();
            $table->string('label')->nullable();
            $table->string('value')->nullable();
            $table->string('remark')->nullable();
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
        Schema::dropIfExists('trx_doc_pelengkap_attributs');
    }
}
