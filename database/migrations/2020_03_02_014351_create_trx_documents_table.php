<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number')->index()->nullable();
            $table->string('type_id')->nullable()->references('id')->on('mst_document_types');
            $table->string('customer')->nullable();
            $table->string('unit')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->text('order_number')->nullable();
            $table->string('route_name')->nullable();
            $table->string('driver_id')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('secondary_driver_name')->nullable();
            $table->string('secondary_driver_id')->nullable();
            $table->text('ccms_number')->nullable();
            $table->timestamp('tender_time')->nullable();
            $table->string('approved_add_cost_status')->nullable();
            $table->string('prepayment_status')->nullable();
            $table->timestamp('prepayment_date')->nullable();
            $table->string('barcode_number')->nullable();
            $table->boolean('is_complete')->nullable();
            $table->string('last_status')->nullable();
            $table->string('openget')->nullable();
            $table->boolean('is_reject')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('messenger_id')->nullable()->references('id')->on('messengers');
            $table->string('kode_arsip')->nullable();
            $table->string('user_pengarsip')->nullable();
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
        Schema::dropIfExists('trx_documents');
    }
}
