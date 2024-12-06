<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm, router } from "@inertiajs/vue3";
import InputNew from '@/bmSystem/Components/Inputs/BmInput.vue';
import BmButton from "@/bmSystem/Components/Buttons/BmButton.vue";

const props = defineProps(['table']);

const form = useForm({
  number: props.table.number,
  capacity: props.table.capacity,
  status: props.table.status, // Agrega el estado inicial
});

const statusOptions = {
  available: 'Disponible',
  reserved: 'Reservada',
  occupied: 'Ocupada',
};

const submit = () => {
  form.put(route('tables.update', props.table.id), {
    preserveScroll: true,
  });
};
</script>
<template>
  <AppLayout title="Editar Mesa">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
      <div class="p-6 bg-white border-b border-gray-200">
        <h1 class="text-2xl font-bold">Editar Mesa</h1>
        <form @submit.prevent="submit" class="mt-6">
          <!-- Número de Mesa -->
          <div class="py-2">
            <InputNew
              v-model="form.number"
              block
              id="table_number"
              name="table_number"
              type="number"
              label="Número de la Mesa"
            />
            <div v-if="form.errors.number" class="text-red-500">{{ form.errors.number }}</div>
          </div>
          <!-- Capacidad -->
          <div class="py-2">
            <InputNew
              v-model="form.capacity"
              block
              id="capacity"
              name="capacity"
              type="number"
              label="Capacidad (personas)"
            />
            <div v-if="form.errors.capacity" class="text-red-500">{{ form.errors.capacity }}</div>
          </div>
          <!-- Estado -->
          <div class="py-2">
            <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
            <select
              id="status"
              v-model="form.status"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            >
              <option v-for="(label, value) in statusOptions" :key="value" :value="value">
                {{ label }}
              </option>
            </select>
            <div v-if="form.errors.status" class="text-red-500">{{ form.errors.status }}</div>
          </div>
          <!-- Botones -->
          <div class="flex justify-between mt-10">
            <BmButton @click="router.visit('/tables')" type="secondary" size="lg">Cancelar</BmButton>
            <BmButton @click="submit" size="lg">Guardar Cambios</BmButton>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>
