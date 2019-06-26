<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->string('product_category');            
            $table->string('product_name');
            $table->decimal('product_price', 10, 2);
            $table->string('product_image');
            $table->string('product_width');   
            $table->string('product_height');
            $table->mediumText('product_description');
            $table->string('product_shop_phone');
            $table->timestamps();
        });

        Schema::table('order_items', function($table) {
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
