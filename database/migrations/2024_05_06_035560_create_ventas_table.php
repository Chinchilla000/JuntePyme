<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('producto_id');
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->unsignedBigInteger('user_id')->nullable(); // Relaciona con 'users'
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('cantidad');
            $table->decimal('precio_total', 10, 2);
            $table->string('tipo_pago', 50); // Ejemplos: 'efectivo', 'tarjeta', 'transferencia'
            $table->text('comentario')->nullable(); // Comentarios adicionales sobre la venta
            $table->boolean('pago_confirmado')->default(false); // Confirma si el pago fue realizado
            $table->timestamp('fecha')->useCurrent(); // Fecha de la venta
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
