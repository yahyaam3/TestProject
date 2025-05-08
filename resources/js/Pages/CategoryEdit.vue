<template>
    <Head title="Editar Categoría" />

    <div class="container mx-auto p-4">
        <h1 class="text-xl font-bold mb-4" tabindex="0">Editar Categoría</h1>

        <div class="bg-white p-4 border rounded shadow">
            <form @submit.prevent="submit" aria-label="Formulario para editar categoría">
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
                    <Link
                        :href="route('categories.index')"
                        class="bg-gray-700 text-white px-3 py-1 rounded focus:outline-none focus:ring-2 focus:ring-gray-900"
                        aria-label="Cancelar y volver al listado de categorías"
                    >
                        Cancelar
                    </Link>
                    <button
                        type="submit"
                        class="bg-blue-800 hover:bg-blue-900 text-white px-3 py-1 rounded focus:outline-none focus:ring-2 focus:ring-blue-900"
                        aria-label="Guardar cambios de la categoría"
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
import { defineProps, onMounted } from 'vue';

const props = defineProps({
    category: Object,
});

const form = useForm({
    name: '',
    _method: 'put',
});

onMounted(() => {
    if (props.category) {
        form.name = props.category.name;
    }
});

function submit() {
    form.post(route('categories.update', props.category.id));
}
</script>