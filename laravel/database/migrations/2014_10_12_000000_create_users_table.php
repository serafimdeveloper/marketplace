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
            $table->string('last_name',150)->nullable();
            $table->string('email')->unique();
            $table->string('cpf', 15)->unique()->nullable();
            $table->string('password');
            $table->string('confirm_token',100);
            $table->date('birth')->nullable();
            $table->enum('genre',['F','M'])->nullable();
            $table->timestamp('last_access')->nullable();
            $table->string('phone',15)->nullable();
            $table->enum('type_user',['client','seller','admin'])->default('client');
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
