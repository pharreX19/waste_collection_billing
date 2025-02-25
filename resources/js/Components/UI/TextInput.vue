<template>
    <div>
        <label :for="label" class="block text-sm/6 font-medium text-gray-900">{{
            label
        }}</label>
        <div :class="[label ? 'mt-2' : '']">
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
                :step="step"
                @input="convertToLatin"
                :autocomplete="autoComplete"
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
import { tkGetChar } from "../../utils/latinMapping";

const props = defineProps({
    lang: {
        type: String,
    },
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
    step: {
        type: String,
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
    autoComplete: {
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

const convertToLatin = (event) => {
    if (props.lang !== "dv") return;
    let inputText = event.target.value;
    let convertedText = "";

    for (let char of inputText) {
        convertedText += tkGetChar(char) || char;
    }

    emit("update:modelValue", convertedText);
};
</script>

<style lang="scss" scoped></style>
