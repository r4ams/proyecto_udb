<template>
  <button
    :id="id"
    class="relative px-4 py-2.5 text-base focus:outline-none rounded-full"
    :class="[ disabled ? typeButtonClass[`${type}Disabled`] : typeButtonClass[type], sizeButtonClass[size]]"
    :disabled="disabled"
    :type="typeNative"
  >
<!--      @click="$emit('click')"-->
    <div
      class="flex items-center justify-center font-medium"
    >
      <i v-show="icon !== null" class="icon mr-2" :class="[icon, colorIcon]" />
      <slot />
    </div>
    <div
      v-if="loading"
      :class="typeButtonClass[type]"
      class="absolute h-full w-full rounded-full flex items-center justify-center top-0 left-0 cursor-progress"
    >
        <spinner color="white" size="6" />
    </div>
  </button>
</template>
<script>
import { Spinner } from 'flowbite-vue'
export default {
  name: "BmButton",
  components:{
    Spinner,
  },
  props: {
    id: {
      type: String,
      default: "",
    },
    icon: {
      type: String,
      default: null,
    },
    colorIcon: {
      type: String,
      default: "bg-dark",
    },
    size: {
      type: String,
      default: 'md',
    },
    loading: {
      type: Boolean,
      default: false,
    },
    block: {
      type: Boolean,
      default: false,
    },
    disabled: {
      type: Boolean,
      default: false,
    },
    typeNative: {
      type: String,
      default: "button",
    },
    type: {
      type: String,
      default: "primary",
    },
    iconLeft: {
      type: String,
      default: null,
    },
  },
  data: function () {
        return{
            typeButtonClass:{
                primary: 'bg-bmBlue text-white',
                primaryDisabled: 'bg-bmBlue/[0.6] text-white cursor-not-allowed',
                secondary: 'bg-white text-bmBlue border-bmBlue border',
                secondaryDisabled: 'bg-white text-bmBlue/[0.6] border-bmBlue/[0.6] border cursor-not-allowed',
                cyan: 'bg-white text-bmCyan border-bmCyan border',
                grey: 'bg-white text-bmGrey border-bmGrey border',
            },
            sizeButtonClass:{
                xs: 'w-20',
                md: 'w-44',
                lg: 'w-60',
                block: 'w-full',
            },
        }
    }
};
</script>
