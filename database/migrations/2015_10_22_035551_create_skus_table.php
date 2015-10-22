<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skus', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('division_id')->unsigned();
            $table->foreign('division_id')->references('id')->on('divisions');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->integer('sub_category_id')->unsigned();
            $table->foreign('sub_category_id')->references('id')->on('sub_categories');
            $table->integer('brand_id')->unsigned();
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->string('sku_code');
            $table->string('item_desc');
            $table->string('sku_desc');
            $table->integer('conversion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('skus');
    }
}
