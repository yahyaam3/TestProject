<template>
    <!-- Contenedor principal de la página -->
    <div class="px-4 sm:px-6 lg:px-8">
        <!-- Cabecera con título y botón de crear -->
        <div class="text-center m-4">
            <h1 class="font-bold text-xl mb-2" tabindex="0">Lista de Productos</h1>
            <button
                @click="crearProducto"
                class="bg-gray-800 text-white py-2 px-4 rounded-lg font-semibold focus:outline-none focus:ring-2 focus:ring-gray-700 focus:ring-offset-2 transition"
                aria-label="Crear Producto"
            >
                Crear Producto
            </button>
        </div>
        
        <!-- Buscador de productos con axios -->
        <div class="mb-4">
            <label for="buscar-producto" class="sr-only">Buscar producto</label>
            <input 
                id="buscar-producto"
                type="text" 
                v-model="searchTerm" 
                @input="buscarProductos" 
                placeholder="Buscar producto..." 
                class="w-full border rounded p-2"
                aria-label="Buscar producto"
            />
            <!-- Indicador de búsqueda activa -->
            <div v-if="isSearching" class="text-center py-2 text-gray-700">
                Buscando...
            </div>
        </div>
        
        <!-- Tabla de productos con scrolling horizontal si es necesario -->
        <div class="overflow-x-auto">
            <table class="min-w-full table-fixed" aria-label="Tabla de productos">
                <thead>
                    <tr class="bg-gray-700">
                        <th class="text-left border border-black p-2 text-white">Nombre</th>
                        <th class="text-left border border-black p-2 text-white">Precio</th>
                        <th class="text-left border border-black p-2 text-white">Descripción</th>
                        <th class="text-left border border-black p-2 text-white">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="producto in productos" :key="producto.id" class="bg-white even:bg-gray-100">
                        <td class="text-left border border-black p-2 text-gray-900">{{ producto.nombre }}</td>
                        <td class="text-left border border-black p-2 text-gray-900">{{ producto.precio }}</td>
                        <td class="text-left border border-black p-2 text-gray-900">{{ producto.descripcion }}</td>
                        <td class="text-left border border-black p-2">
                            <div class="flex gap-2">
                                <Link
                                    :href="route('productos.show', producto.id)"
                                    class="text-green-800 font-semibold underline hover:text-green-900 focus:outline-none focus:ring-2 focus:ring-green-700"
                                    aria-label="Ver producto"
                                >Ver</Link>
                                <Link
                                    :href="route('productos.edit', producto.id)"
                                    class="text-blue-800 font-semibold underline hover:text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-700"
                                    aria-label="Editar producto"
                                >Editar</Link>
                                <button
                                    @click="eliminar(producto)"
                                    class="text-red-800 font-semibold underline hover:text-red-900 focus:outline-none focus:ring-2 focus:ring-red-700"
                                    aria-label="Eliminar producto"
                                >Eliminar</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Carrusel de productos con navegación automática -->
        <div v-if="productos.length > 0" class="w-full max-w-4xl mx-auto mt-10">
            <div class="relative overflow-hidden rounded-xl shadow-lg"
                 @mouseenter="stopAutoplay"
                 @mouseleave="startAutoplay"
                 aria-label="Carrusel de productos"
            >
                <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                    <div class="text-center p-4">
                        <h3 class="text-xl font-bold text-gray-900" tabindex="0">{{ productos[currentIndex].nombre }}</h3>
                        <p class="text-lg text-gray-800">{{ productos[currentIndex].precio }} €</p>
                        <p class="mt-2 text-gray-700">{{ productos[currentIndex].descripcion }}</p>
                    </div>
                </div>

                <div class="absolute bottom-0 w-full bg-black bg-opacity-60 text-white p-4">
                    <div class="text-center text-lg font-semibold" tabindex="0">
                        {{ productos[currentIndex].nombre }} - {{ productos[currentIndex].precio }} €
                    </div>
                </div>

                <button
                    @click="prevImage"
                    class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-black bg-opacity-80 text-white px-3 py-1 rounded-full hover:bg-opacity-100 focus:outline-none focus:ring-2 focus:ring-white"
                    aria-label="Producto anterior"
                >
                    ‹
                </button>

                <button
                    @click="nextImage"
                    class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-black bg-opacity-80 text-white px-3 py-1 rounded-full hover:bg-opacity-100 focus:outline-none focus:ring-2 focus:ring-white"
                    aria-label="Siguiente producto"
                >
                    ›
                </button>
            </div>

            <div class="flex justify-center mt-4 space-x-2" aria-label="Selector de producto en carrusel">
                <span
                    v-for="(producto, index) in productos"
                    :key="producto.id"
                    @click="goToImage(index)"
                    class="w-3 h-3 rounded-full cursor-pointer transition-all duration-300 border border-gray-700"
                    :class="{
                        'bg-gray-800': index === currentIndex,
                        'bg-gray-400': index !== currentIndex
                    }"
                    :aria-label="`Ir al producto ${producto.nombre}`"
                    :aria-current="index === currentIndex ? 'true' : 'false'"
                    tabindex="0"
                    role="button"
                />
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, defineProps, onMounted, onUnmounted } from 'vue';
import axios from 'axios';

const props = defineProps({
    productos: Array,
    productosPaginados: Object
});

// Referencia reactiva a los productos
const productos = ref(props.productos);

// Variable para el buscador
const searchTerm = ref('');

// Estado de búsqueda
const isSearching = ref(false);

// Función para crear producto
function crearProducto(){
    router.visit('/productos/create');
}

// Temporizador para el buscador
let searchTimer;

// Función para buscar productos con axios
function buscarProductos() {
    // Cancelar temporizador anterior
    clearTimeout(searchTimer);
    
    // Esperar un momento para evitar muchas peticiones
    searchTimer = setTimeout(() => {
        // Si el campo está vacío, mostrar todos los productos
        if (!searchTerm.value) {
            productos.value = props.productos;
            return;
        }
        
        // Activar indicador de búsqueda
        isSearching.value = true;
        
        // Búsqueda con axios
        axios.get('/api/search-productos', {
            params: {
                search: searchTerm.value
            }
        })
        .then(response => {
            productos.value = response.data;
            isSearching.value = false;
        })
        .catch(error => {
            console.error('Error al buscar:', error);
            isSearching.value = false;
            
            // Si falla, filtrar en el cliente
            productos.value = props.productos.filter(producto => 
                producto.nombre.toLowerCase().includes(searchTerm.value.toLowerCase())
            );
        });
    }, 300); // 300ms de espera
}

// Slider
const currentIndex = ref(0);
const autoplayInterval = ref(null);
const isPaused = ref(false);

const nextImage = () => {
    if (productos.value.length > 0) {
        currentIndex.value = (currentIndex.value + 1) % productos.value.length;
    }
}

const prevImage = () => {
    if (productos.value.length > 0) {
        currentIndex.value = (currentIndex.value - 1 + productos.value.length) % productos.value.length;
    }
}

const goToImage = (index) => {
    if (productos.value.length > 0) {
        currentIndex.value = index;
    }
}

const startAutoplay = () => {
    if (!isPaused.value && !autoplayInterval.value) {
        autoplayInterval.value = setInterval(nextImage, 3000);
    }
}

const stopAutoplay = () => {
    clearInterval(autoplayInterval.value);
    autoplayInterval.value = null;
}

onMounted(() => {
    startAutoplay();
});

onUnmounted(() => {
    stopAutoplay();
});

// Para ProductoIndex.vue - ubicar en la sección <script setup>
function eliminar(producto) {
    if (confirm(`¿Estás seguro de que deseas eliminar el producto "${producto.nombre}"?`)) {
        router.delete(route('productos.destroy', producto.id), {
            onSuccess: () => {
                // Actualiza el array localmente para evitar recargar la página
                productos.value = productos.value.filter(p => p.id !== producto.id);
                alert('Producto eliminado correctamente');
            },
            onError: (errors) => {
                console.error('Error al eliminar:', errors);
                alert('No se pudo eliminar el producto');
            },
            preserveScroll: true
        });
    }
}
</script>

<style>
/* Accesibilidad: ocultar visualmente pero disponible para lectores de pantalla */
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