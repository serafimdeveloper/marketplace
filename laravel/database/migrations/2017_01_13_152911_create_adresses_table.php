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
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');

            $table->integer('store_id')->unsigned()->nullable();
            $table->foreign('store_id')->references('id')->on('stores')->onUpdate('cascade')->onDelete('set null');

            $table->string('name',40);
            $table->string('zip_code',9);
            $table->string('state',2);
            $table->string('city',50);
            $table->string('public_place',100);
            $table->string('neighborhood',50);
            $table->integer('number');
            $table->string('complements')->nullable();
            $table->boolean('master')->default(0);
            $table->timestamps();
            $table->softDeletes();
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
            $table->dropForeign(['store_id']);
        });

        Schema::dropIfExists('adresses');
    }
}
