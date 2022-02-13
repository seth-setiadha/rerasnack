<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('item_id')->constrained();            

            $table->date('tanggal');
            $table->unsignedSmallInteger('qty');
            $table->string('unit', 10);

            $table->unsignedDecimal('qty_kg', 8,2); // STOCK IN/OUT PER KG, DPT DARI QTY * BAL_KG
            $table->unsignedDecimal('qty_gr', 8,2); // AUTO DARI BAL_KG * QTY * 1000

            $table->foreignId('stock_id')->constrained();   // KL [IN] berarti stock masuk  disimpan, kl [OUT] berarti stock keluar ambil dr record ini
            
            $table->unsignedMediumInteger('unit_price');    //
            $table->unsignedMediumInteger('unit_price_gr'); // unit price modal untuk [IN] , unit price jual untuk [OUT]
            $table->unsignedInteger('sub_total');
            $table->enum('stock', ['IN', 'OUT', 'ADJ']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventories');
    }
}
