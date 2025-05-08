<template>
    <nav class="bg-gray-800 text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Logo o nombre de la aplicación -->
                <div class="flex-shrink-0 flex items-center">
                    <Link :href="route('welcome')" class="text-xl font-bold">
                        Mi Tienda
                    </Link>
                </div>

                <!-- Enlaces de navegación -->
                <div class="flex space-x-4">
                    <Link 
                        :href="route('welcome')" 
                        class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700"
                        :class="{ 'bg-gray-900': route().current('welcome') }">
                        Inicio
                    </Link>
                    
                    <Link 
                        :href="route('productos.index')" 
                        class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700"
                        :class="{ 'bg-gray-900': route().current('productos.*') }">
                        Productos
                    </Link>
                    
                    <Link 
                        :href="route('categories.index')" 
                        class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700"
                        :class="{ 'bg-gray-900': route().current('categories.*') }">
                        Categorías
                    </Link>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>