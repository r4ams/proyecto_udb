<script setup>
  import AppLayout from '@/Layouts/AppLayout.vue';
  import { useForm, router } from "@inertiajs/vue3";
  import InputNew from '@/bmSystem/Components/Inputs/BmInput.vue';
  import BmButton from "@/bmSystem/Components/Buttons/BmButton.vue";

  // Recibimos las props de orden, mesas y menú desde el controlador
  const props = defineProps({
    order: Object,
    tables: Array,
    menuItems: Array
  });

  // Inicializamos el formulario con los datos de la orden
  const form = useForm({
    table_id: props.order.table_id || '',
    customer_name: props.order.customer_name || '',
    foods: props.order.details
      .filter(detail => detail.menu.type === 'food')
      .map(detail => ({ item: detail.menu.id, quantity: detail.quantity })) || [{ item: '', quantity: 1 }],
    drinks: props.order.details
      .filter(detail => detail.menu.type === 'drink')
      .map(detail => ({ item: detail.menu.id, quantity: detail.quantity })) || [{ item: '', quantity: 1 }],
    comments: props.order.comments || '',
  });

  const addFood = () => form.foods.push({ item: '', quantity: 1 });
  const addDrink = () => form.drinks.push({ item: '', quantity: 1 });
  const removeFood = (index) => form.foods.splice(index, 1);
  const removeDrink = (index) => form.drinks.splice(index, 1);

  const submit = () => {
    form.put(route('orders.update', props.order.id), {
      errorBag: 'orderErrors',
      preserveScroll: true,
    });
  };
</script>

<template>
  <AppLayout title="Editar Orden">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
      <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
        <div class="mt-8 text-2xl">
          <p class="text-2xl font-bold">Editar Orden</p>
          <p class="text-sm">Actualiza la información de la orden</p>
          <br>
        </div>

        <form @submit.prevent="submit">
          <div class="grid grid-cols-2 gap-4">
            <!-- Número de mesa -->
            <div class="py-2">
              <select
                v-model="form.table_id"
                class="w-full p-2.5 border rounded-lg text-gray-700"
                id="table_number"
                name="table_number"
              >
                <option disabled value="">Selecciona una mesa</option>
                <option v-for="table in props.tables" :key="table.id" :value="table.id">
                  Mesa #{{ table.number }} - Capacidad: {{ table.capacity }} personas
                </option>
              </select>
              <div v-if="form.errors.table_id" class="text-red-500">{{ form.errors.table_id }}</div>
            </div>

            <!-- Nombre del cliente -->
            <div class="py-2">
              <InputNew
                v-model="form.customer_name"
                block
                id="customer_name"
                name="customer_name"
                label="Nombre del Cliente"
              />
              <div v-if="form.errors.customer_name" class="text-red-500">{{ form.errors.customer_name }}</div>
            </div>
          </div>

          <!-- Alimentos -->
          <div class="mt-4">
            <p class="text-lg font-semibold">Alimentos</p>
            <div v-for="(food, index) in form.foods" :key="index" class="grid grid-cols-3 gap-4 py-4">
              <select
                v-model="food.item"
                class="w-full p-2.5 border rounded-lg text-gray-700"
              >
                <option disabled value="">Selecciona un alimento</option>
                <option v-for="foodItem in props.menuItems.filter(item => item.type === 'food')" 
                        :key="foodItem.id" :value="foodItem.id">
                  {{ foodItem.name }} - ${{ foodItem.price }}
                </option>
              </select>
              <InputNew
                v-model="food.quantity"
                block
                id="quantity"
                name="quantity"
                type="number"
                label="Cantidad"
              />
              <BmButton @click.prevent="removeFood(index)" type="secondary">Eliminar</BmButton>
            </div>
            <BmButton @click.prevent="addFood" class="mt-2">Agregar Alimento</BmButton>
          </div>

          <!-- Bebidas -->
          <div class="mt-4">
            <p class="text-lg font-semibold">Bebidas</p>
            <div v-for="(drink, index) in form.drinks" :key="index" class="grid grid-cols-3 gap-4 py-4">
              <select
                v-model="drink.item"
                class="w-full p-2.5 border rounded-lg text-gray-700"
              >
                <option disabled value="">Selecciona una bebida</option>
                <option v-for="drinkItem in props.menuItems.filter(item => item.type === 'drink')" 
                        :key="drinkItem.id" :value="drinkItem.id">
                  {{ drinkItem.name }} - ${{ drinkItem.price }}
                </option>
              </select>
              <InputNew
                v-model="drink.quantity"
                block
                id="drink_quantity"
                name="drink_quantity"
                type="number"
                label="Cantidad"
              />
              <BmButton @click.prevent="removeDrink(index)" type="secondary">Eliminar</BmButton>
            </div>
            <BmButton @click.prevent="addDrink" class="mt-2">Agregar Bebida</BmButton>
          </div>

          <!-- Comentarios -->
          <div class="mt-4">
            <InputNew
              v-model="form.comments"
              block
              id="comments"
              name="comments"
              label="Comentarios Adicionales"
            />
            <div v-if="form.errors.comments" class="text-red-500">{{ form.errors.comments }}</div>
          </div>

          <!-- Botones -->
          <div class="flex justify-between mt-10">
            <BmButton @click="router.visit('/orders')" type="secondary" size="lg">Cancelar</BmButton>
            <BmButton @click="submit" size="lg">Actualizar Orden</BmButton>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>
