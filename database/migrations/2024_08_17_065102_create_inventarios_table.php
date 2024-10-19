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
        Schema::create('inventarios', function (Blueprint $table) {
            $table->id('id_inventario');
            $table->unsignedBigInteger('id_medicamento');
            $table->unsignedBigInteger('id_farmacia');
            $table->string('numero_lote');
            $table->integer('cantidad_disponible');
            $table->date('fecha_vencimiento');
            $table->timestamps();

            // Relaciones
            $table->foreign('id_medicamento')->references('id_medicamento')->on('medicamentos');
            $table->foreign('id_farmacia')->references('id_farmacia')->on('farmacias');

            // Unicidad de lote por medicamento y farmacia
            $table->unique(['id_medicamento', 'id_farmacia', 'numero_lote']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventarios');
    }
};
