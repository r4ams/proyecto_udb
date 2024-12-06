<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import BmButton from "@/bmSystem/Components/Buttons/BmButton.vue";
import { ref, computed } from "vue";
import { router } from "@inertiajs/vue3";

// Props con paginación
const props = defineProps({
  reservations: Object, // Ahora es un objeto de paginación
});

const searchQuery = ref('');
const filteredReservations = computed(() => {
  const query = searchQuery.value.toLowerCase();
  return props.reservations.data.filter(
    (reservation) =>
      reservation.customer_name.toLowerCase().includes(query) ||
      reservation.phone.includes(query)
  );
});

const deleteReservation = (id) => {
  if (confirm('¿Estás seguro de que deseas eliminar esta reservación?')) {
    router.delete(route('reservations.destroy', id), { preserveScroll: true });
  }
};
</script>

<template>
  <AppLayout title="Reservaciones">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
      <div class="p-6 bg-white border-b border-gray-200">
        <h1 class="text-2xl font-bold">Reservaciones</h1>
        <div class="mt-4 flex justify-between">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Buscar por nombre o teléfono"
            class="w-1/2 p-2 border rounded-lg"
          />
          <BmButton @click="router.visit(route('reservations.create'))" type="primary" size="lg">
            Crear Nueva Reservación
          </BmButton>
        </div>

        <div class="mt-6">
          <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-100">
              <tr>
                <th class="p-3 border border-gray-300">Cliente</th>
                <th class="p-3 border border-gray-300">Teléfono</th>
                <th class="p-3 border border-gray-300">Mesa</th>
                <th class="p-3 border border-gray-300">Fecha y Hora</th>
                <th class="p-3 border border-gray-300">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="reservation in filteredReservations" :key="reservation.id" class="odd:bg-white even:bg-gray-50">
                <td class="p-3 border border-gray-300">{{ reservation.customer_name }}</td>
                <td class="p-3 border border-gray-300">{{ reservation.phone }}</td>
                <td class="p-3 border border-gray-300">Mesa #{{ reservation.table.number }}</td>
                <td class="p-3 border border-gray-300">{{ reservation.reservation_date }}</td>
                <td class="p-3 border border-gray-300 flex space-x-2">
                  <BmButton @click="router.visit(route('reservations.edit', reservation.id))" type="primary" size="sm">
                    Editar
                  </BmButton>
                  <BmButton @click="deleteReservation(reservation.id)" type="danger" size="sm">
                    Eliminar
                  </BmButton>
                </td>
              </tr>
              <tr v-if="filteredReservations.length === 0">
                <td colspan="5" class="text-center p-4 text-gray-500">
                  No se encontraron reservaciones.
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Paginación -->
        <div class="mt-4 flex justify-center">
          <ul class="flex space-x-2">
            <li v-for="link in props.reservations.links" :key="link.label">
              <button
                @click="link.url && router.visit(link.url)"
                :class="{
                  'px-3 py-2 border rounded-lg': true,
                  'bg-gray-200 hover:bg-gray-300': link.url,
                  'opacity-50 cursor-not-allowed': !link.url,
                  'font-bold': link.active
                }"
                :disabled="!link.url"
              >
                <!-- Reemplaza los textos -->
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
