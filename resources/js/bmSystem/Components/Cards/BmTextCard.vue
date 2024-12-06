<script>
import {defineComponent} from 'vue'

export default defineComponent({
    name: "BmTextCard",
    props:{
        title:{
            type: String,
            default: ''
        },
    }
})
</script>

<template>
    <div class="py-3">
        <div class="w-full mx-auto px-3">
            <!-- Generar estilos de sombra :  https://manuarora.in/boxshadows -->
            <div class="bg-bmCyan-50 overflow-hidden rounded-lg">
                <div class="p-6 text-bmGrey-600 text-left pr-4">
                    <p class="text-xl font-bold text-b">
                        {{title}}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
