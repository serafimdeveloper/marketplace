<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopValuationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_valuations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('store_id')->unsigned();
            $table->integer('request_id')->unsigned();
            $table->tinyInteger('note_store');
            $table->tinyInteger('note_term');
            $table->tinyInteger('note_service');
            $table->string('comment');
            $table->boolean('active')->default(1);
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
        Schema::table('shop_valuations', function(Blueprint $table){
            $table->dropForeign(['user_id']);
            $table->dropForeign(['store_id']);
            $table->dropForeign(['request_id']);
        });
        Schema::dropIfExists('shop_valuations');
    }
}
