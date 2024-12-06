<script setup>
  import { ref, onMounted } from 'vue'
  import AppLayout from '@/Layouts/AppLayout.vue';
  import Welcome from '@/Components/Welcome.vue';
  import BmButton from '@/bmSystem/Components/Buttons/BmButton.vue';
  import AlertSuccessful from '@/bmSystem/Components/Forms/AlertSuccessful.vue';
  import { 
    Badge,
    TheCard,
    Modal
  } from 'flowbite-vue';
</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
      </h2>
    </template>
    <AlertSuccessful class="my-6" v-show="$page.props.flash.successful" :message="$page.props.flash.successful"/>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden sm:rounded-lg">
          <div class="grid grid-cols-2 gap-2">
            <TheCard
              img-alt="Desk"
              img-src="/images/agregar-pacientes.jpeg"
              variant="horizontal"
              class="hover:bg-white"
            >
              <div class="p-5">
                <div class="text-center">
                  <bm-button @click="createOrder()" size="lg">
                    Pedidos
                  </bm-button>
                </div>
              </div>
            </TheCard>
            <TheCard
              img-alt="Desk"
              img-src="/images/reservas.png"
              variant="horizontal"
              class="hover:bg-white  p-16"
            >
              <div class="p-5">
                <div class="text-center">
                  <bm-button @click="createReservation()" size="lg">
                    Reservas
                  </bm-button>
                </div>
              </div>
            </TheCard>
          </div>  
          <div class="grid grid-cols-2 gap-2 pt-10">
            <TheCard
              img-alt="Desk"
              img-src="/images/menu.png"
              variant="horizontal"
              class="hover:bg-white  p-16"
            >
              <div class="p-5">
                <div class="text-center">
                  <bm-button @click="createMenu()" size="lg">
                    Menú
                  </bm-button>
                </div>
              </div>
            </TheCard>
            <TheCard
              img-alt="Desk"
              img-src="/images/mesas.png"
              variant="horizontal"
              class="hover:bg-white  p-16"
            >
              <div class="p-5">
                <div class="text-center">
                  <bm-button @click="createTable()" size="lg">
                    Mesas
                  </bm-button>
                </div>
              </div>
            </TheCard>
          </div> 
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import {Inertia} from "@inertiajs/inertia";

export default {
  components: {
  },
  props: {
      records: Object,
      types: Object
  },
  data(){
    return{
      flash: this.$page.props.flash,
    }
  },
  computed: {
    // Accede a los flash messages de Laravel a través de Inertia
    flashMessage() {
      console.log(this.$page.props.flash.successful);
      
      return this.$page.props.flash.successful || '';
    } 
  },
  methods:{
    createOrder(){
      this.$inertia.visit('/orders')
    },
    createReservation(){
      this.$inertia.visit('/reservations')
    },
    createTable(){
      this.$inertia.visit('/tables')
    },
    createMenu(){
      this.$inertia.visit('/menus')
    },
    closeAlert() {
      this.flash.successful = '';
    },
  },
}
</script>
