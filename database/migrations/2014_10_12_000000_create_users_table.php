<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email', 255)->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('image')->nullable();
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->integer('age')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('height')->nullable();
            $table->string('fcm_token')->nullable();
            $table->tinyInteger('active')->default(0)->comment('0->unactive and 1->Active');
            $table->tinyInteger('suspend')->default(0)->comment('0->unsuspended and 1->suspended');

            $table->enum('provider', ['google', 'facebook', 'other','apple'])->default('other');
            $table->longText('social_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
