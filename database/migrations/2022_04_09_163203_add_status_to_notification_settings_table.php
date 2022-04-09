<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToNotificationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notification_settings', function (Blueprint $table) {
            $table->tinyInteger('status')->default(0)->after('type')
                ->comment('1=>order, 2=>order_status, 3=>meal_status, 4=>cancel_order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notification_settings', function (Blueprint $table) {
            //
        });
    }
}
