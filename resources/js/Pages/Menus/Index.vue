<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import BmButton from "@/bmSystem/Components/Buttons/BmButton.vue";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps(['menuItems']);

const deleteItem = (id) => {
  if (confirm('¿Estás seguro de que deseas eliminar este ítem?')) {
    router.delete(route('menus.destroy', id), {
      preserveScroll: true,
    });
  }
};

const navigateToPage = (url) => {
  if (url) router.visit(url);
};
</script>
<template>
  <AppLayout title="Ítems del Menú">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
      <div class="p-6 bg-white border-b border-gray-200">
        <h1 class="text-2xl font-bold">Ítems del Menú</h1>
        <div class="mt-4 flex justify-end">
          <BmButton @click="router.visit(route('menus.create'))" type="primary" size="lg">
            Crear Nuevo Ítem
          </BmButton>
        </div>

        <!-- Tabla de Ítems del Menú -->
        <div class="mt-6">
          <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-100">
              <tr>
                <th class="p-3 border border-gray-300">Nombre</th>
                <th class="p-3 border border-gray-300">Descripción</th>
                <th class="p-3 border border-gray-300">Precio</th>
                <th class="p-3 border border-gray-300">Tipo</th>
                <th class="p-3 border border-gray-300">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in menuItems.data" :key="item.id" class="odd:bg-white even:bg-gray-50">
                <td class="p-3 border border-gray-300">{{ item.name }}</td>
                <td class="p-3 border border-gray-300">{{ item.description }}</td>
                <td class="p-3 border border-gray-300">$ {{ item.price }}</td>
                <td class="p-3 border border-gray-300 capitalize">{{ item.type }}</td>
                <td class="p-3 border border-gray-300 flex space-x-2">
                  <BmButton @click="router.visit(route('menus.edit', item.id))" type="primary" size="sm">
                    Editar
                  </BmButton>
                  <BmButton @click="deleteItem(item.id)" type="danger" size="sm">
                    Eliminar
                  </BmButton>
                </td>
              </tr>
              <tr v-if="menuItems.data.length === 0">
                <td colspan="5" class="p-3 text-center text-gray-500">No hay ítems disponibles.</td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Controles de Paginación -->
        <div class="mt-4 flex justify-center">
          <ul class="flex space-x-2">
            <li v-for="link in menuItems.links" :key="link.label">
              <button
                @click="navigateToPage(link.url)"
                :class="{
                  'px-3 py-2 border rounded-lg': true,
                  'bg-gray-200 hover:bg-gray-300': link.url,
                  'opacity-50 cursor-not-allowed': !link.url,
                  'font-bold': link.active
                }"
                :disabled="!link.url"
              >
                <!-- Traducción de etiquetas -->
                <span v-if="link.label === 'Next'">Siguiente</span>
                <span v-else-if="link.label === 'Previous'">Anterior</span>
                <span v-else v-html="link.label"></span>
              </button>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
