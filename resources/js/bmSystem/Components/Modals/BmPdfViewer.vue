<script>
import {defineComponent} from 'vue'
import {Modal, Spinner} from "flowbite-vue";
import { VuePDF, usePDF } from '@tato30/vue-pdf'
export default defineComponent({
    name: "BmPdfViewer",
    components: {Spinner, VuePDF, Modal},
    props:{
        item: Object,
    },
    data: function () {
        return{
            dialog: true,
            pdf: null,
            pages: null,
            loaded: null,
        }
    },
    watch:{
        dialog(val){
            val || this.close();
        }
    },
    methods: {
        close() {
            this.$emit('close', false);
        },
        onLoaded(){
            setTimeout(() => {
                this.loaded = true;
            }, 2000);
        }
    },
    mounted() {
        const { pdf, pages } = usePDF(`${this.item.url}`)
        this.pdf = pdf;
        this.pages = pages;
    }
})
</script>

<template>
    <Modal size="6xl" v-if="dialog" @close="close">
        <template #header>
            <div class="flex items-center text-base text-bmGrey-500">
                <span class="font-medium text-bmBlue px-4">Documento:</span> {{ item.name }}
                <span class="absolute right-20 bg-bmCyan-200 rounded-full px-3">
                    <small class="text-bmCyan-500">
                        {{pages}} páginas
                    </small>
                </span>
            </div>
        </template>
        <template #body>
            <div class="max-h-[73vh] overflow-y-auto px-0">
                <div v-if="!loaded">
                    <div class="h-96 flex w-full items-center justify-center flex-col">
                        <spinner size="12" />
                        <p class="text-bmGrey-500 font-bold text-xl">
                            cargando...
                        </p>
                    </div>
                </div>
                <div :class="{'bg-bmGrey-500 p-3':loaded}">
                    <div v-for="page in pages" :key="page" class=" my-2 shadow-md">
                        <VuePDF :pdf="pdf" :page="page" fit-parent @loaded="onLoaded" :class="{'hidden__doc':!loaded}" />
                        <!--<div class="flex justify-center items-center py-0.5 bg-white">{{ page }}</div>-->
                    </div>
                </div>
            </div>
        </template>
    </Modal>

</template>

<style scoped>
.hidden__doc{
    display: none !important;
}

</style>
