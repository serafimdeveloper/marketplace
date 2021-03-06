<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConnectSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connect_sellers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('seller_id')->unsigned();
            $table->foreign('seller_id')->references('id')->on('sellers')->onUpdate('cascade')->onDelete('cascade');
            $table->string('accessToken', '40');
            $table->string('access_token', '40');
            $table->string('refreshToken', '40');
            $table->string('refresh_token', '40');
            $table->string('scope', '255')->nullable();
            $table->string('moipAccount_id', 17);
            $table->date('expires_in');
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
        Schema::table('connect_sellers', function(Blueprint $table){
            $table->dropForeign(['seller_id']);
        });
        Schema::dropIfExists('connect_sellers');
    }
}
