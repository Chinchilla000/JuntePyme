<?php

// database/migrations/xxxx_xx_xx_create_user_discounts_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDiscountsTable extends Migration
{
    public function up()
    {
        Schema::create('user_discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('descuento_id')->constrained()->onDelete('cascade');
            $table->foreignId('orden_id')->constrained('ordens')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_discounts');
    }
}
