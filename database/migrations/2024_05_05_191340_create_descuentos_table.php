<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDescuentosTable extends Migration
{
    public function up()
    {
        Schema::create('descuentos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->decimal('monto', 8, 2)->nullable();
            $table->decimal('porcentaje', 5, 2)->nullable();
            $table->dateTime('inicio');
            $table->dateTime('fin');
            $table->string('codigo_promocional')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('descuentos');
    }
}
