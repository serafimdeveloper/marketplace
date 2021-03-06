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
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('NO ACTION');
            $table->integer('store_id')->unsigned();
            $table->foreign('store_id')->references('id')->on('stores')->onUpdate('cascade')->onDelete('NO ACTION');
            $table->integer('request_id')->unsigned();
            $table->foreign('request_id')->references('id')->on('requests')->onUpdate('cascade')->onDelete('NO ACTION');
            $table->tinyInteger('note_store');
            $table->tinyInteger('note_attendance');
            $table->tinyInteger('note_products');
            $table->string('return_reason')->nullable();
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
