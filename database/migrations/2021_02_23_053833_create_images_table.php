<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->timestamps();

            // campo para relacion polimorfica
            $table->morphs('imageable'); // apartir del nombre que se le pasa crea un "type" para verificar a que tabla pertenece esta relacion (product or user) y crea un id que se encarga de guarda el identificador del elemento al que pertenece, si es un producto o imagen, este guarda la id.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
