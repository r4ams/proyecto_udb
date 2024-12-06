<script>
import {defineComponent} from 'vue'

export default defineComponent({
    name: "DefaultHeader",
    props:{
        title:{
            type: String,
            default: ''
        },
        text:{
            type: String,
            default: ''
        }
    }
})
</script>

<template>
    <div>
        <p class="text-xl text-bmGrey-500">{{ title }}</p>
        <p v-show="text" class="text-sm text-bmGrey-500 pt-2">{{ text }}</p>
    </div>
</template>

<style scoped>

</style>
