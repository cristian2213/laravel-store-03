<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Nombre de la tabla debe ser en plural "productables"
class CreateProductablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //* tabla de relacion polimorfica
        Schema::create('productables', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity')->unsigned();

            // indica el nombre de la relacion polimorfica, para indicar si pertenece a un carrito o a una orden
            $table->morphs('productable');


            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_product');
    }
}
