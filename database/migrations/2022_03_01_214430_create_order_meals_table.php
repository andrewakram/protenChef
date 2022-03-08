<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderMealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_meals', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['pending','delivered'])->default('pending');
            $table->foreignId('order_id')->references('id')
                ->on('orders')->onDelete('cascade');
            $table->bigInteger('meal_id');
            $table->string('meal_title_ar');
            $table->string('meal_title_en');
            $table->text('meal_body_ar');
            $table->text('meal_body_en');
            $table->date('date');
            $table->date('old_date')->nullable();
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
        Schema::dropIfExists('order_meals');
    }
}
