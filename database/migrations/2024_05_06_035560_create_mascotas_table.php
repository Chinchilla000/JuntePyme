<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mascotas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Cambiado de user_informacion_id a user_id
            $table->string('nombre');
            $table->date('fecha_cumpleanos')->nullable();
            $table->string('alimento')->nullable();
            $table->string('especie');
            $table->string('raza')->nullable();
            $table->unsignedInteger('peso_en_gramos')->nullable(); // Nuevo campo para peso en gramos
            $table->string('color')->nullable();
            $table->string('sexo')->nullable();
            $table->timestamps();

            // Establece la relación con la tabla 'users'
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mascotas');
    }
};
