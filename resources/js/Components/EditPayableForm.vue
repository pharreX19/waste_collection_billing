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
                                        <TextInput
                                            type="password"
                                            name="viya_reference_no"
                                            label="ވިޔަ ރެފަރެންސް ނަންބަރ"
                                            v-model="form.viya_reference_no"
                                            :errors="errors"
                                        />
                                    </div>

                                    <div class="sm:col-span-4">
                                        <TextInput
                                            name="billed_period"
                                            label="ބިލް ކުރެވުނު މުއްދަތު"
                                            :modelValue="
                                                dayjs(
                                                    payable.billed_period
                                                ).format('MMMM YYYY')
                                            "
                                            dir="rtl"
                                            :disabled="true"
                                        />
                                    </div>

                                    <div class="sm:col-span-4">
                                        <TextInput
                                            name="payable_amount"
                                            label="މަހު ފީ"
                                            :modelValue="payable.amount"
                                            :disabled="true"
                                            dir="rtl"
                                        />
                                    </div>

                                    <div class="sm:col-span-4">
                                        <TextInput
                                            name="fine"
                                            label="ޖޫރިމަނާ"
                                            :modelValue="payable.fine"
                                            :disabled="true"
                                            dir="rtl"
                                        />
                                    </div>

                                    <div
                                        class="sm:col-span-4"
                                        v-if="payable.payments.length > 0"
                                    >
                                        <TextInput
                                            name="updated_at"
                                            label="ބިލް ދެއްކި ތާރީޚް"
                                            dir="rtl"
                                            :modelValue="
                                                dayjs(
                                                    payable.updated_at
                                                ).format('DD MMMM YYYY')
                                            "
                                            :disabled="true"
                                        />
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
import Button from "@/components/Button.vue";
import dayjs from "../utils/dayjs";
import TextInput from "@/components/UI/TextInput.vue";

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
