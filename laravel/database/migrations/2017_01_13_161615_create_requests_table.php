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
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('SET NULL');
            $table->integer('store_id')->unsigned()->nullable();
            $table->foreign('store_id')->references('id')->on('stores')->onUpdate('cascade')->onDelete('SET NULL');
            $table->integer('type_freight_id')->unsigned()->nullable();
            $table->foreign('type_freight_id')->references('id')->on('type_freights')->onUpdate('cascade')->onDelete('SET NULL');
            $table->integer('request_status_id')->unsigned();
            $table->foreign('request_status_id')->references('id')->on('request_statuses')->onUpdate('cascade');
            $table->string('key', 100)->unique();
            $table->integer('deadline')->unsigned();
            $table->string('tracking_code',15)->nullable();
            $table->decimal('freight_price',7,2)->default(0);
            $table->decimal('amount',7,2)->unsigned();
            $table->text('note')->nullable();
            $table->boolean('visualized_user')->default(0);
            $table->boolean('visualized_store')->default(0);
            $table->boolean('finalized')->default(0);
            $table->text('address_receiver');
            $table->text('address_sender');
            $table->string('phone', 15);
            $table->timestamp('settlement_date')->nullable();
            $table->timestamp('cancellation_date')->nullable();
            $table->timestamp('send_date')->nullable();
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
            $table->dropForeign(['type_freight_id']);
            $table->dropForeign(['store_id']);
            $table->dropForeign(['request_status_id']);
        });

        Schema::dropIfExists('requests');
    }
}
