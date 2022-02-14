<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportModalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_modals', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('modal_id');
            $table->date('tanggal');
            $table->string('item_code', 10);
            $table->string('item_name', 50);
            $table->unsignedDecimal('qty_kg', 8,2);
            $table->unsignedMediumInteger('unit_price');
            $table->unsignedMediumInteger('qty');
            $table->unsignedInteger('sub_total');

            $table->unsignedInteger('stock_id');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_modals');
    }
}
