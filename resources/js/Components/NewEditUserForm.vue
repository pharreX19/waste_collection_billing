<template>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div
            class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
        >
            <TransitionChild
                as="template"
                enter="ease-out duration-300"
                enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                enter-to="opacity-100 translate-y-0 sm:scale-100"
                leave="ease-in duration-200"
                leave-from="opacity-100 translate-y-0 sm:scale-100"
                leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            >
                <DialogPanel
                    class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl sm:p-6"
                >
                    <form @submit.prevent="onSubmit">
                        <div class="space-y-12 text-right">
                            <div class="border-b border-gray-900/10 pb-12">
                                <h2
                                    class="text-base/7 font-semibold text-gray-900"
                                >
                                    ސްޓާފްގެ މަޢުލޫމާތު
                                </h2>

                                <div
                                    class="mt-5 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-8"
                                >
                                    <div class="sm:col-span-4">
                                        <label
                                            for="name"
                                            class="block text-sm/6 font-medium text-gray-900"
                                            >ނަން</label
                                        >
                                        <div class="mt-2">
                                            <ThaanaInput
                                                type="text"
                                                name="name"
                                                id="name"
                                                v-model="form.name"
                                                :value="form.name"
                                                :disabled="props.user"
                                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                            />
                                        </div>
                                        <div
                                            class="text-xs text-red-600 mt-1"
                                            v-if="errors.name"
                                        >
                                            {{ errors.name }}
                                        </div>
                                    </div>

                                    <div class="sm:col-span-4">
                                        <label
                                            for="email"
                                            class="block text-sm/6 font-medium text-gray-900"
                                            >އީމެއިލް</label
                                        >
                                        <div class="mt-2">
                                            <input
                                                type="text"
                                                name="email"
                                                id="email"
                                                v-model="form.email"
                                                :disabled="props.user"
                                                dir="ltr"
                                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                            />
                                        </div>
                                        <div
                                            class="text-xs text-red-600 mt-1"
                                            v-if="errors.email"
                                        >
                                            {{ errors.email }}
                                        </div>
                                    </div>

                                    <div class="sm:col-span-4">
                                        <label
                                            for="password"
                                            class="block text-sm/6 font-medium text-gray-900"
                                            >ޕާސްވާރޑް</label
                                        >
                                        <div class="mt-2">
                                            <input
                                                type="password"
                                                name="password"
                                                id="password"
                                                v-model="form.password"
                                                :disabled="props.id"
                                                dir="ltr"
                                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                            />
                                        </div>
                                        <div
                                            class="text-xs text-red-600 mt-1"
                                            v-if="errors.password"
                                        >
                                            {{ errors.password }}
                                        </div>
                                    </div>

                                    <div class="sm:col-span-4">
                                        <label
                                            for="password_confirmation"
                                            class="block text-sm/6 font-medium text-gray-900"
                                            >ޕާސްވާރޑް ކޮންފާރމޭޝަން</label
                                        >
                                        <div class="mt-2">
                                            <input
                                                type="password"
                                                name="password_confirmation"
                                                id="password_confirmation"
                                                v-model="
                                                    form.password_confirmation
                                                "
                                                dir="ltr"
                                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                            />
                                        </div>
                                        <div
                                            class="text-xs text-red-600 mt-1"
                                            v-if="errors.password_confirmation"
                                        >
                                            {{ errors.password_confirmation }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="mt-6 flex items-center justify-start gap-x-6"
                        >
                            <Button @click="onCancel" variant="cancel" />

                            <Button type="submit" variant="submit" />
                        </div>
                    </form>
                </DialogPanel>
            </TransitionChild>
        </div>
    </div>
</template>

<script setup>
import { DialogPanel, TransitionChild } from "@headlessui/vue";
import { useForm } from "@inertiajs/vue3";
import ThaanaInput from "thaana-keyboard-vue/src/ThaanaInput.vue";
import Button from "@/components/Button.vue";

const props = defineProps({
    errors: {
        type: Object,
        required: false,
    },

    user: {
        type: Object,
        required: false,
    },
});

const emit = defineEmits(["submit:form", "cancel:form"]);

const form = useForm({
    name: props.user?.name ?? null,
    email: props.user?.email ?? null,
    password: null,
    password_confirmation: null,
});

const onSubmit = function () {
    emit("submit:form", form);
    if (!props.errors) {
        form.reset();
    }
};

const onCancel = function () {
    emit("cancel:form");
    form.reset();
};
</script>

<style lang="scss" scoped></style>
