<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBirthdayDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('birthday_discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('mascota_id')->constrained()->onDelete('cascade');
            $table->foreignId('orden_id')->constrained('ordens')->onDelete('cascade');
            $table->date('fecha_uso');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('birthday_discounts');
    }
}
