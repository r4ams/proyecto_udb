<script>
import {defineComponent} from 'vue'
import { Spinner } from 'flowbite-vue'
export default defineComponent({
    name: "BmButtonIcon",
    components:{
        Spinner,
    },
    props:{
        tooltip: {
            type: String,
            default: ""
        },
        large: {
            type: Boolean,
            default: false,
        },
        loading:{
            type: Boolean,
            default: false,
        }
    }
})
</script>

<template>
    <div class="group cursor-pointer relative inline-block text-center fill-bmBlue hover:fill-bmCyan ">
        <button
            class="rounded-full bg-white hover:bg-cyan-100 transition duration-200 p-2 flex justify-center items-center"
            :class="large? 'large': ''"
        >
            <spinner v-if="loading" color="blue" size="4" />
            <slot v-else name="icon" />
        </button>
        <div v-if="tooltip" class="opacity-0 bg-white shadow-md text-bmGrey-500 text-center text-xs rounded-lg py-2 absolute -right-1/2 z-10 group-hover:opacity-100 bottom-full px-3 pointer-events-none">
            {{ tooltip }}
            <svg class="absolute text-black h-2 w-full left-0 top-full" x="0px" y="0px" viewBox="0 0 255 255" xml:space="preserve"><polygon class="fill-white shadow-md" points="0,0 127.5,127.5 255,0"/></svg>
        </div>
    </div>
</template>

<style scoped>

.large {
    @apply w-[50px] h-[50px];
}

</style>
