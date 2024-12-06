<template>
    <div>
        <div
            :id="idNative"
            class="relative"
            :class="{
          'cursor-not-allowed': disabled,
          'border-red-500': error !== null,
          'w-full': block,
          'w-44': size === 'is-medium',
          'w-60': size === 'is-large',
          'w-24': size === 'is-small',
        }"
        >
            <div>
                <span class="rounded-md shadow-sm">
            <div
                :id="`${idNative}-select`"
                class="flex items-center w-full h-12 my-1 border border-transparent inputBox2"
                role="select"
                aria-haspopup="true"
                aria-expanded="true"
                @click="show = !show"
            >
              <input
                  v-model="text"
                  class="w-full p-2.5 border border-bmBlue rounded-3xl outline-none text-gray-700 text-sm cursor-pointer"
                  :name="name"
                  :disabled="disabled"
                  required
                  @input="onInput"
                  @click.stop.prevent="show = true"
              />
              <span
                  class="absolute left-1 p-2.5 pointer-events-none text-sm text-gray-700 transition duration-150"
              >{{ label }}</span
              >
              <i
                  v-if="!show"
                  class="absolute right-0 mr-4 bg-gray-500 cursor-pointer icon chevron-up"
              />
              <i
                  v-else
                  class="absolute right-0 mr-4 bg-gray-500 cursor-pointer icon chevron-down"
              />
            </div>
          </span>
            </div>
            <transition name="dropdown">
                <div
                    v-show="show && !disabled"
                    style="z-index: 300"
                    class="absolute top-12 right-0 w-full mt-1 bg-white rounded-lg shadow-lg"
                >
                    <div
                        class="overflow-x-hidden overflow-y-auto bg-white border rounded-lg box border-bmBlue shadow-xs max-h-96"
                    >
                        <div
                            role="menu"
                            aria-orientation="vertical"
                            aria-labelledby="options-menu"
                            class="w-full"
                        >
                            <a
                                v-for="(item, i) in datos"
                                :key="i"
                                class="block w-full px-4 py-2 leading-5 font-medium focus:bg-gray-100 focus:text-gray-900 cursor-pointer"
                                :class="{
                                    'bg-gray-200 text-bmBlue': item[id] === localValue,
                                }"
                                :role="`item-select-${item[id]}`"
                                @click="(localValue = item[id]),(text = item[itemValue]),setText(true)"
                            >
                                {{ item[itemValue] }}
                            </a>
                            <a
                                v-if="create"
                                :to="link"
                                class="text-center text-gray-800 options bg-bmBlue"
                                @click="goCreate"
                            >
                                {{ textCreate }}
                            </a>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
        <div
            class="flex items-center justify-between px-1 text-sm"
            :class="{
          'text-red-500': error !== null,
        }"
        >
            <div class="flex items-center">
                <i v-if="error" class="mr-1 icon error bg-red-500" />
                {{ error ? error : hint }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
  name: "BmSelect",
  props: {
    idNative: {
      type: String,
      default: undefined,
    },
    name: {
      type: String,
      default: "",
    },
    txtSearch: {
      type: String,
      default: "Buscar",
    },
    itemValue: {
      type: String,
      default: "name",
    },
    search: {
      type: Boolean,
      default: false,
    },
    hint: {
      type: String,
      default: "",
    },
    placeholder: {
      type: String,
      default: "",
    },
    value: {
      type: [String, Number],
      default: null,
    },
    disabled: {
      type: Boolean,
      default: false,
    },
    label: {
      type: String,
      default: "",
    },
    error: {
      type: String,
      default: null,
    },
    id: {
      type: String,
      default: "id",
    },
    items: {
      type: Array,
      default() {
        return [];
      },
    },
    filter: {
      type: String,
      default: "name",
    },
    create: {
      type: Boolean,
      default: false,
    },
    link: {
      type: String,
      default: "",
    },
    textCreate: {
      type: String,
      default: "Crear",
    },
    size: {
      type: String,
      default: null,
    },
    block: {
      type: Boolean,
      default: false,
    },
  },
  data: () => ({
    show: false,
    localValue: "",
    datos: [],
    text: "",
    timer: null,
    loading: false,
  }),
  watch: {
    localValue(value) {
      if (value !== undefined && value.toString().trim() !== "") {
        const ide = Number.isNaN(Number(value)) ? value : Number(value);
        const data = this.items.find((x) => x[this.id] == ide);
        this.text = data ? data[this.itemValue] : "";
      }
      this.$emit("input", value);
      this.$emit("change", value);
    },
    value(value) {
      if (value) {
        this.localValue = value;
      } else {
        this.localValue = "";
        this.text = "";
      }
    },
    items(value) {
      this.datos = value;
    },
  },
  mounted() {
    this.datos = this.items;
    if (this.value) {
      this.localValue = this.value;
      this.$emit("input", this.localValue);
    }
  },
  methods: {
    setText(flag = false) {
      if (this.show && this.text.trim() !== "") {
        // console.log('flag', flag);
        this.$emit("onSearch", "");

        if (flag !== true) {
          // console.log('flag', flag);
          this.text = "";
        }
      }
      this.show = false;
    },
    onInput(e) {
      // console.log('onInput', this.text);
      if (this.search && this.show) {
        this.loading = true;
        if (this.timer !== null) clearTimeout(this.timer);
        this.timer = setTimeout(() => {
          this.loading = false;
          if (this.show) {
            this.$emit("onSearch", e.target.value);
          }
        }, 500);
      }
    },
    goCreate() {
      const routeData = this.$router.resolve({ path: this.link });
      window.open(routeData.href, "_blank");
    },
  },
};
</script>

<style>
.inputBox2 input:focus ~ span,
.inputBox2 input:valid ~ span {
  transform: translateX(15px) translateY(-20px);
  font-size: 0.7rem;
  padding: 0 10px;
  background: #fff;
}
</style>
