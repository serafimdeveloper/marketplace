<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('request_id')->unsigned();
            $table->foreign('request_id')->references('id')->on('requests')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('type_payment_id')->unsigned();
            $table->foreign('type_payment_id')->references('id')->on('type_payments')->onUpdate('cascade')->onDelete('cascade');
            $table->tinyInteger('number_installments')->unsigned()->default(1);
            $table->decimal('commission_amount',7,2)->unsigned();
            $table->decimal('rate_moip',5,2)->unsigned();
            $table->string('payment_reference', 100);
            $table->string('payment_institution', 100);
            $table->string('status', 50);
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
        Schema::table('payments', function(Blueprint $table){
            $table->dropForeign(['request_id']);
        });

        Schema::dropIfExists('payments');
    }
}
