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
        Schema::table('farmacias', function (Blueprint $table) {
            $table->string('ubicacion')->change()->nullable()->after('rif');
        });

        DB::statement('ALTER TABLE farmacias MODIFY ubicacion POINT NOT NULL');
        DB::statement('ALTER TABLE farmacias ADD SPATIAL INDEX (ubicacion)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('farmacias', function (Blueprint $table) {
            $table->string('ubicacion')->change();
        });
    }
};
