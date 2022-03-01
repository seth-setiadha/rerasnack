<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportRerasnacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_rerasnacks', function (Blueprint $table) {
            $table->id();
            $table->string('item_code', 10)->nullable();
            $table->string('item_name', 50)->nullable();
            $table->unsignedDecimal('bal_kg', 8,2)->nullable();
            $table->unsignedMediumInteger('unit_price')->nullable();
            $table->unsignedMediumInteger('qty')->nullable();
            $table->unsignedInteger('sub_total')->nullable();

            $table->unsignedMediumInteger('qty_bal')->nullable();
            $table->unsignedMediumInteger('qty_1kg')->nullable();
            $table->unsignedMediumInteger('qty_500gr')->nullable();
            $table->unsignedMediumInteger('qty_300gr')->nullable();
            $table->unsignedMediumInteger('qty_250gr')->nullable();
            $table->unsignedMediumInteger('qty_200gr')->nullable();
            $table->unsignedMediumInteger('qty_150gr')->nullable();
            $table->unsignedMediumInteger('qty_100gr')->nullable();
            $table->unsignedMediumInteger('qty_total')->nullable();

            $table->integer('profit_bal')->nullable();
            $table->integer('profit_1kg')->nullable();
            $table->integer('profit_500gr')->nullable();
            $table->integer('profit_300gr')->nullable();
            $table->integer('profit_250gr')->nullable();
            $table->integer('profit_200gr')->nullable();
            $table->integer('profit_150gr')->nullable();
            $table->integer('profit_100gr')->nullable();
            $table->integer('profit_total')->nullable();

            $table->unsignedInteger('omset_bal')->nullable();
            $table->unsignedInteger('omset_1kg')->nullable();
            $table->unsignedInteger('omset_500gr')->nullable();
            $table->unsignedInteger('omset_300gr')->nullable();
            $table->unsignedInteger('omset_250gr')->nullable();
            $table->unsignedInteger('omset_200gr')->nullable();
            $table->unsignedInteger('omset_150gr')->nullable();
            $table->unsignedInteger('omset_100gr')->nullable();
            $table->unsignedInteger('omset_total')->nullable();

            $table->unsignedMediumInteger('sisa')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['item_code', 'item_name', 'stock_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_rerasnacks');
    }
}
