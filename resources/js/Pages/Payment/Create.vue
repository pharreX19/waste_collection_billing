<template>
    <div class="mt-4 sm:mt-0 sm:flex-none">
        <button
            type="button"
            @click="handleModalOpen"
            class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
        >
            <span aria-hidden="true">&rarr;</span>

            {{ isUser ? "ފައިސާ ދެއްކުން" : "ފައިސާ ބަލައިގަތުން" }}
        </button>
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

            <NewPaymentForm :errors="errors" :id="id" @cancel:form="onCancel" />
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import { ref, computed } from "vue";
import { Dialog, TransitionChild, TransitionRoot } from "@headlessui/vue";
import NewPaymentForm from "@/components/NewPaymentForm.vue";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    isEdit: {
        type: Boolean,
        required: false,
        default: false,
    },
    id: {
        type: String,
        required: false,
        default: null,
    },
});

const page = usePage();
const open = ref(false);
const errors = ref({});

const handleModalOpen = () => {
    open.value = true;
};

const onCancel = () => {
    router.visit(
        route("payables.index", {
            property: props.id,
            year: new Date().getFullYear(),
        }),
        {
            headers: {
                Accept: "text/html",
                "Content-type": "text/html",
            },
        }
    );

    open.value = false;
};

const isUser = computed(() => page.props.auth.user.role_id === 3);
</script>
