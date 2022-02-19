<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportPenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_penjualans', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('modal_id');
            $table->date('tanggal');
            $table->string('item_code', 10);
            $table->string('item_name', 50);
            $table->string('unit', 10);
            
            $table->unsignedMediumInteger('unit_price');
            $table->unsignedSmallInteger('qty');
            $table->unsignedInteger('sub_total');

            $table->unsignedInteger('stock_id');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['tanggal', 'item_code', 'item_name', 'stock_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_penjualans');
    }
}
