<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm, router } from "@inertiajs/vue3";
import InputNew from '@/bmSystem/Components/Inputs/BmInput.vue';
import BmButton from "@/bmSystem/Components/Buttons/BmButton.vue";

const props = defineProps(['menuItem']);

const form = useForm({
  name: props.menuItem.name,
  description: props.menuItem.description,
  price: props.menuItem.price,
  type: props.menuItem.type,
});

const submit = () => {
  form.put(route('menus.update', props.menuItem.id), {
    preserveScroll: true,
  });
};
</script>

<template>
  <AppLayout title="Editar Ítem de Menú">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
      <div class="p-6 bg-white border-b border-gray-200">
        <h1 class="text-2xl font-bold">Editar Ítem de Menú</h1>
        <form @submit.prevent="submit" class="mt-6">
          <!-- Campos del formulario reutilizados -->
          <div class="py-2">
            <InputNew
              v-model="form.name"
              block
              id="name"
              name="name"
              type="text"
              label="Nombre del Ítem"
              placeholder="Ej. Hamburguesa"
            />
            <div v-if="form.errors.name" class="text-red-500">{{ form.errors.name }}</div>
          </div>

          <!-- Descripción -->
          <div class="py-2">
            <textarea
              v-model="form.description"
              class="w-full p-2.5 border rounded-lg text-gray-700"
              id="description"
              name="description"
              placeholder="Descripción (opcional)"
              rows="4"
            ></textarea>
            <div v-if="form.errors.description" class="text-red-500">{{ form.errors.description }}</div>
          </div>

          <!-- Precio -->
          <div class="py-2">
            <InputNew
              v-model="form.price"
              block
              id="price"
              name="price"
              type="number"
              step="0.01"
              label="Precio"
              placeholder="Ej. 9.99"
            />
            <div v-if="form.errors.price" class="text-red-500">{{ form.errors.price }}</div>
          </div>

          <!-- Tipo -->
          <div class="py-2">
            <label for="type" class="block text-gray-700">Tipo</label>
            <select
              v-model="form.type"
              id="type"
              name="type"
              class="w-full p-2.5 border rounded-lg text-gray-700"
            >
              <option disabled value="">Selecciona un tipo</option>
              <option value="food">Comida</option>
              <option value="drink">Bebida</option>
            </select>
            <div v-if="form.errors.type" class="text-red-500">{{ form.errors.type }}</div>
          </div>
          <!-- Otros campos similares -->
          <div class="flex justify-between mt-10">
            <BmButton @click="router.visit(route('menus.index'))" type="secondary" size="lg">Cancelar</BmButton>
            <BmButton @click="submit" size="lg">Guardar Cambios</BmButton>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>
