<template>
    <PencilSquareIcon
        class="h-4 w-4 mr-4 hover:text-indigo-600 text-indigo-400"
        v-if="payable.payments.length > 0"
        @click.stop="handleModalOpen"
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
                <div class="fixed inset-0 bg-gray-500/75 transition-opacity" />
            </TransitionChild>

            <EditPayableForm
                :payable="payable"
                :errors="errors"
                @submit:form="onSubmit"
                @cancel:form="onCancel"
            />
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import { ref } from "vue";
import { Dialog, TransitionChild, TransitionRoot } from "@headlessui/vue";
import { PencilSquareIcon } from "@heroicons/vue/24/outline";
import EditPayableForm from "@/Components/EditPayableForm.vue";

const props = defineProps({
    payable: {
        type: Object,
        required: true,
    },
});

const open = ref(false);
const errors = ref({});

const handleModalOpen = () => {
    open.value = true;
};

const onCancel = () => {
    open.value = false;
};

const onSubmit = (form) => {
    updatePayable(form);
};

const updatePayable = async (form) => {
    form.put(route("payables.update", props.payable.id), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            open.value = false;
        },
        onError: (errorMessages) => {
            errors.value = errorMessages;
        },
    });
};
</script>
