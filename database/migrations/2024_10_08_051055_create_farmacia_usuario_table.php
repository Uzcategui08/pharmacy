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
        Schema::create('farmacia_usuario', function (Blueprint $table) {
            $table->id();

            // Clave foránea para 'farmacias' usando 'id_farmacia'
            $table->unsignedBigInteger('farmacia_id');
            $table->foreign('farmacia_id')->references('id_farmacia')->on('farmacias')->onDelete('cascade');

            // Clave foránea para 'usuarios' usando 'id'
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');

            // Timestamps para saber cuándo se creó o actualizó la relación
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('farmacia_usuario');
    }
};
