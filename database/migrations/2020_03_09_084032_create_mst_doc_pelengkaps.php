<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstDocPelengkaps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_doc_pelengkaps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
        Schema::table('trx_doc_pelengkaps', function (Blueprint $table) {
            $table->string('doc_pelengkap_name')->after('id')->references('name')->on('mst_doc_pelengkaps'); // use this for field after specific column.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_doc_pelengkaps');
        Schema::table('trx_doc_pelengkaps', function (Blueprint $table) {
            $table->dropColumn('projects_id');
        });
    }
}
