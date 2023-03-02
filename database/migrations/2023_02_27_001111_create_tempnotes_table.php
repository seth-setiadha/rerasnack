<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempnotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tempnotes', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('item_id')->constrained();
            $table->string('harga', 100)->nullable();
            $table->string('note', 200)->nullable();
            $table->boolean('saved')->default(false);

            $table->unsignedBigInteger('inventory_id')->nullable();

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
        Schema::dropIfExists('tempnotes');
    }
}
