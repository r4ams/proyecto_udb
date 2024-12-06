<script>
import {defineComponent} from 'vue'

export default defineComponent({
    name: "BmSimpleCard",
    props:{
        title:{
            type: String,
            default: ''
        },
        count:{
            type: Number,
            count: ''
        }
    }
})
</script>

<template>
    <div class="py-3">
        <div class="w-full mx-auto px-3">
            <!-- Generar estilos de sombra :  https://manuarora.in/boxshadows -->
            <div class="bg-white overflow-hidden  rounded-lg shadow-[0px_4px_8px_1px_#00000024]">
                <div class="p-6 text-bmBlue text-center ">
                    <p class="text-base">
                        {{ title }}
                    </p>
                    <p class="text-4xl font-bold text-b pt-3">
                        {{count}}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
