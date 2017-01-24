<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sender_id')->unsigned();
            $table->foreign('sender_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('recipient_id')->unsigned();
            $table->foreign('recipient_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('message_type_id')->unsigned()->nullable();
            $table->foreign('message_type_id')->references('id')->on('message_types')->onUpdate('cascade')->onDelete('SET NULL');
            $table->integer('request_id')->unsigned()->nullable();
            $table->foreign('request_id')->references('id')->on('requests')->onUpdate('cascade')->onDelete('SET NULL');
            $table->integer('product_id')->unsigned()->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('SET NULL');
            $table->integer('message_id')->unsigned()->nullable();
            $table->foreign('message_id')->references('id')->on('messages')->onUpdate('cascade')->onDelete('SET NULL');
            $table->string('title',200);
            $table->text('content');
            $table->enum('status',['read','received']);
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
        Schema::table('messages', function(Blueprint $table){
            $table->dropForeign(['sender_id']);
            $table->dropForeign(['recipient_id']);
            $table->dropForeign(['message_type_id']);
            $table->dropForeign(['request_id']);
            $table->dropForeign(['product_id']);
        });

        Schema::dropIfExists('messages');
    }
}
