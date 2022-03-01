<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageTypePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_type_prices', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('active')->default(1)->comment('0->unactive and 1->Active');
            $table->double('price');
            $table->foreignId('package_id')->references('id')->on('packages')->onDelete('cascade');
            $table->foreignId('package_type_id')->references('id')->on('package_types')->onDelete('cascade');
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
        Schema::dropIfExists('package_type_prices');
    }
}
