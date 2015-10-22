<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreSkusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_sku', function(Blueprint $table) {
            $table->integer('store_id')->unsigned();
            $table->foreign('store_id')->references('id')->on('stores');
            $table->integer('sku_id')->unsigned();
            $table->foreign('sku_id')->references('id')->on('skus');
            $table->integer('ig');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('store_sku');
    }
}
