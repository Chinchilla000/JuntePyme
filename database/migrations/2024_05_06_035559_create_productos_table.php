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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('codigo_barras')->nullable(); // Nuevo campo para código de barras
            $table->string('nombre');
            $table->text('descripcion');
            $table->decimal('precio_venta_neto', 8, 2)->nullable();
            $table->decimal('iva_venta', 8, 2)->nullable();
            $table->decimal('precio_venta_bruto', 8, 2)->nullable(); // Precio por unidad de compra del proveedor
            $table->string('unidad_de_medida')->nullable(); // Unidad de medida, como 'kg', 'litros', etc.
            $table->integer('cantidad_disponible')->default(0); // Cantidad en stock
            $table->integer('cantidad_minima')->default(0); // Cantidad mínima recomendada en stock
            $table->unsignedBigInteger('categoria_id')->nullable(); // ID de la categoría
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('set null'); // Clave foránea referenciando a categorías con ON DELETE SET NULL
            $table->unsignedBigInteger('proveedor_id')->nullable(); // ID del proveedor
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('set null'); // Clave foránea referenciando a proveedores con ON DELETE SET NULL
            $table->string('imagen_producto')->nullable(); // Path de la imagen del producto
            $table->string('marca')->nullable(); // Marca del producto
            $table->date('fecha_de_vencimiento')->nullable(); // Fecha de última compra al proveedor
            $table->boolean('estado')->default(1); // Estado del producto (1: visible, 0: oculto)
            $table->foreignId('descuento_id')->nullable()->constrained('descuentos')->onDelete('set null');
            $table->boolean('es_destacado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            // Asegúrate de eliminar primero la llave foránea antes de la columna
            $table->dropForeign(['descuento_id']);
            $table->dropForeign(['categoria_id']);
            $table->dropForeign(['proveedor_id']);
            $table->dropColumn('descuento_id');
            $table->dropColumn('es_destacado');
            $table->dropColumn('codigo_barras'); // Eliminar el nuevo campo en reverse
        });

        Schema::dropIfExists('productos');
    }
};
