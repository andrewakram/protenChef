<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderAdditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_additions', function (Blueprint $table) {
            $table->id();
            $table->double('price')->nullable();
            $table->foreignId('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreignId('meal_type_id')->references('id')->on('meal_types')->onDelete('cascade');

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
        Schema::dropIfExists('order_additions');
    }
}
