<template>
    <div class="container mx-auto p-4">
        <h1 class="text-xl font-bold mb-4" tabindex="0">Crear Categoría</h1>
        <div class="bg-white p-4 border rounded shadow">
            <form @submit.prevent="submit" aria-label="Formulario para crear categoría">
                <!-- Campo para el nombre de la categoría -->
                <div class="mb-3">
                    <label for="name" class="block mb-1 font-semibold text-gray-800">Nombre:</label>
                    <input
                        type="text"
                        id="name"
                        v-model="form.name"
                        class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-700"
                        required
                        aria-required="true"
                        aria-label="Nombre de la categoría"
                    />
                    <span v-if="form.errors.name" class="text-red-700 text-sm" role="alert">{{ form.errors.name }}</span>
                </div>

                <div class="flex justify-between mt-4">
                    <!-- Botón para cancelar y volver a la lista de categorías -->
                    <Link
                        :href="route('categories.index')"
                        class="bg-gray-700 text-white px-3 py-1 rounded focus:outline-none focus:ring-2 focus:ring-gray-900"
                        aria-label="Cancelar y volver al listado de categorías"
                    >
                        Cancelar
                    </Link>
                    <!-- Botón para enviar el formulario -->
                    <button
                        type="submit"
                        class="bg-blue-800 hover:bg-blue-900 text-white px-3 py-1 rounded focus:outline-none focus:ring-2 focus:ring-blue-900"
                        aria-label="Guardar nueva categoría"
                    >
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue';

// Configuramos el formulario con los campos necesarios
const form = useForm({
    name: '',
});

// Función que se ejecuta al enviar el formulario
function submit() {
    form.post(route('categories.index'));
}
</script>