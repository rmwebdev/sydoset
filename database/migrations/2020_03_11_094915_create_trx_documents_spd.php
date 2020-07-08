<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxDocumentsSpd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_documents_spd', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number')->nullable();
            $table->string('customer')->nullable();
            $table->text('order_number')->nullable();
            $table->text('ccms_number')->nullable();
            $table->string('driver_id')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('depo_id')->nullable();
            $table->string('status_erp')->nullable();
            $table->string('status_spd')->nullable();
            $table->string('amount')->nullable();
            $table->boolean('is_bundle')->nullable();
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
        Schema::dropIfExists('trx_documents_spd');
    }
}
