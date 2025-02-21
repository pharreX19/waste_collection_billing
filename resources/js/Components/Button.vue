<template>
    <button
        :disabled="disabled || loading"
        :type="type"
        :class="buttonClasses"
        @click="handleClick"
    >
        <span class="flex flex-row justify-center items-center"
            ><ArrowPathIcon
                class="size-5 text-white animate-spin ml-2"
                v-if="loading"
            />{{ computedLabel }}</span
        >
    </button>
</template>

<script setup>
import { ArrowPathIcon } from "@heroicons/vue/24/outline";
import { computed } from "vue";

const props = defineProps({
    loading: {
        type: Boolean,
        required: false,
        default: false,
    },
    disabled: {
        type: Boolean,
        required: false,
        default: false,
    },
    variant: {
        type: String,
        default: "submit",
        validator: (value) => ["submit", "cancel", "danger"].includes(value),
    },
    label: {
        type: String,
    },
    type: {
        type: String,
        default: "button",
    },
});

const emit = defineEmits(["click"]);

const computedLabel = computed(
    () =>
        props.label ||
        (props.variant === "submit" ? "ރައްކާ ކުރައްވާ" : "ކެންސަލް ކުރައްވާ")
);

const buttonClasses = computed(() => ({
    "rounded-md  px-3 py-2 text-sm font-semibold  focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 ": true,
    "bg-indigo-600 hover:bg-indigo-500 focus-visible:outline-indigo-600 text-white shadow-sm":
        props.variant === "submit",
    "text-sm/6 text-gray-900": props.variant === "cancel",
    "bg-red-600 hover:bg-red-500 focus-visible:outline-red-600":
        props.variant === "danger",
    "opacity-50 cursor-not-allowed": props.disabled,
}));

const handleClick = (event) => {
    if (!props.disabled) {
        emit("click", event);
    }
};
</script>

<style lang="scss" scoped></style>
