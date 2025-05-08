<template>
    <Navbar />
    <main class="bg-gray-300 min-h-screen flex flex-col items-center justify-start text-black">
        <h1 class="font-bold text-2xl mb-4 mt-8" tabindex="0">Bienvenido</h1>

        <!-- Botón para mostrar/ocultar el carrusel -->
        <button
            @click="mostrarCarrusel = !mostrarCarrusel"
            class="mb-4 bg-indigo-700 text-white px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500"
            :aria-pressed="mostrarCarrusel.toString()"
            aria-label="Mostrar u ocultar carrusel de imágenes"
        >
            {{ mostrarCarrusel ? 'Ocultar Carrusel' : 'Mostrar Carrusel' }}
        </button>

        <!-- Carrusel de imágenes estáticas -->
        <div v-if="mostrarCarrusel" class="relative w-full max-w-2xl mx-auto mb-8">
            <!-- Contenedor de la imagen actual -->
            <div class="overflow-hidden rounded-lg shadow-lg h-64 flex items-center justify-center bg-gray-200">
                <!-- Imagen mostrada en el carrusel -->
                <img
                    :src="imagenes[currentIndex]"
                    :alt="`Imagen carrusel ${currentIndex + 1}`"
                    class="object-cover w-full h-64 transition-all duration-500"
                />
            </div>
            <!-- Botón para imagen anterior -->
            <button
                @click="prevImage"
                class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-black bg-opacity-60 text-white px-3 py-1 rounded-full hover:bg-opacity-80 focus:outline-none focus:ring-2 focus:ring-white"
                aria-label="Imagen anterior"
            >
                ‹
            </button>
            <!-- Botón para imagen siguiente -->
            <button
                @click="nextImage"
                class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-black bg-opacity-60 text-white px-3 py-1 rounded-full hover:bg-opacity-80 focus:outline-none focus:ring-2 focus:ring-white"
                aria-label="Siguiente imagen"
            >
                ›
            </button>
            <!-- Indicadores de posición del carrusel -->
            <div class="flex justify-center mt-2 space-x-2">
                <span
                    v-for="(img, idx) in imagenes"
                    :key="idx"
                    @click="goToImage(idx)"
                    class="w-3 h-3 rounded-full cursor-pointer border border-gray-700"
                    :class="{
                        'bg-gray-800': idx === currentIndex,
                        'bg-gray-400': idx !== currentIndex
                    }"
                    :aria-label="`Ir a la imagen ${idx + 1}`"
                    :aria-current="idx === currentIndex ? 'true' : 'false'"
                    tabindex="0"
                    role="button"
                />
            </div>
        </div>

        <nav class="mb-6" aria-label="Selector de vista">
            <button
                @click="showProductos = true"
                class="bg-blue-800 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded mr-2 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-offset-2 transition"
                :aria-pressed="showProductos.toString()"
                aria-label="Mostrar Productos"
            >
                Mostrar Productos
            </button>
            <button
                @click="showProductos = false"
                class="bg-green-800 hover:bg-green-900 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2 transition"
                :aria-pressed="(!showProductos).toString()"
                aria-label="Mostrar Categorías"
            >
                Mostrar Categorías
            </button>
        </nav>
        <section
            v-if="showProductos"
            class="w-full"
            aria-label="Listado de productos"
        >
            <ProductoIndex :productos="productos" />
        </section>
        <section
            v-else
            class="w-full"
            aria-label="Listado de categorías"
        >
            <CategoryIndex :categories="categorias" />
        </section>
    </main>
</template>

<script setup>
import { ref, defineProps, onMounted, onUnmounted } from 'vue';
import { router } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import ProductoIndex from '@/Pages/ProductoIndex.vue';
import CategoryIndex from '@/Pages/CategoryIndex.vue';

// Estado para mostrar/ocultar el carrusel
const mostrarCarrusel = ref(true);

// Array con las rutas de las imágenes estáticas del carrusel
const imagenes = [
    '/images/foto.jpg',
    '/images/descarga.jpg',
    '/images/slider3.jpg'
];

// Índice de la imagen actual
const currentIndex = ref(0);
let autoplayInterval = null;

// Función para mostrar la siguiente imagen
const nextImage = () => {
    currentIndex.value = (currentIndex.value + 1) % imagenes.length;
};
// Función para mostrar la imagen anterior
const prevImage = () => {
    currentIndex.value = (currentIndex.value - 1 + imagenes.length) % imagenes.length;
};
// Función para ir a una imagen específica
const goToImage = (idx) => {
    currentIndex.value = idx;
};

// Iniciar el autoplay del carrusel al montar el componente
const startAutoplay = () => {
    if (!autoplayInterval) {
        autoplayInterval = setInterval(nextImage, 4000);
    }
};
// Detener el autoplay al desmontar el componente
const stopAutoplay = () => {
    clearInterval(autoplayInterval);
    autoplayInterval = null;
};

onMounted(() => {
    startAutoplay();
});
onUnmounted(() => {
    stopAutoplay();
});

const props = defineProps({
    productos: Array,
    categorias: Array,
});

const showProductos = ref(true);

const goToCreateProducto = () => {
    router.visit('/productos/create');
};

const goToProductos = () => {
    router.visit('/productos');
};

const goToCreateCategoria = () => {
    router.visit('/categories/create');
};
const goToCategoria = () => {
    router.visit('/categories');
};
</script>