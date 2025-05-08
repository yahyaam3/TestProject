<template>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="text-center m-4">
            <h1 class="font-bold text-xl mb-2">Producto {{ producto.nombre }}</h1>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full table-fixed">
                <thead>
                    <tr class="bg-gray-400">
                        <th class="text-left border border-black p-2">Nombre</th>
                        <th class="text-left border border-black p-2">Precio</th>
                        <th class="text-left border border-black p-2">Descripción</th>
                        <th class="text-left border border-black p-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-left border border-black p-2">{{ producto.nombre }}</td>
                        <td class="text-left border border-black p-2">{{ producto.precio }}</td>
                        <td class="text-left border border-black p-2">{{ producto.descripcion }}</td>
                        <td class="text-left border border-black p-2">
                            <div class="flex gap-2">
                                <Link :href="route('productos.edit', producto.id)" class="text-blue-600">Editar</Link>
                                <Link :href="route('productos.index')" class="text-gray-600">Volver</Link>
                                <button @click="eliminarProducto(producto.id)" class="text-red-600">Eliminar</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import { defineProps, ref } from 'vue'

const props = defineProps({
    producto: Object
})

const producto = ref(props.producto)

function eliminarProducto(id) {
    if (confirm('¿Seguro que quieres eliminar este producto?')) {
        router.delete(route('productos.destroy', id), {
            onSuccess: () => {
                // Simplemente navega a la página de listado
                router.visit(route('productos.index'), { 
                    only: ['productos'],
                    preserveState: false,
                    replace: true
                });
            },
            onError: (errors) => {
                console.error('Error al eliminar:', errors);
                alert('No se pudo eliminar el producto');
            }
        });
    }
}
</script>