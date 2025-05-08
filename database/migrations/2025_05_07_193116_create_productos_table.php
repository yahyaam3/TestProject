<?php

// Estas son herramientas de Laravel para crear tablas en la base de datos
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Esta clase es como un plano para crear la tabla de productos
return new class extends Migration
{
    /**
     * Esta función crea la tabla cuando ejecutas el comando "php artisan migrate"
     */
    public function up(): void
    {
        // Crea una nueva tabla llamada "productos"
        Schema::create('productos', function (Blueprint $table) {
            // Crea un número único para cada producto (1, 2, 3...)
            $table->id();
            
            // Guarda el nombre del producto (obligatorio)
            $table->string('nombre');
            
            // Guarda la descripción (puede estar vacía)
            $table->text('descripcion')->nullable();
            
    
            $table->text('precio', 8, 2);
            
            // Añade campos de "creado el" y "actualizado el" automáticamente
            $table->timestamps();
        });
    }

    /**
     * Esta función borra la tabla si necesitas deshacer la migración
     */
    public function down(): void
    {
        // Borra completamente la tabla "productos" si existe
        Schema::dropIfExists('productos');
    }
};
