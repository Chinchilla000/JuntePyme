<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenProductoTable extends Migration
{
    public function up()
    {
        Schema::create('orden_producto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_id')->constrained('ordens')->onDelete('cascade');
            $table->foreignId('producto_id')->constrained()->onDelete('cascade');
            $table->integer('cantidad');
            $table->decimal('precio', 10, 2);
            $table->decimal('descuento', 10, 2)->default(0); // Campo descuento añadido
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orden_producto');
    }
}