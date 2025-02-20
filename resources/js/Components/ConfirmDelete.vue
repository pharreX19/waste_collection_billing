<template>
    <TrashIcon
        class="h-4 w-4 ml-2 hover:text-red-600 text-red-500"
        @click.stop="open = true"
    />

    <TransitionRoot as="template" :show="open">
        <Dialog class="relative z-10" @close="open = false">
            <TransitionChild
                as="template"
                enter="ease-out duration-300"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="ease-in duration-200"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div
                    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                />
            </TransitionChild>

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
                            class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6"
                        >
                            <div>
                                <div
                                    class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100"
                                >
                                    <ExclamationCircleIcon
                                        class="h-6 w-6 text-red-600"
                                        aria-hidden="true"
                                    />
                                </div>
                                <div class="mt-3 text-center sm:mt-5">
                                    <DialogTitle
                                        as="h3"
                                        class="text-base font-semibold leading-6 text-gray-900"
                                        >ރެކޯރޑް ފުހެލުން</DialogTitle
                                    >
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">
                                            މި ރެކޯރޑް ޑޭޓާބޭސް އިން
                                            ފުހެލައްވަން ބޭނުންފުޅުވާކަން
                                            ކަރަވަރު ކުރައްވާ
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 sm:mt-6 flex justify-around px-10">
                                <Button
                                    @click="open = false"
                                    variant="cancel"
                                    label="ނޫނެކެވެ"
                                />

                                <Button
                                    @click="deleteConfirm"
                                    variant="danger"
                                    label="އާއެކެވެ"
                                    class="text-white bg-red-600"
                                />
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import { ref } from "vue";
import {
    Dialog,
    DialogPanel,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import { ExclamationCircleIcon, TrashIcon } from "@heroicons/vue/24/outline";
import Button from "@/components/Button.vue";
import { useDelete } from "../Composables/useDelete";

const props = defineProps({
    url: {
        type: String,
        required: true,
    },
    parameter: {
        type: Object,
        required: true,
    },
});

const open = ref(false);
const { deleteRecord } = useDelete();

const deleteConfirm = async () => {
    await deleteRecord(props.url, props.parameter);
    open.value = false;
};
</script>
