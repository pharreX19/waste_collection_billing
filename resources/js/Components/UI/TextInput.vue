<template>
    <div>
        <label :for="label" class="block text-sm/6 font-medium text-gray-900">{{
            label
        }}</label>
        <div class="mt-2">
            <input
                :type="type"
                :name="name"
                :id="name"
                :value="modelValue"
                :disabled="disabled"
                :placeholder="placeholder"
                :dir="dir"
                :maxlength="maxLength"
                :minlength="minLength"
                :pattern="pattern"
                v-model="value"
                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
            />
        </div>
        <div class="text-xs text-red-600 mt-1" v-if="errors[name]">
            {{ errors[name] }}
        </div>
    </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
    type: {
        type: String,
        default: "text",
    },
    pattern: {
        type: String,
    },
    maxLength: {
        type: String,
    },
    minLength: {
        type: String,
    },
    modelValue: {
        type: String,
        // required: true,
        default: "",
    },
    dir: {
        type: String,
        default: "ltr",
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    label: {
        type: String,
        required: true,
    },
    placeholder: {
        type: String,
        required: false,
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
});

const emit = defineEmits(["update:modelValue"]);

const value = computed({
    get: () => props.modelValue,
    set: (value) => emit("update:modelValue", value),
});
</script>

<style lang="scss" scoped></style>
