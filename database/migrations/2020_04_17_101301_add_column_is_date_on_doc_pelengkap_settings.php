<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIsDateOnDocPelengkapSettings extends Migration
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
            $table->boolean('is_date_value')->default(false);
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
        Schema::table('doc_pelengkap_settings', function (Blueprint $table) {
            //
            $table->dropColumn('is_delete');
        });
    }
}
