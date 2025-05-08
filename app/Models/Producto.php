<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Producto - 
 * Esta clase se conecta con la tabla 'productos'
 */
class Producto extends Model
{
    // HasFactory permite crear productos fácilmente en pruebas
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente
     * Estos campos se pueden llenar con el método create() o fill()
     */
    protected $fillable = [
        'nombre',      
        'descripcion', 
        'precio',  
        'category_id'  
    ];

    /**
     * Obtiene la categoría a la que pertenece este producto
     * Relación: Un producto pertenece a una categoría
     */
    public function category() {
        return $this->belongsTo(Category::class);
    }
}
