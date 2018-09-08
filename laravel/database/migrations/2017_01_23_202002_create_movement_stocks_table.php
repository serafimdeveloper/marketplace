<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovementStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movement_stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_movement_stock_id')->unsigned();
            $table->foreign('type_movement_stock_id')->references('id')->on('type_movement_stocks')->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');
            $table->tinyInteger('count');
            $table->string('reason',50)->nullable();
            $table->integer('request_id')->unsigned()->nullable();
            $table->foreign('request_id')->references('id')->on('requests')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::table('movement_stocks', function(Blueprint $table){
            $table->dropForeign(['product_id']);
            $table->dropForeign(['request_id']);
            $table->dropForeign(['type_movement_stock_id']);
        });
        Schema::dropIfExists('movement_stocks');
    }
}
