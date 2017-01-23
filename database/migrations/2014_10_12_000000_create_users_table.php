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
            $table->string('name',30);
            $table->string('sobrenome',150)->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('confirm_token',100);
            $table->date('birth')->nullable();
            $table->enum('genre',['F','M'])->nullable();
            $table->timestamp('last_access')->nullable();
            $table->enum('profile_acess',['client','sallesman','admin'])->default('client');
            $table->string('phone',15)->nullable();
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
