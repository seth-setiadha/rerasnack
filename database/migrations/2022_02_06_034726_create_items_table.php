<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();

            $table->string('item_code', 10)->unique();
            $table->string('item_name', 50);
            $table->string('item_description')->nullable();
            $table->string('item_image')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->unsignedDecimal('bal_kg', 8,2);
            $table->unsignedMediumInteger('bal_gr');

            $table->enum('active', ['Y', 'N'])->default('Y'); 
            
            $table->timestamps();
            $table->softDeletes();

            $table->index(['item_code', 'item_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
