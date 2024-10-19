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
        Schema::create('medicamentos', function (Blueprint $table) {
            $table->bigIncrements('id_medicamento'); // ID principal para 'medicamentos'
            $table->string('nombre');
            $table->decimal('precio', 8, 2);
            $table->string('fabricante');
            $table->text('descripcion');
            $table->string('pais_fabricacion');
            $table->string('categoria');
            $table->unsignedBigInteger('id_farmacia'); // Clave foránea con nombre 'id_farmacias'
            $table->timestamps();

            // Definición de la clave foránea
            $table->foreign('id_farmacia')
                ->references('id_farmacia')
                ->on('farmacias')
                ->onDelete('cascade'); // Elimina medicamentos si se elimina la farmacia asociada
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicamentos', function (Blueprint $table) {
            // Elimina la clave foránea antes de eliminar la columna
            $table->dropForeign(['id_farmacias']);
        });

        Schema::dropIfExists('medicamentos');
    }
};
