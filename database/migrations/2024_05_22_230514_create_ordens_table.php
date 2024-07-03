<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdensTable extends Migration
{
    public function up()
    {
        Schema::create('ordens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('total', 10, 2);
            $table->string('status')->default('pending');
            $table->string('reference')->unique();
            $table->string('session_id')->nullable(); // Campo session_id
            $table->string('discount_code')->nullable(); // Campo discount_code
            $table->text('message')->nullable(); // Campo para almacenar el mensaje de la notificación
            $table->timestamp('notification_date')->nullable(); // Campo para almacenar la fecha de la notificación
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ordens');
    }
}
