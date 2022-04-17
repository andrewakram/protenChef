<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDynamictypeDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dynamictype_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dynamic_type_id')->references('id')->on('dynamic_types')->onDelete('cascade');
            $table->foreignId('day_id')->references('id')->on('days')->onDelete('restrict');
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
        Schema::dropIfExists('dynamictype_days');
    }
}
