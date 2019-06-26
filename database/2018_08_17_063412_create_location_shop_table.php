<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationShopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_shop', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('location_id')->unsigned()->nullable();
            $table->integer('shop_id')->unsigned()->nullable();            
            $table->decimal('delivery_charge', 10, 2);
            $table->timestamps();
        });

        Schema::table('location_shop', function($table) {
            $table->foreign('location_id')->references('id')->on('locations');
            $table->foreign('shop_id')->references('id')->on('shops');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_shop');
    }
}
