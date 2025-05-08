<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductoController extends Controller
{
    /**
     * Muestra la lista de todos los productos
     */
    public function index()
    {
        // Todos los productos (para pruebas o compatibilidad)
        $productosAll = Producto::all();

        // Productos paginados de 4 en 4
        $productosPaginados = Producto::orderBy('id', 'desc')->paginate(4);

        // Envía ambos a la vista, puedes usar el que quieras en tu componente
        return Inertia::render('ProductoIndex', [
            'productos' => $productosAll,
            'productosPaginados' => $productosPaginados
        ]);
    }

    /**
     * Muestra el formulario para crear un nuevo producto
     */
    public function create()
    {
        // Devuelve la página ProductoCreate (un formulario vacío)
        return Inertia::render('ProductoCreate');
    }

    /**
     * Guarda un nuevo producto en la base de datos
     */
    public function store(Request $request)
    {
        // Comprueba que los datos enviados son correctos
        $validate = $request->validate([
            'nombre' => 'required|max:255', 
            'precio' => 'required|numeric', 
            'descripcion' => 'nullable|string', 
            'imagen' => 'nullable' // Imagen opcional
        ]);

        // Si el usuario envió una imagen
        if ($request->hasFile('imagen')) {
            // Guarda la imagen en la carpeta "productos"
            $imagen = $request->file('imagen')->store('productos', 'public');
            $validate['imagen'] = $imagen; // Añade la ruta de la imagen a los datos
        }

        // Crea un nuevo producto con los datos validados
        Producto::create($validate);
        
        // Redirige al usuario a la lista de productos
        return redirect()->route('productos.index');
    }

    /**
     * Muestra un producto específico
     */
    public function show(Producto $producto)
    {
        // Devuelve la página ProductoShow y le envía el producto solicitado
        return Inertia::render('ProductoShow', [
            'producto' => $producto // Laravel busca automáticamente el producto por su ID
        ]);
    }

    /**
     * Muestra el formulario para editar un producto
     */
    public function edit(Producto $producto)
    {
        // Devuelve la página ProductoEdit y le envía el producto a editar
        return Inertia::render('ProductoEdit', [
            'producto' => $producto // Envía el producto para prellenar el formulario
        ]);
    }

    /**
     * Actualiza un producto existente
     */
    public function update(Request $request, Producto $producto)
    {
        // Comprueba que los datos enviados son correctos
        $validate = $request->validate([
            'nombre' => 'required|max:255', 
            'precio' => 'required|numeric', 
            'descripcion' => 'nullable|string', 
            'imagen' => 'nullable' 
        ]);

        // Si el usuario envió una nueva imagen
        if ($request->hasFile('imagen')) {
            // Guarda la nueva imagen
            $imagen = $request->file('imagen')->store('productos', 'public');
            $validate['imagen'] = $imagen; // Actualiza la ruta de la imagen
        }

        // Actualiza el producto con los nuevos datos
        $producto->update($validate);
        
        // Redirige al usuario a la lista de productos
        return redirect()->route('productos.index');
    }

    /**
     * Elimina un producto de la base de datos
     */
    public function destroy(Producto $producto)
    {
        // Borra el producto
        $producto->delete();
        
        // Redirige al usuario a la lista de productos
        return redirect()->route('productos.index');
    }
}
