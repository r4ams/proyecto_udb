<template>
    <div class="relative">
        <div class="relative flex items-center inputBox">
            <input
                ref="input"
                class="w-full p-2.5 border border-bmBlue rounded-3xl outline-none text-gray-700 text-sm"
                :id="id"
                :name="name"
                :type="type"
                :value="modelValue"
                @input="updateInput"
                placeholder=" "
                autocomplete="off"
            />
            <span v-if="label" class="absolute left-4 p-2.5 pointer-events-none text-sm  text-gray-700 transition duration-300 ease-in-out">{{ label }}</span>
        </div>
    </div>
</template>

<script>
export default {
    name: "BmInput",
    props: {
        id: {
            type: String,
            default: "",
        },
        name: {
            type: String,
            default: "",
        },
        label: {
            type: String,
            default: "",
        },
        modelValue: {
            type: [String, Number],
            default: "",
        },
        type: {
            type: String,
            default: "text",
        }
    },
    methods: {
        updateInput(event) {
            this.$emit("update:modelValue", event.target.value);
        }
    }
};
</script>
<style scoped>
.inputBox input:focus ~ span,
.inputBox input:not(:placeholder-shown) + span
{
    transform: translateX(0px) translateY(-20px);
    font-size: 0.7rem;
    padding: 0 10px;
    background: #fff;
}

*:disabled ~ span {
    transform: translateX(0px) translateY(-20px);
    font-size: 0.7rem;
    padding: 0 10px;
    background: #fff;
}
</style>
