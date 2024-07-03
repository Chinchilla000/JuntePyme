<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesOrdensTable extends Migration
{
    public function up()
    {
        Schema::create('detalles_ordens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('orden_id');
            $table->string('tipo_retiro');
            $table->string('pais')->nullable();
            $table->string('direccion')->nullable();
            $table->string('casa_apartamento')->nullable();
            $table->string('comuna')->nullable();
            $table->string('region')->nullable();
            $table->string('sucursal_retiro')->nullable();
            $table->timestamps();

            $table->foreign('orden_id')->references('id')->on('ordens')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('detalles_ordens');
    }
}