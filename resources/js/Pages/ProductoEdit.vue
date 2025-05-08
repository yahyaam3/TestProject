<template>
    <Head title="Editar Producto" />

    <div class="container mx-auto p-4">
        <h1 class="text-xl font-bold mb-4" tabindex="0">Editar Producto</h1>

        <div class="bg-white p-4 border rounded shadow">
            <form @submit.prevent="submit" aria-label="Formulario para editar producto">
                <div class="mb-3">
                    <label for="nombre" class="block mb-1 font-semibold text-gray-800">Nombre:</label>
                    <input
                        type="text"
                        id="nombre"
                        v-model="form.nombre"
                        class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-700"
                        required
                        aria-required="true"
                        aria-label="Nombre del producto"
                    />
                    <span v-if="form.errors && form.errors.nombre" class="text-red-700 text-sm" role="alert">{{ form.errors.nombre }}</span>
                </div>

                <div class="mb-3">
                    <label for="precio" class="block mb-1 font-semibold text-gray-800">Precio:</label>
                    <input
                        type="number"
                        id="precio"
                        v-model="form.precio"
                        class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-700"
                        step="0.01"
                        required
                        aria-required="true"
                        aria-label="Precio del producto"
                    />
                    <span v-if="form.errors && form.errors.precio" class="text-red-700 text-sm" role="alert">{{ form.errors.precio }}</span>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="block mb-1 font-semibold text-gray-800">Descripción:</label>
                    <textarea
                        id="descripcion"
                        v-model="form.descripcion"
                        class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-700"
                        required
                        aria-required="true"
                        aria-label="Descripción del producto"
                    ></textarea>
                    <span v-if="form.errors && form.errors.descripcion" class="text-red-700 text-sm" role="alert">{{ form.errors.descripcion }}</span>
                </div>

                <div class="flex justify-between mt-4">
                    <Link
                        :href="route('productos.index')"
                        class="bg-gray-700 text-white px-3 py-1 rounded focus:outline-none focus:ring-2 focus:ring-gray-900"
                        aria-label="Cancelar y volver al listado de productos"
                    >
                        Cancelar
                    </Link>
                    <button
                        type="submit"
                        class="bg-blue-800 hover:bg-blue-900 text-white px-3 py-1 rounded focus:outline-none focus:ring-2 focus:ring-blue-900"
                        aria-label="Guardar cambios del producto"
                    >
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import { defineProps, onMounted } from 'vue'

const props = defineProps({
    producto: Object,
})

const form = useForm({
    nombre: '',
    precio: '',
    descripcion: '',
    _method: 'put',
})

onMounted(() => {
    if (props.producto) {
        form.nombre = props.producto.nombre
        form.precio = props.producto.precio
        form.descripcion = props.producto.descripcion
    }
})

function submit() {
    form.post(route('productos.update', props.producto.id))
}
</script>