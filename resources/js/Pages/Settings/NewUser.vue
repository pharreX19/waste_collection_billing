<template>
    <div class="mt-4 sm:mt-0 sm:flex-none">
        <button
            v-if="!user"
            type="button"
            @click="handleModalOpen"
            class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
        >
            ޔޫޒަރ ރެޖިސްޓަރ ކުރައްވާ
        </button>

        <PencilSquareIcon
            v-else
            class="h-4 w-4 ml-2 hover:text-indigo-600 text-indigo-500"
            @click="handleModalOpen"
        />
    </div>
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

            <NewEditUserForm
                :errors="errors"
                :user="user"
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
import NewEditUserForm from "@/components/NewEditUserForm.vue";

const props = defineProps({
    user: {
        type: Object,
        required: false,
        default: null,
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
    if (!props.id) {
        createProperty(form);
    } else {
        updateProperty(form);
    }
};

const createProperty = async (form) => {
    form.post(route("properties.store"), {
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

const updateProperty = async (form) => {
    form.put(route("properties.update", props.id), {
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
