<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('id_medicamento'); // Usa el mismo tipo de dato que en 'medicamentos'
            $table->timestamps();

            // Definición de la clave foránea
            $table->foreign('id_medicamento')
                ->references('id_medicamento')
                ->on('medicamentos')
                ->onDelete('cascade'); // Elimina elementos de la wishlist si se elimina el medicamento

            // Definición de la clave foránea para el usuario
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade'); // Elimina elementos de la wishlist si se elimina el usuario
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};
