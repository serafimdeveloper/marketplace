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
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('NO ACTION');
            $table->integer('adress_id')->unsigned();
            $table->foreign('adress_id')->references('id')->on('adresses')->onUpdate('cascade');
            $table->integer('store_id')->unsigned();
            $table->foreign('store_id')->references('id')->on('stores')->onUpdate('cascade')->onDelete('NO ACTION');
            $table->integer('freight_id')->unsigned()->nullable();
            $table->foreign('freight_id')->references('id')->on('freights')->onUpdate('cascade')->onDelete('SET NULL');
            $table->integer('payment_id')->unsigned()->nullable();
            $table->foreign('payment_id')->references('id')->on('payments')->onUpdate('cascade')->onDelete('SET NULL');
            $table->integer('request_status_id')->unsigned();
            $table->foreign('request_status_id')->references('id')->on('request_status')->onUpdate('cascade');
            $table->date('settlement_date')->nullable();
            $table->datetime('cancellation_date')->nullable();
            $table->datetime('send_date')->nullable();
            $table->tinyInteger('number_installments')->nullable()->default(1);
            $table->string('tracking_code',15)->nullable();
            $table->decimal('freight_price',7,2);
            $table->decimal('amount',7,2);
            $table->string('payment_reference',50)->nullable();
            $table->text('note')->nullable();
            $table->boolean('closed')->nullable();
            $table->softDeletes();
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
            $table->dropForeign(['freight_id']);
            $table->dropForeign(['adress_id']);
            $table->dropForeign(['store_id']);
            $table->dropForeign(['request_status_id']);
        });

        Schema::dropIfExists('requests');
    }
}
