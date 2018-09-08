<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_request', function (Blueprint $table) {
            $table->primary(['request_id', 'product_id']);
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');
            $table->integer('request_id')->unsigned();
            $table->foreign('request_id')->references('id')->on('requests')->onUpdate('cascade')->onDelete('cascade');
            $table->tinyInteger('quantity')->unsigned();
            $table->float('unit_price', 10, 2);
            $table->float('amount', 10, 2);
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
        Schema::table('product_request', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['request_id']);
        });
        Schema::dropIfExists('product_request');
    }
}
