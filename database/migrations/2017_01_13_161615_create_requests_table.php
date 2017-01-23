<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('adress_id')->unsigned();
            $table->foreign('adress_id')->references('id')->on('adresses')->onUpdate('cascade');
            $table->integer('freight_id')->unsigned();
            $table->foreign('freight_id')->references('id')->on('freights')->onUpdate('cascade');
            $table->integer('payment_id')->unsigned();
            $table->foreign('payment_id')->references('id')->on('payments')->onUpdate('cascade')->onDelete('cascade');
            $table->date('settlement_date');
            $table->datetime('cancellation_date');
            $table->datetime('send_date');
            $table->tinyInteger('number_installments');
            $table->decimal('freight_amount',7,2);
            $table->decimal('amount',7,2);
            $table->string('payment_reference',50);
            $table->text('note');
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
        Schema::table('requests', function(Blueprint $table){
            $table->dropForeign(['user_id']);
            $table->dropForeign(['payment_id']);
        });

        Schema::dropIfExists('requests');
    }
}
