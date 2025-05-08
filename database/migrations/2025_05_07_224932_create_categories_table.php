<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    
    public function up(): void
    {
        // Creamos una nueva tabla llamada "categories"
        Schema::create('categories', function (Blueprint $table) {
            $table->id();                 
            $table->string('name');  
            $table->timestamps();
        });
    }

    /**
     * Revierte la migración, eliminando la tabla.
     * Esta función se ejecuta cuando lanzamos "php artisan migrate:rollback"
     */
    public function down(): void
    {
        // Elimina la tabla "categories" si existe
        Schema::dropIfExists('categories');
    }
};
