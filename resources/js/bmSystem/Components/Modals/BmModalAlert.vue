<script>
import {defineComponent} from 'vue'
import { Modal } from 'flowbite-vue'
import BmButton from "@/bmSystem/Components/Buttons/BmButton.vue";
import BlueIconSuccess from "@/Icons/Generales/blueIconSuccess.vue";
import BlueIconError from "@/Icons/Generales/blueIconError.vue";
import BlueIconInfo from "@/Icons/Generales/blueIconInfo.vue";
export default defineComponent({
    name: "BmModalAlert",
    props:{
      type:{
          type: String,
          default: "success",
      },
      title:{
          type: String,
          default: "",
      },
      text:{
          type: String,
          default: "",
      },
      size:{
        type: String
      }

    },
    components: {
        BlueIconInfo,
        BlueIconError,
        BlueIconSuccess,
        BmButton,
        Modal
    },
    data: function () {
        return{
            dialog: true,
            typeTextClass:{
                success: "text-success-700",
                error: 'text-danger-700',
                info: 'text-info-700',
            },
        };
    },
    watch:{
        dialog(val){
            val || this.close();
        }
    },
    methods:{
      close(){
          this.$emit('close');
      }
    },

})
</script>

<template>
    <Modal :size="size? size:'md'" v-if="dialog" @close="close">
        <template #body>
            <div class="w-full flex items-center justify-center flex-col">
                <blue-icon-success v-if="type==='success'"/>
                <blue-icon-error  v-if="type==='error'"/>
                <blue-icon-info  v-if="type==='info'"/>
                <div class="pt-5">
                    <h1 :class="['font-medium text-xl',`${typeTextClass[type]}`]">
                        {{title}}
                    </h1>
                </div>
                <p class="text-bmGrey-500">
                    {{text}}
                </p>
            </div>
            <div class="flex justify-center py-5">
                <bm-button @click="close">Aceptar</bm-button>
            </div>
        </template>
    </Modal>
</template>

<style scoped>

</style>
