<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosDetallesTable extends Migration
{
    public function up()
    {
        Schema::create('productos_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->string('titulo');
            $table->text('contenido');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('productos_detalles');
    }
}