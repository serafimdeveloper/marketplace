<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->date('birth');
            $table->enum('genre',['F','M'])->nullable();
            $table->timestamp('last_access');
            $table->enum('type_people',['F','J'])->nullable()->default('F');
            $table->string('document',25)->nullable();
            $table->string('facebook',150)->nullable();
            $table->string('phone',15)->nullable();
            $table->string('confirm_token',100);
            $table->string('cellphone',15)->nullable();
            $table->boolean('active')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
