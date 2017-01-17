<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('cep',9);
            $table->string('uf',2);
            $table->string('city',50);
            $table->string('logradouro',50);
            $table->string('neighborhood',50);
            $table->integer('number');
            $table->string('complements');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adresses', function(Blueprint $table){
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('adresses');
    }
}
