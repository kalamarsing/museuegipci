<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('floors', function (Blueprint $table) {
            // Añadir las columnas 'map2' e 'image' como campos de tipo string y nullable
            $table->string('map2')->nullable()->after('map');
            $table->string('image')->nullable()->after('map2');
        });
    }


    public function down(): void
    {
        Schema::table('floors', function (Blueprint $table) {
            // Eliminar las columnas 'map2' e 'image' si se revierte la migración
            $table->dropColumn(['map2', 'image']);
        });
    }
};
