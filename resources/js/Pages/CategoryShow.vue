<template>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="text-center m-4">
            <h1 class="font-bold text-xl mb-2">Categoría {{ category.name }}</h1>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full table-fixed">
                <thead>
                    <tr class="bg-gray-400">
                        <th class="text-left border border-black p-2">Nombre</th>
                        <th class="text-left border border-black p-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-left border border-black p-2">{{ category.name }}</td>
                        <td class="text-left border border-black p-2">
                            <div class="flex gap-2">
                                <Link :href="route('categories.edit', category.id)" class="text-blue-600">Editar</Link>
                                <Link :href="route('categories.index')" class="text-gray-600">Volver</Link>
                                <button @click="eliminar(category.id)" class="text-red-600">Eliminar</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, defineProps } from 'vue';
import axios from 'axios';

const props = defineProps({
    category: Object
});

const category = ref(props.category);

function crearCategoria(){
    router.visit('/categories/create')
}


function eliminarProducto(id) {
    if (confirm('¿Seguro que quieres eliminar este producto?')) {
        // Obtener el token CSRF para seguridad
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        axios.delete(route('productos.destroy', id), {
            headers: {
                
            }
        })
        .then(() => {
            // Redirección a la lista de productos
            window.location.href = route('productos.index')
            // Alternativa con Inertia: router.visit(route('productos.index'))
        })
        
        ;
    }
}
</script>