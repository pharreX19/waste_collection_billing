<template>
    <div>
        <label :for="label" class="block text-sm/6 font-medium text-gray-900">{{
            label
        }}</label>
        <div class="mt-2">
            <select
                :id="name"
                :name="name"
                v-model="selectedValue"
                class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
            >
                <option v-for="option in options" :value="option.id">
                    {{ option.name }}
                </option>
            </select>
        </div>
        <div class="text-xs text-red-600 mt-1" v-if="errors[name]">
            {{ errors[name] }}
        </div>
    </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
    disabled: {
        type: Boolean,
        default: false,
    },
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
        default: {
            registration_no: null,
        },
    },
    modelValue: {
        type: String,
        default: "",
    },
    options: {
        type: Array,
        required: true,
    },
});

const emit = defineEmits(["update:modelValue"]);

const selectedValue = computed({
    get: () => props.modelValue,
    set: (value) => emit("update:modelValue", value),
});
</script>

<style lang="scss" scoped></style>
