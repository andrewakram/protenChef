<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageMealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_meals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meal_id')->references('id')->on('meals')->onDelete('cascade');
            $table->foreignId('package_id')->references('id')->on('packages')->onDelete('cascade');
            $table->string('day');
            $table->string('week');

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
        Schema::dropIfExists('package_meals');
    }
}
