<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyTrxDocPelengkapsRev extends Migration
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
            $table->string('projects_id')->after('type_id')->references('id')->on('mst_projects'); // use this for field after specific column.
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
        Schema::table('mst_projects', function (Blueprint $table) {
            $table->dropColumn('projects_id');
        });
    }
}
