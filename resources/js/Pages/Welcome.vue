<template>
    <Navbar />
    <main class="bg-gray-300 min-h-screen flex flex-col items-center justify-start text-black">
        <h1 class="font-bold text-2xl mb-4 mt-8" tabindex="0">Bienvenido</h1>
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
import { ref, defineProps } from 'vue';
import { router } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import ProductoIndex from '@/Pages/ProductoIndex.vue';
import CategoryIndex from '@/Pages/CategoryIndex.vue';

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