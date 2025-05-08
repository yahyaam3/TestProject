<template>
    <footer class="bg-gray-800 text-white py-4">
        <div class="max-w-7xl mx-auto text-center">
            <p>&copy; {{ currentYear }} . Todos los derechos reservados.</p>
            <div class="flex justify-center space-x-4">
                <a href="#" class="hover:underline">Política de Privacidad</a>
                <a href="#" class="hover:underline">Términos de Servicio</a>
            </div>
        </div>
    </footer>
</template>

<script setup>
import { ref } from 'vue';

const currentYear = ref(new Date().getFullYear());
</script>

<style scoped>
footer {
    position: relative;
    bottom: 0;
    width: 100%;
}
</style>