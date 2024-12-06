<script>
import {defineComponent} from 'vue'

export default defineComponent({
    name: "BmCardContainer",
    props:{
        minHeight: {
            type: String,
            default: "250px",
        },
        headerBg: {
            type: String,
            default: 'bmCyan'
        },
        headerText: {
            type: String,
            default: 'white',
        },
        left:{
            type: Boolean,
            default: false
        }
    }
})
</script>

<template>
    <div>
        <div
            :class="[
                `border-${headerBg} bg-${headerBg} text-${headerText}`,
                left ? 'justify-start pl-5': 'justify-center'
            ]"
            class="w-full border  rounded-t-2xl py-3 flex  items-center">
            <slot name="head"/>
        </div>
        <div
            :class="`min-h-[${minHeight}]`"
            class="w-full border-x border-b border-bmGrey-200 border-t-bmCyan-200 rounded-b-2xl">
            <slot name="body"/>
        </div>
    </div>
</template>

<style scoped>

</style>
