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
                                    ބިލްގެ ތަފްޞީލު
                                </h2>

                                <div
                                    class="mt-5 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-8"
                                >
                                    <div class="sm:col-span-4">
                                        <label
                                            for="name"
                                            class="block text-sm/6 font-medium text-gray-900"
                                            >ވިޔަ ރެފަރެންސް ނަންބަރ</label
                                        >
                                        <div class="mt-2">
                                            <input
                                                type="text"
                                                name="name"
                                                id="name"
                                                dir="ltr"
                                                v-model="form.viya_reference_no"
                                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                            />
                                        </div>
                                        <div
                                            class="text-xs text-red-600 mt-1"
                                            v-if="errors.viya_reference_no"
                                        >
                                            {{ errors.viya_reference_no }}
                                        </div>
                                    </div>

                                    <div class="sm:col-span-4">
                                        <label
                                            for="registration_no"
                                            class="block text-sm/6 font-medium text-gray-900"
                                            >ބިލް ކުރެވުނު މުއްދަތު</label
                                        >
                                        <div class="mt-2">
                                            <input
                                                type="text"
                                                name="registration_no"
                                                id="registration_no"
                                                :value="
                                                    dayjs(
                                                        payable.billed_period
                                                    ).format('MMMM YYYY')
                                                "
                                                disabled
                                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                            />
                                        </div>
                                    </div>

                                    <div class="sm:col-span-4">
                                        <label
                                            for="property_category_id"
                                            class="block text-sm/6 font-medium text-gray-900"
                                            >މަހު ފީ</label
                                        >
                                        <div class="mt-2">
                                            <input
                                                type="text"
                                                name="registration_no"
                                                id="registration_no"
                                                :value="payable.amount"
                                                disabled
                                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                            />
                                        </div>
                                    </div>

                                    <div class="sm:col-span-4">
                                        <label
                                            for="property_category_id"
                                            class="block text-sm/6 font-medium text-gray-900"
                                            >ޖޫރިމަނާ</label
                                        >
                                        <div class="mt-2">
                                            <input
                                                type="text"
                                                name="registration_no"
                                                id="registration_no"
                                                :value="payable.fine"
                                                disabled
                                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                            />
                                        </div>
                                    </div>

                                    <div
                                        class="sm:col-span-4"
                                        v-if="payable.payments.length > 0"
                                    >
                                        <label
                                            for="property_category_id"
                                            class="block text-sm/6 font-medium text-gray-900"
                                            >ބިލް ދެއްކި ތާރީޚް</label
                                        >
                                        <div class="mt-2">
                                            <input
                                                type="text"
                                                name="registration_no"
                                                id="registration_no"
                                                :value="
                                                    dayjs(
                                                        payable.updated_at
                                                    ).format('DD MMMM YYYY')
                                                "
                                                disabled
                                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="border-b border-gray-900/10 pb-12">
                                <h2
                                    class="text-base/7 font-semibold text-gray-900"
                                >
                                    ގޭގެ ތަފްޞީލު
                                </h2>

                                <div
                                    class="mt-5 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-8"
                                >
                                    <div class="sm:col-span-4">
                                        <label
                                            for="national_id"
                                            class="block text-sm/6 font-medium text-gray-900"
                                            >ގޭގެ ނަން</label
                                        >
                                        <div class="mt-2">
                                            <ThaanaInput
                                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                                name="name"
                                                id="name"
                                                disabled
                                            />
                                        </div>
                                    </div>

                                    <div class="sm:col-span-4">
                                        <label
                                            for="name"
                                            class="block text-sm/6 font-medium text-gray-900"
                                            >ގޭގެ ރަޖިސްޓްރޭޝަން ނަންބަރ</label
                                        >
                                        <div class="mt-2">
                                            <ThaanaInput
                                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                                name="name"
                                                id="name"
                                                :disabled="
                                                    props.id && index === 0
                                                "
                                            />
                                        </div>
                                    </div>

                                    <div class="sm:col-span-4">
                                        <label
                                            for="contact_no"
                                            class="block text-sm/6 font-medium text-gray-900"
                                            >ގޭގެ ކެޓަގަރީ</label
                                        >
                                        <div class="mt-2">
                                            <input
                                                id="contact_no"
                                                name="contact_no"
                                                type="text"
                                                pattern="\d*"
                                                maxlength="7"
                                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div> -->
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
import { MagnifyingGlassIcon } from "@heroicons/vue/16/solid";
import { DialogPanel, TransitionChild } from "@headlessui/vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import ThaanaInput from "thaana-keyboard-vue/src/ThaanaInput.vue";
import Button from "@/components/Button.vue";
import dayjs from "../utils/dayjs";

const props = defineProps({
    payable: {
        type: Object,
        required: true,
    },
    errors: {
        type: Object,
        required: false,
    },
});

const emit = defineEmits(["submit:form", "cancel:form"]);

const form = useForm({
    viya_reference_no: props.payable.viya_reference_no,
});

const onSubmit = function () {
    emit("submit:form", form);
};

const onCancel = function () {
    emit("cancel:form");
    form.reset();
};
</script>

<style lang="scss" scoped></style>
