<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informacion', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('imagen');
            $table->string('tipo')->nullable();
            $table->string('apartado')->nullable();
            $table->string('color')->nullable();
            $table->timestamp('fecha_publicacion')->nullable();
            $table->string('slug')->nullable();
            $table->json('metadatos')->nullable();
            $table->text('contenido')->nullable();
            $table->string('autor')->nullable();
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->string('tags')->nullable();
            $table->timestamps();

            // Relaciones
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('informacion');
    }
}