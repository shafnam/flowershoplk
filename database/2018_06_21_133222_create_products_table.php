<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_category_id')->unsigned();
            $table->integer('shop_id')->unsigned();
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->string('width');
            $table->string('height');
            $table->mediumText('description');
            $table->tinyInteger('status');
            $table->tinyInteger('featured');
            $table->timestamps();
        });

        Schema::table('products', function($table) {
            $table->foreign('product_category_id')->references('id')->on('product_categories');
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
        Schema::dropIfExists('products');
    }
}
