<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_num')->unique();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->bigInteger('package_id');
            $table->string('package_name_ar');
            $table->string('package_name_en');
            $table->bigInteger('package_type_id');
            $table->string('package_type_ar');
            $table->string('package_type_en');
            $table->string('lat');
            $table->string('lng');
            $table->string('location_body');
            $table->date('start_date');
            $table->double('package_price')->default(0);
            $table->double('shipping_price')->default(0);
            $table->double('discount_price')->default(0);
            $table->double('total_price')->default(0);
            $table->enum('status', ['pending', 'accepted', 'canceled', 'finished'])->default('pending');
            $table->double('cancel_price')->nullable();
            $table->date('cancel_date')->nullable();


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
        Schema::dropIfExists('orders');
    }
}
