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
                                    ކެޓަގަރީގެ މަޢުލޫމާތު
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
                                            for="description"
                                            class="block text-sm/6 font-medium text-gray-900"
                                            >ތަފްޞީލު</label
                                        >
                                        <div class="mt-2">
                                            <input
                                                type="text"
                                                name="description"
                                                id="description"
                                                v-model="form.description"
                                                dir="ltr"
                                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                            />
                                        </div>
                                        <div
                                            class="text-xs text-red-600 mt-1"
                                            v-if="errors.description"
                                        >
                                            {{ errors.description }}
                                        </div>
                                    </div>

                                    <div class="sm:col-span-4">
                                        <label
                                            for="service_fee"
                                            class="block text-sm/6 font-medium text-gray-900"
                                            >މަހު ފީ</label
                                        >
                                        <div class="mt-2">
                                            <input
                                                type="number"
                                                name="service_fee"
                                                id="service_fee"
                                                v-model="form.service_fee"
                                                dir="ltr"
                                                step="0.01"
                                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                            />
                                        </div>
                                        <div
                                            class="text-xs text-red-600 mt-1"
                                            v-if="errors.service_fee"
                                        >
                                            {{ errors.service_fee }}
                                        </div>
                                    </div>

                                    <br />

                                    <div class="sm:col-span-4">
                                        <div class="flex flex-row items-center">
                                            <div
                                                class="group grid size-4 grid-cols-1"
                                            >
                                                <input
                                                    id="is_government"
                                                    name="is_government"
                                                    v-model="form.is_government"
                                                    type="checkbox"
                                                    :checked="
                                                        form.is_government
                                                    "
                                                    :disabled="props.category"
                                                    class="col-start-1 row-start-1 appearance-none rounded border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto"
                                                />
                                                <svg
                                                    class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-[:disabled]:stroke-gray-950/25"
                                                    viewBox="0 0 14 14"
                                                    fill="none"
                                                >
                                                    <path
                                                        class="opacity-0 group-has-[:checked]:opacity-100"
                                                        d="M3 8L6 11L11 3.5"
                                                        stroke-width="2"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                    />
                                                    <path
                                                        class="opacity-0 group-has-[:indeterminate]:opacity-100"
                                                        d="M3 7H11"
                                                        stroke-width="2"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                    />
                                                </svg>
                                            </div>
                                            <div class="mr-3">
                                                <label
                                                    for="is_government"
                                                    class="block text-sm/6 font-medium text-gray-900"
                                                    >ސަރުކާރާއި ގުޅުންހުރި
                                                    ކެޓަގަރީ</label
                                                >
                                            </div>
                                        </div>
                                        <div
                                            class="text-xs text-red-600 mt-1"
                                            v-if="errors.is_government"
                                        >
                                            {{ errors.is_government }}
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

    category: {
        type: Object,
        required: false,
    },
});

const emit = defineEmits(["submit:form", "cancel:form"]);

console.log("categ ", props.category);
const form = useForm({
    name: props.category?.name ?? null,
    description: props.category?.description ?? null,
    service_fee: props.category?.service_fee ?? null,
    is_government: props.category?.is_government ? true : false,
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
