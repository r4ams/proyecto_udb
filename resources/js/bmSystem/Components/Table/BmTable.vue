<script>
import {defineComponent} from 'vue'
export default defineComponent({
    name: "BmTable",
    props:{
        bgHeader:{
            type: String,
            default: 'bg-bmCyan-50',
        },
        headers:{
            type: Array,
            default: [],
        }
    }
})
</script>

<template>
    <div class="overflow-x-auto rounded-lg border border-gray-200 m-5">
        <table class="w-full border-collapse bg-white text-left text-sm text-bmGrey-500">
            <thead :class="bgHeader">
            <tr>
                <th scope="col" class="px-6 py-4 font-medium text-gray-900" v-for="(header, index) in headers" :key="index">
                    {{ header}}
                </th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                <slot name="body"/>
            </tbody>
        </table>
    </div>
</template>

<style scoped>

</style>
