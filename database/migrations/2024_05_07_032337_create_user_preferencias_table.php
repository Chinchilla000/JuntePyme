<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPreferenciasTable extends Migration
{
    public function up()
    {
        Schema::create('user_preferencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('opcion_nombre');
            $table->boolean('estado')->default(true);
            $table->timestamps();
            // Añadir el nuevo campo 'updated_by'
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_preferencias');
    }
}