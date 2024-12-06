<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import BmButton from "@/bmSystem/Components/Buttons/BmButton.vue";
import { ref, computed } from 'vue';
import { router } from "@inertiajs/vue3";

// Props enviadas desde el controlador
const props = defineProps({
  orders: Array, // Cambiar a Object si usas paginación en el servidor
});

// Estado para búsqueda
const searchQuery = ref('');

// Paginación
const currentPage = ref(1); // Página actual
const perPage = 5; // Elementos por página

// Filtrar órdenes según la consulta de búsqueda
const filteredOrders = computed(() => {
  if (!searchQuery.value) return props.orders;
  const query = searchQuery.value.toLowerCase();

  return props.orders.filter(order =>
    order.customer_name.toLowerCase().includes(query) ||
    `Mesa #${order.table.number}`.toLowerCase().includes(query) ||
    order.status.toLowerCase().includes(query)
  );
});

// Cálculo de órdenes para la página actual
const paginatedOrders = computed(() => {
  const start = (currentPage.value - 1) * perPage;
  const end = start + perPage;
  return filteredOrders.value.slice(start, end);
});

// Total de páginas
const totalPages = computed(() => Math.ceil(filteredOrders.value.length / perPage));

// Función para eliminar una orden
const deleteOrder = (id) => {
  if (confirm("¿Estás seguro de que deseas eliminar esta orden?")) {
    router.delete(route('orders.destroy', id));
  }
};

const updateOrderStatus = (id, status) => {
  router.post(route('orders.updateStatus', id), { status }, {
    preserveScroll: true,
    onSuccess: () => {
      alert("Estado actualizado exitosamente.");
    },
    onError: () => {
      alert("Hubo un error al actualizar el estado. Intenta nuevamente.");
    }
  });
};

// Traducción y clases de estado
const statusTranslations = {
  pending: 'Pendiente',
  in_progress: 'En Progreso',
  completed: 'Completada',
  cancelled: 'Cancelada',
};

const translateStatus = (status) => statusTranslations[status] || status;

const statusClasses = {
  pending: 'bg-yellow-100 text-yellow-700 border-yellow-400',
  in_progress: 'bg-blue-100 text-blue-700 border-blue-400',
  completed: 'bg-green-100 text-green-700 border-green-400',
  cancelled: 'bg-red-100 text-red-700 border-red-400',
};

const getStatusClasses = (status) => statusClasses[status] || 'bg-gray-100 text-gray-700 border-gray-400';
</script>

<template>
  <AppLayout title="Órdenes">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
      <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
        <!-- Título y botón de nueva orden -->
        <div class="flex justify-between items-center">
          <h1 class="text-2xl font-bold">Órdenes</h1>
          <BmButton @click="router.visit(route('orders.create'))" size="lg">Nueva Orden</BmButton>
        </div>

        <!-- Barra de búsqueda -->
        <div class="mt-4">
          <input
            v-model="searchQuery"
            type="text"
            class="w-full p-2.5 border rounded-lg text-gray-700"
            placeholder="Buscar por cliente, mesa o estado..."
          />
        </div>

        <!-- Tabla de órdenes -->
        <div class="mt-4">
          <table class="min-w-full border-collapse border border-gray-300">
            <thead>
              <tr class="bg-gray-200">
                <th class="border border-gray-300 px-4 py-2">#</th>
                <th class="border border-gray-300 px-4 py-2">Cliente</th>
                <th class="border border-gray-300 px-4 py-2">Mesa</th>
                <th class="border border-gray-300 px-4 py-2">Items</th>
                <th class="border border-gray-300 px-4 py-2">Total</th>
                <th class="border border-gray-300 px-4 py-2">Estado</th>
                <th class="border border-gray-300 px-4 py-2">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="order in paginatedOrders"
                :key="order.id"
                class="odd:bg-white even:bg-gray-50"
              >
                <td class="border border-gray-300 px-4 py-2">{{ order.id }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ order.customer_name }}</td>
                <td class="border border-gray-300 px-4 py-2">
                  Mesa #{{ order.table.number }} (Capacidad: {{ order.table.capacity }} personas)
                </td>
                <td class="border border-gray-300 px-4 py-2">
                  <ul>
                    <li
                      v-for="detail in order.details"
                      :key="detail.id"
                    >
                      {{ detail.menu.name }} ({{ detail.quantity }} x ${{ detail.menu.price }}) = ${{ detail.subtotal }}
                    </li>
                  </ul>
                </td>
                <td class="border border-gray-300 px-4 py-2">${{ order.total }}</td>
                <td class="border border-gray-300 px-4 py-2 capitalize">
                  <span
                      :class="`inline-block px-3 py-1 text-sm font-semibold rounded-full border ${getStatusClasses(order.status)}`">
                      {{ translateStatus(order.status) }}
                  </span>
                </td>
                <td class="border border-gray-300 px-4 py-2">
                  <div class="flex flex-col space-y-2">
                    <select
                      v-model="order.status"
                      @change="updateOrderStatus(order.id, order.status)"
                      class="w-full p-1 border rounded-lg text-gray-700"
                    >
                      <option value="pending">Pendiente</option>
                      <option value="in_progress">En Progreso</option>
                      <option value="completed">Completada</option>
                      <option value="cancelled">Cancelada</option>
                    </select>

                    <div class="flex space-x-2 mt-2">
                      <BmButton
                        @click="router.visit(route('orders.edit', order.id))"
                        size="sm"
                      >
                        Editar
                      </BmButton>
                      <BmButton
                        @click="deleteOrder(order.id)"
                        size="sm"
                        type="secondary"
                      >
                        Eliminar
                      </BmButton>
                    </div>
                  </div>
                </td>
              </tr>
              <tr v-if="filteredOrders.length === 0">
                <td colspan="7" class="text-center py-4 text-gray-500">
                  No se encontraron órdenes que coincidan con la búsqueda.
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Paginación -->
        <div class="flex justify-between items-center mt-4">
          <button
            @click="currentPage--"
            :disabled="currentPage === 1"
            class="px-3 py-2 border rounded-lg bg-gray-200 hover:bg-gray-300 disabled:opacity-50"
          >
            Anterior
          </button>
          
          <span>Página {{ currentPage }} de {{ totalPages }}</span>
          
          <button
            @click="currentPage++"
            :disabled="currentPage === totalPages"
            class="px-3 py-2 border rounded-lg bg-gray-200 hover:bg-gray-300 disabled:opacity-50"
          >
            Siguiente
          </button>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
table {
  width: 100%;
  border-spacing: 0;
}
</style>
