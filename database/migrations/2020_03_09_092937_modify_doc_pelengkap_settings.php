<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyDocPelengkapSettings extends Migration
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
            $table->string('user_id');
            $table->string('doc_pelengkap_id')->references('id')->on('mst_doc_pelengkaps'); // use this for field after specific column.
            $table->string('projects_id')->references('id')->on('mst_projects'); // use this for field after specific column. 
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
