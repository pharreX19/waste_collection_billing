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
                                        <TextInput
                                            name="name"
                                            label="ނަން"
                                            v-model="form.name"
                                            :errors="errors"
                                            dir="rtl"
                                            lang="dv"
                                        />
                                    </div>

                                    <div class="sm:col-span-4">
                                        <TextInput
                                            name="email"
                                            label="އީމެއިލް"
                                            v-model="form.email"
                                            :errors="errors"
                                        />
                                    </div>

                                    <div class="sm:col-span-4">
                                        <TextInput
                                            type="password"
                                            name="password"
                                            label="ޕާސްވާރޑް"
                                            v-model="form.password"
                                            :errors="errors"
                                            :disabled="!!props.id"
                                        />
                                    </div>

                                    <div class="sm:col-span-4">
                                        <TextInput
                                            type="password"
                                            name="password_confirmation"
                                            label="ޕާސްވާރޑް ކޮންފާރމޭޝަން"
                                            v-model="form.password_confirmation"
                                            :errors="errors"
                                            :disabled="!!props.id"
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
import TextInput from "@/components/UI/TextInput.vue";

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
