<template>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="text-center m-4">
            <h1 class="font-bold text-xl mb-2" tabindex="0">Lista de Categorías</h1>
            <button
                @click="crearCategoria"
                class="bg-gray-800 text-white py-2 px-4 rounded-lg font-semibold focus:outline-none focus:ring-2 focus:ring-gray-700 focus:ring-offset-2 transition"
                aria-label="Crear Categoría"
            >
                Crear Categoría
            </button>
        </div>
        
        <!-- Buscador automático con axios -->
        <div class="mb-4">
            <label for="buscar-categoria" class="sr-only">Buscar categoría</label>
            <input 
                id="buscar-categoria"
                type="text" 
                v-model="searchTerm" 
                @input="buscarCategorias" 
                placeholder="Buscar categoría..." 
                class="w-full border rounded p-2"
                aria-label="Buscar categoría"
            />
            <div v-if="isSearching" class="text-center py-2 text-gray-700">
                Buscando...
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <!-- Tabla para mostrar las categorías -->
            <table class="min-w-full table-fixed" aria-label="Tabla de categorías">
                <thead>
                    <tr class="bg-gray-700">
                        <th class="text-left border border-black p-2 text-white">Nombre</th>
                        <th class="text-left border border-black p-2 text-white">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="cat in categories" :key="cat.id" class="bg-white even:bg-gray-100">
                        <td class="text-left border border-black p-2 text-gray-900">{{ cat.name }}</td>
                        <td class="text-left border border-black p-2">
                            <div class="flex gap-2">
                                <Link
                                    :href="route('categories.show', cat.id)"
                                    class="text-green-800 font-semibold underline hover:text-green-900 focus:outline-none focus:ring-2 focus:ring-green-700"
                                    aria-label="Ver categoría"
                                >Ver</Link>
                                <Link
                                    :href="route('categories.edit', cat.id)"
                                    class="text-blue-800 font-semibold underline hover:text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-700"
                                    aria-label="Editar categoría"
                                >Editar</Link>
                                <button
                                    @click="eliminar(cat.id)"
                                    class="text-red-800 font-semibold underline hover:text-red-900 focus:outline-none focus:ring-2 focus:ring-red-700"
                                    aria-label="Eliminar categoría"
                                >Eliminar</button>
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
import { ref, defineProps, onMounted } from 'vue';
import axios from 'axios';

const props = defineProps({
    categories: Array
});

// Referencia reactiva a las categorías
const categories = ref(props.categories);

// Variable para el buscador
const searchTerm = ref('');

// Estado de búsqueda
const isSearching = ref(false);

// Función para redireccionar a la página de creación
function crearCategoria(){
    router.visit('/categories/create');
}

// Función para eliminar una categoría con axios
function eliminar(id) {
    if (confirm('¿Estás seguro de que deseas eliminar esta categoría?')) {
        axios.post(route('categories.destroy', id), {
            _method: 'DELETE'
        })
        .then(() => {
            categories.value = categories.value.filter(cat => cat.id !== id);
        })
        .catch(error => {
            console.error('Error al eliminar:', error);
            alert('No se pudo eliminar la categoría');
        });
    }
}

// Temporizador para evitar muchas peticiones al escribir rápido
let searchTimer;

// Función para buscar categorías con axios
function buscarCategorias() {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => {
        if (!searchTerm.value) {
            categories.value = props.categories;
            return;
        }

        // Mostrar indicador de búsqueda
        isSearching.value = true;

        // Realizar búsqueda con axios
        axios.get('/api/search-categories', {
            params: {
                search: searchTerm.value
            }
        })
        .then(response => {
            categories.value = response.data;
            isSearching.value = false;
        })
        .catch(error => {
            console.error('Error en la búsqueda:', error);
            isSearchi
        // Realizar búsqueda con axios
ng.value = false;

            // Si falla la petición, hacemos búsqueda en el cliente como respaldo
            categories.value = props.categories.filter(cat => 
                cat.name.toLowerCase().includes(searchTerm.value.toLowerCase())
            );
        });
    }, 300);
}
</script>

<style>
.sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0,0,0,0);
  white-space: nowrap;
  border: 0;
}
</style>