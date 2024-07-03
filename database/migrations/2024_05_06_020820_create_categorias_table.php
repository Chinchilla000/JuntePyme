<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('imagen_categoria')->nullable();
            $table->unsignedBigInteger('categoria_padre_id')->nullable();
            $table->timestamps();

            // Clave foránea para la relación con la categoría padre
            $table->foreign('categoria_padre_id')->references('id')->on('categorias')->onDelete('cascade');
            $table->foreignId('descuento_id')->nullable()->constrained('descuentos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categorias', function (Blueprint $table) {
            // Asegúrate de eliminar primero la llave foránea antes de la columna
            $table->dropForeign(['descuento_id']);
            $table->dropColumn('descuento_id');
        });
    }
    
};