<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageMealTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_meal_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_type_price_id')->references('id')->on('package_type_prices')->onDelete('cascade');
            $table->foreignId('meal_type_id')->references('id')->on('meal_types')->onDelete('cascade');
            $table->double('price')->nullable();

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
        Schema::dropIfExists('package_meal_types');
    }
}
