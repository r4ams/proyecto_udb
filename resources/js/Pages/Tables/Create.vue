<script setup>
  import AppLayout from '@/Layouts/AppLayout.vue';
  import { useForm, router } from "@inertiajs/vue3";
  import InputNew from '@/bmSystem/Components/Inputs/BmInput.vue';
  import BmButton from "@/bmSystem/Components/Buttons/BmButton.vue";

  const form = useForm({
    number: null, // Número de la mesa
    capacity: null, // Capacidad de personas
  });

  const submit = () => {
    form.post(route('tables.store'), {
      errorBag: 'tableErrors',
      preserveScroll: true,
    });
  };
</script>

<template>
  <AppLayout title="Crear Mesa">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
      <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
        <div class="mt-8 text-2xl">
          <p class="text-2xl font-bold">Crear Mesa</p>
          <p class="text-sm">Completa la información para registrar una nueva mesa</p>
          <br>
        </div>

        <form @submit.prevent="submit">
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

          <!-- Capacidad de la Mesa -->
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

          <!-- Botones -->
          <div class="flex justify-between mt-10">
            <BmButton @click="router.visit('/tables')" type="secondary" size="lg">Cancelar</BmButton>
            <BmButton @click="submit" size="lg">Guardar Mesa</BmButton>
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
