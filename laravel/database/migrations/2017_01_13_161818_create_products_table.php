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
            $table->string('name',100);
            $table->integer('quantity')->unsigned();
            $table->decimal('price',8,2);
            $table->decimal('price_out_discount',8,2)->nullable();
            $table->string('slug')->nullable();
            $table->tinyInteger('deadline');
            $table->boolean('free_shipping')->default(0);
            $table->tinyInteger('minimum_stock');
            $table->text('details');
            $table->float('length_cm');
            $table->float('width_cm');
            $table->float('height_cm');
            $table->float('weight_gr',10,3);
            $table->float('diameter_cm');
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
        Schema::table('products', function(Blueprint $table){
            $table->dropForeign(['store_id']);
            $table->dropForeign(['category_id']);
//            $table->dropForeign(['subcategory_id']);
        });
        Schema::dropIfExists('products');
    }
}
