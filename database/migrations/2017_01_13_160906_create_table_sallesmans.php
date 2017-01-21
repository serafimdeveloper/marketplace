<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSallesmans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sallesmans', function(Blueprint $table){
            $table->increments('id');
            $table->string('moip',50);
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('cpf',15);
            $table->string('facebook',200)->nullable();
            $table->string('whatsapp',15)->nullable();
            $table->string('cellphone',15);
            $table->string('phone',15);
            $table->string('photo_document',50);
            $table->string('proof_adress',50);
            $table->boolean('active')->default(0);
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
        Schema::table('sallesmans', function(Blueprint $table){
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('sallesmans');
    }
}
