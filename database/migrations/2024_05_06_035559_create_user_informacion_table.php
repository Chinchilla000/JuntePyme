<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_informacion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Clave foránea que vincula a la tabla de usuarios
            $table->string('rut')->unique()->nullable(); // RUT del usuario, asegúrate de que sea único
            $table->string('nombre');
            $table->string('apellido')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->unique(); // Asegúrate de que el email sea único si lo usas aquí también
            $table->string('region')->nullable(); // Campo para la región
            $table->string('comuna')->nullable(); // Campo para la comuna
            $table->string('ciudad')->nullable(); // Campo para la ciudad
            $table->string('calle')->nullable(); // Calle
            $table->string('numero')->nullable(); // Número de casa o edificio
            $table->string('departamento')->nullable(); // Departamento o unidad, si aplica
            $table->timestamps();

            // Establece la relación con la tabla 'users'
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_informacion');
    }
};
