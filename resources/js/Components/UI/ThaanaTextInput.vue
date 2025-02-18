<template>
    <label for="name" class="block text-sm/6 font-medium text-gray-900">{{
        label
    }}</label>
    <div class="mt-2">
        {{ value }}
        <ThaanaInput
            type="text"
            :name="name"
            :id="name"
            :disabled="disabled"
            :value="value"
            @update:modelValue="(value) => emit('update:modelValue', value)"
            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
        />
    </div>
    <div class="text-xs text-red-600 mt-2" v-if="errors[name]">
        {{ errors[name] }}
    </div>
</template>

<script setup>
import ThaanaInput from "thaana-keyboard-vue/src/ThaanaInput.vue";
import { ref, watch } from "vue";

const props = defineProps({
    label: {
        type: String,
        required: true,
    },
    name: {
        type: String,
    },
    errors: {
        type: Object,
        required: false,
    },
    modelValue: {
        type: String,
        default: "",
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});

const value = ref(props.modelValue); // Local state

watch(
    () => props.modelValue,
    (newValue) => {
        value.value = newValue;
    }
);

const emit = defineEmits(["update:modelValue"]);
</script>

<style lang="scss" scoped></style>
