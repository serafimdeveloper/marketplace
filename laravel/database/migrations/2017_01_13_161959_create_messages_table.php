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
            $table->enum('sender_type',['App\\\\Model\\\\User','App\\\\Model\\\\Store','App\\\\Model\\\\Admin']);
            $table->integer('recipient_id')->unsigned();
            $table->enum('recipient_type',['App\\\\Model\\\\User','App\\\\Model\\\\Store','App\\\\Model\\\\Admin']);
          //  $table->integer('message_type_id')->unsigned()->nullable();
          //  $table->foreign('message_type_id')->references('id')->on('message_types')->onUpdate('cascade')->onDelete('SET NULL');
            $table->integer('request_id')->unsigned()->nullable();
            $table->foreign('request_id')->references('id')->on('requests')->onUpdate('cascade')->onDelete('SET NULL');
            $table->integer('product_id')->unsigned()->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('message_id')->unsigned()->nullable();
            $table->foreign('message_id')->references('id')->on('messages')->onUpdate('cascade')->onDelete('cascade');
            $table->text('content');
            $table->boolean('desactive')->default(0);
            $table->enum('status',['readed','received', 'answered'])->default('received');
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
          //  $table->dropForeign(['message_type_id']);
            $table->dropForeign(['request_id']);
            $table->dropForeign(['product_id']);
            $table->dropForeign(['message_id']);

        });

        Schema::dropIfExists('messages');
    }
}
