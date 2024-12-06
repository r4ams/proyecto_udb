<script>
import {defineComponent} from 'vue'

export default defineComponent({
    name: "BmTab",
    props: {
        name: {
            required: true
        },
        selected: {
            default: false
        },
        title: {
            default: false
        },
        show:{
            type: Boolean,
        }
    },
    data() {
        return {
            isActive: false
        };
    },
    watch: {

    },
    mounted() {
        this.isActive = this.selected;

    },
    created() {
        const existingTab = this.$parent.tabs.find((tab) => tab.name === this.name);
        if (!existingTab) {
            this.$parent.tabs.push(this);
        }
    },
})
</script>

<template>
    <div class='tab' v-show='isActive'>
        <slot></slot>
    </div>
</template>

<style scoped>

</style>
