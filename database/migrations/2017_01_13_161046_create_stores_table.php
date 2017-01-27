<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('salesman_id')->unsigned();
            $table->foreign('salesman_id')->references('id')->on('salesmans')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name',50);
            $table->string('branch_activity')->nullable();
            $table->string('identifier',20);
            $table->text('about');
            $table->text('exchange_policy');
            $table->text('freight_policy');
            $table->string('logo_file',100);
            $table->string('slug')->nullable();
            $table->decimal('rate',3,2);
            $table->boolean('active');
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
        Schema::table('stores', function(Blueprint $table){
            $table->dropForeign(['sallesman_id']);
        });

        Schema::dropIfExists('stores');
    }
}
