<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id')->unsigned();
            $table->foreign('store_id')->references('id')->on('stores')->onUpdate('cascade')->onDelete('NO ACTION');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('NO ACTION');
//            $table->integer('subcategory_id')->unsigned()->nullable();
//            $table->foreign('subcategory_id')->references('id')->on('sub_categories')->onUpdate('cascade')->onDelete('NO ACTION');
            $table->string('name',100);
            $table->decimal('price',8,2);
            $table->decimal('price_with_desconto',8,2);
            $table->string('slug')->nullable();
            $table->tinyInteger('deadline');
            $table->boolean('free_shipping');
            $table->tinyInteger('minimum_tock');
            $table->text('details');
            $table->integer('length_cm');
            $table->integer('width_cm');
            $table->integer('height_cm');
            $table->integer('weight_gr');
            $table->integer('diameter_cm');
            $table->boolean('active');
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
        Schema::table('products', function(Blueprint $table){
            $table->dropForeign(['store_id']);
            $table->dropForeign(['category_id']);
//            $table->dropForeign(['subcategory_id']);
        });
        Schema::dropIfExists('products');
    }
}
