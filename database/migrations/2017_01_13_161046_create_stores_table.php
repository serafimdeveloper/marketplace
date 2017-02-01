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
            $table->string('cpf', 15)->nullable();
            $table->string('cnpj', 20)->nullable();
            $table->string('fantasy_name', 50)->nullable();
            $table->string('social_name', 50)->nullable();
//            $table->string('identifier',20);
            $table->text('about');
            $table->text('exchange_policy');
            $table->text('freight_policy')->nullable();
            $table->string('logo_file',100)->nullable();
            $table->string('slug')->nullable();
            $table->decimal('rate',3,2)->nullable();
            $table->boolean('active')->default(0);
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
