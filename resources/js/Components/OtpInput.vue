<template>
    <div class="flex flex-row-reverse justify-center gap-2 mt-10 mb-3">
        <input
            v-for="(digit, index) in otp"
            :key="index"
            :id="`otp-${index}`"
            v-model="otp[index]"
            type="text"
            class="size-12 rounded-md border-gray-300 focus:border-indigo-600 text-center text-lg caret-white"
            maxlength="1"
            autofocus
            @input="handleInput($event, index)"
            @keydown="handleKeyDown($event, index)"
            @paste="handlePaste"
        />
    </div>
    <div class="text-xs text-red-600 mt-1 text-center" v-if="errors.otp">
        {{ errors.otp }}
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";

const props = defineProps({
    errors: {
        type: Object,
    },
    modelValue: Array,
});

onMounted(() => {
    document.getElementById("otp-0").focus();
});

const emit = defineEmits(["update:modelValue"]);
const otp = ref(props.modelValue);
// const otp = ref(new Array(6).fill(""));

const handleInput = (event, index) => {
    const value = event.target.value;

    if (/^\d$/.test(value)) {
        otp.value[index] = value;
        emit("update:modelValue", otp.value);
        if (index < 5) {
            document.getElementById(`otp-${index + 1}`).focus();
        }
    } else {
        otp.value[index] = "";
    }
};

const handleKeyDown = (event, index) => {
    if (event.key === "Backspace" && !otp.value[index] && index > 0) {
        document.getElementById(`otp-${index - 1}`).focus();
    }
};

const handlePaste = (event) => {
    event.preventDefault();
    const pasteData = event.clipboardData.getData("text").trim().slice(0, 6);
    if (/^\d{1,6}$/.test(pasteData)) {
        pasteData
            .split("")
            .reverse()
            .forEach((char, i) => {
                otp.value[i] = char;
            });
        emit("update:modelValue", otp.value);
        document
            .getElementById(`otp-${Math.min(5, pasteData.length - 1)}`)
            .focus();
    }
};
</script>

<style scoped></style>
