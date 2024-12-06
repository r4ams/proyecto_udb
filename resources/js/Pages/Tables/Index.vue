<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import BmButton from "@/bmSystem/Components/Buttons/BmButton.vue";
import { router } from "@inertiajs/vue3";

const props = defineProps(['tables']);

const deleteTable = (id) => {
  if (confirm('¿Estás seguro de que deseas eliminar esta mesa?')) {
    router.delete(route('tables.destroy', id), {
      preserveScroll: true,
    });
  }
};

const statusLabel = (status) => {
  const labels = {
    available: 'Disponible',
    reserved: 'Reservada',
    occupied: 'Ocupada',
  };
  return labels[status] || 'Desconocido';
};

</script>

<template>
  <AppLayout title="Mesas">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
      <div class="p-6 bg-white border-b border-gray-200">
        <h1 class="text-2xl font-bold">Mesas</h1>
        <div class="mt-4 flex justify-end">
          <BmButton @click="router.visit(route('tables.create'))" type="primary" size="lg">
            Crear Nueva Mesa
          </BmButton>
        </div>
        <div class="mt-6">
          <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-100">
              <tr>
                <th class="p-3 border border-gray-300">Número</th>
                <th class="p-3 border border-gray-300">Capacidad</th>
                <th class="p-3 border border-gray-300">Estado</th>
                <th class="p-3 border border-gray-300">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="table in tables" :key="table.id" class="odd:bg-white even:bg-gray-50">
                <td class="p-3 border border-gray-300 text-center">{{ table.number }}</td>
                <td class="p-3 border border-gray-300 text-center">{{ table.capacity }} personas</td>
                <!-- Estado -->
                <td class="p-3 border border-gray-300 text-center">
                  <span
                    :class="{
                      'bg-green-200 text-green-800': table.status === 'available',
                      'bg-yellow-200 text-yellow-800': table.status === 'reserved',
                      'bg-red-200 text-red-800': table.status === 'occupied',
                    }"
                    class="px-3 py-1 rounded-full text-sm font-semibold text-center"
                  >
                    {{ statusLabel(table.status) }}
                  </span>
                </td>
                <!-- Acciones -->
                <td class="p-3 border border-gray-300 text-center">
                  <BmButton @click="router.visit(route('tables.edit', table.id))" type="primary" size="sm">
                    Editar
                  </BmButton>
                  <BmButton @click="deleteTable(table.id)" type="danger" size="sm">
                    Eliminar
                  </BmButton>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
