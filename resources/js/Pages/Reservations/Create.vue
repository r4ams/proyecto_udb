<script setup>
  import { ref } from 'vue';
  import AppLayout from '@/Layouts/AppLayout.vue';
  import { useForm, router } from "@inertiajs/vue3";
  import InputNew from '@/bmSystem/Components/Inputs/BmInput.vue';
  import BmButton from "@/bmSystem/Components/Buttons/BmButton.vue";

  // Props que se pasan desde el controlador
  defineProps({
    tables: Array,
  });

  const form = useForm({
    customer_name: '',
    table_id: '',
    reservation_date: '',
    phone: '',
  });

  const submit = () => {
    // Validar y enviar el formulario
    form.post(route('reservations.store'), {
      errorBag: 'reservationErrors',
      preserveScroll: true,
    });
  };
</script>

<template>
  <AppLayout title="Crear Reserva">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
      <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
        <div class="mt-8 text-2xl">
          <p class="text-2xl font-bold">Crear Reserva</p>
          <p class="text-sm">Completa la información para realizar una nueva reserva.</p>
          <br>
        </div>

        <form @submit.prevent="submit">
          <!-- Nombre del Cliente -->
          <div class="py-2">
            <InputNew
              v-model="form.customer_name"
              block
              id="customer_name"
              name="customer_name"
              type="text"
              label="Nombre del Cliente"
              placeholder="Ej. Juan Pérez"
            />
            <div v-if="form.errors?.customer_name" class="text-red-500">{{ form.errors.customer_name }}</div>
          </div>

          <div class="py-2">
            <InputNew
              v-model="form.phone"
              block
              id="phone"
              name="phone"
              type="text"
              label="Teléfono del Cliente"
            />
            <div v-if="form.errors?.phone" class="text-red-500">{{ form.errors.phone }}</div>
          </div>

          <!-- Mesa -->
          <div class="py-2">
            <label for="table_id" class="block text-gray-700">Selecciona una Mesa</label>
            <select
              v-model="form.table_id"
              id="table_id"
              name="table_id"
              class="w-full p-2.5 border rounded-lg text-gray-700"
            >
              <option disabled value="">Selecciona una mesa</option>
              <option v-for="table in tables" :value="table.id" :key="table.id">
                Mesa #{{ table.number }} - Capacidad: {{ table.capacity }} personas
              </option>
            </select>
            <div v-if="form.errors?.table_id" class="text-red-500">{{ form.errors.table_id }}</div>
          </div>

          <!-- Hora de la Reserva -->
          <div class="py-2">
            <InputNew
              v-model="form.reservation_date"
              block
              id="reservation_date"
              name="reservation_date"
              type="datetime-local"
              label="Hora de la Reserva"
            />
            <div v-if="form.errors?.reservation_date" class="text-red-500">{{ form.errors.reservation_date }}</div>
          </div>

          <!-- Botones -->
          <div class="flex justify-between mt-10">
            <BmButton @click="router.visit('/reservations')" type="secondary" size="lg">Cancelar</BmButton>
            <BmButton @click="submit" size="lg">Guardar Reserva</BmButton>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
form {
  margin-top: 20px;
}
</style>
