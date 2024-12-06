<script>
import {defineComponent} from 'vue'

export default defineComponent({
    name: "BmBadge",
    props:{
        type:{
            type: String,
            default: "success",
        },
        text:{
            type: String,
            default: '',
        }
    },
    data: function () {
        return{
            typeBadgeClass:{
                success: 'bg-success-100 text-success-500',
                danger: 'bg-danger-100 text-danger-500',
                warning: 'bg-warning-100 text-warning-500',
                info: 'bg-info-100 text-info-500',
            },
            typeBadgeCicleClass:{
                success: 'bg-success-500',
                danger: ' bg-danger-500',
                warning: ' bg-warning-500',
                info: ' bg-info-500',
            },
        }
    }
})
</script>

<template>
 <span
     :class="typeBadgeClass[type]"
     class="px-3 py-1.5 inline-flex items-center gap-1 rounded-full text-xs font-semibold"
        >
    <span
        :class="typeBadgeCicleClass[type]"
        class="h-2 w-2 rounded-full"/>
    {{ text }}
  </span>
</template>

<style scoped>

</style>
