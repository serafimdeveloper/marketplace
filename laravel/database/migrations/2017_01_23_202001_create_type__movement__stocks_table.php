<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeMovementStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_movement_stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',30);
            $table->string('description',100);
            $table->enum('type',['out','in'])->default('out');
            $table->string('slug')->nullable();
            $table->boolean('default')->default(0);
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
        Schema::dropIfExists('type_movement_stocks');
    }
}
