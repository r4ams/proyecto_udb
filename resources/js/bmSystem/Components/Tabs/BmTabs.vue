<script>
import {defineComponent} from 'vue'
import BlueIconArrowBack from "@/Icons/Generales/blueIconArrowBack.vue";
import BlueIconArrowForward from "@/Icons/Generales/blueIconArrowForward.vue";

export default defineComponent({
    name: "BmTabs",
    components: {BlueIconArrowForward, BlueIconArrowBack},
    props: {
        mode: {
            type: String,
            default: 'light'
        },
        list:{
            type: Array,
            default: [],
        },
        expedientMode: {
            type: Boolean,
            default: false,
        }
    },
    data() {
        return {
            initialTabs: [], // Nueva propiedad
            tabs: [], // Propiedad original
            container: null,
            desbordado: false,
            arrowBackClass: "fill-bmGrey-200",
            arrowForwardClass: "fill-bmBlue",
        };
    },

    watch:{
        list:{
            handler(){
                //this.updateTabsByList();
            },
            deep: true
        },
    },
    mounted() {
        window.addEventListener('resize', this.updateContainerSize);
        this.$nextTick(() => {
            this.updateContainerSize();
            this.handleInitialTab();
            this.initialTabs = this.tabs; // Guarda una copia de la propiedad original
            this.updateTabsByList(); // Filtra las pestañas según la lista inicial
        });
    },
    created() {

    },
    methods: {
        updateTabsByList() {
            this.tabs = this.initialTabs.filter(tab => this.list.includes(tab.name));
            this.updateContainerSize();
            /*
            this.handleInitialTab();*/
        },
        handleInitialTab(){
            let initialTab = this.tabs.slice().find((item) => item.isActive);
            this.$emit('select-tab',initialTab);
        },
        selectTab(selectedTab) {
            this.tabs.forEach((tab) => {
                tab.isActive = tab.name === selectedTab.name;
            });
            this.scrollToTab(selectedTab);
            this.$emit('select-tab',selectedTab);
        },
        scrollToTab(selectedTab) {
            if (!this.container) return;

            const tabElement = this.container.querySelector(`[data-tab="${selectedTab.name}"]`);
            if (tabElement) {
                //this.updateContainerSize();
                this.updateArrowClasses(tabElement);
                this.container.scrollTo({
                    left: tabElement.offsetLeft - this.container.clientWidth / 2 + tabElement.clientWidth / 2,
                    behavior: 'smooth',
                });
            }
        },
        updateArrowClasses(tabElement) {
            if (!this.container) return;

            const scrollOffset = this.container.clientWidth / 2;
            const tabLeftPosition = tabElement.offsetLeft + tabElement.clientWidth / 2;

            // cerca del inicio
            if (tabLeftPosition < scrollOffset) {
                this.arrowBackClass = "fill-bmGrey-200";
                this.arrowForwardClass = "fill-bmBlue";
            }
            // cerca del final
            else if (tabLeftPosition > this.container.scrollWidth - scrollOffset) {
                this.arrowBackClass = "fill-bmBlue";
                this.arrowForwardClass = "fill-bmGrey-200";
            }
            // ni del inicio o del final
            else {
                this.arrowBackClass = "fill-bmBlue";
                this.arrowForwardClass = "fill-bmBlue";
            }
        },
        updateContainerSize() {
            this.container = this.$refs.container;
            this.desbordado = this.container.scrollWidth > this.container.clientWidth;
        },
        scrollToStart() {
            if (!this.container) return;

            this.arrowBackClass = "fill-bmGrey-200";
            this.arrowForwardClass = "fill-bmBlue";

            this.container.scrollTo({
                left: 0,
                behavior: 'smooth',
            });
        },
        scrollToEnd() {
            if (!this.container) return;

            this.arrowBackClass = "fill-bmBlue";
            this.arrowForwardClass = "fill-bmGrey-200";

            this.container.scrollTo({
                left: this.container.scrollWidth - this.container.clientWidth,
                behavior: 'smooth',
            });
        },
        checkInList(tab){
            return this.list.includes(tab.name);
        }
    },
    beforeUnmount() {
        window.removeEventListener('resize', this.updateContainerSize);
    },
})
</script>

<template>
    <hr>
    <div class="relative">
        <div v-if="desbordado" class="arrow left-0" @click="scrollToStart">
            <blue-icon-arrow-back :class="arrowBackClass"/>
        </div>
        <div v-if="desbordado" class="arrow right-0" @click="scrollToEnd">
            <blue-icon-arrow-forward :class="arrowForwardClass"/>
        </div>
        <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200" :class="{'px-5': desbordado}">
            <div class="overflow-hidden" ref="container">
                <ul class="flex -mb-px">
                    <li v-for="tab in tabs" class="mr-2" @click="selectTab(tab)">
                        <div class="relative">
                            <a :class="[tab.isActive ? 'bm-tab__active' : 'bm-tab__default', 'whitespace-nowrap']" :data-tab="tab.name">
                            <span class="mr-4">
                                {{ tab.title }}
                            </span>
                            </a>
                            <div v-show="expedientMode"
                                 class="absolute top-3 right-3 w-3 h-3  rounded-full"
                                 :class="checkInList(tab)? 'bg-bmCyan': 'bg-bmGrey-300'"
                            />
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="pt-5">
            <slot></slot>
        </div>
    </div>
</template>

<style scoped>

.arrow {
    @apply absolute top-3  text-xl cursor-pointer;
}
</style>
