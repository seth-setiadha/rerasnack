<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('item_id')->constrained();            
            $table->string('item_name');
            $table->unsignedInteger('qty');        // per gram
            $table->unsignedDecimal('bal_kg', 8,2); // DATA FROM MASTER ITEM KG /BAL
            $table->unsignedDecimal('modal', 10,4);     // modal per gram (rupiah) = harga beli / qty beli dlm gram
            $table->timestamps();
            $table->index(['tanggal', 'item_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
}
