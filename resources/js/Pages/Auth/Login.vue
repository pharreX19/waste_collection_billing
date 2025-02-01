<template>
    <div
        class="flex h-full flex-1 flex-col justify-center items-center sm:px-6 lg:px-8"
    >
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <img
                class="mx-auto h-28 w-auto"
                src="@/images/logo.jpg"
                alt="logo"
            />
            <h2
                class="text-center text-2xl font-bold leading-9 tracking-tight text-gray-900"
            >
                ބިލަށް ފައިސާ ދެއްކެވުމަށް ލޮގިން ކުރައްވާ
            </h2>
        </div>

        <div class="mt-6 sm:mx-auto sm:w-full sm:max-w-[480px]">
            <div class="bg-white px-6 py-12 shadow sm:rounded-lg sm:px-12">
                <form class="space-y-6" @submit.prevent="onSubmit">
                    <div>
                        <label
                            for="name"
                            class="block text-sm font-medium leading-6 text-gray-900"
                            >ގޭގެ ނަން ނުވަތަ ރަޖިސްޓްރީ ކޯޑް</label
                        >
                        <div class="mt-2">
                            <input
                                dir="ltr"
                                id="name"
                                name="name"
                                type="name"
                                autocomplete="name"
                                v-model="form.name"
                                :disabled="requestedOtp"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            />
                        </div>
                        <div
                            class="text-xs text-red-600 mt-1"
                            v-if="errors.name"
                        >
                            {{ errors.name }}
                        </div>
                    </div>

                    <div>
                        <label
                            for="contact_no"
                            class="block text-sm font-medium leading-6 text-gray-900"
                            >މޯބައިލް ނަންބަރ</label
                        >
                        <div class="mt-2">
                            <input
                                dir="ltr"
                                id="contact_no"
                                name="contact_no"
                                type="contact_no"
                                autocomplete="current-contact_no"
                                v-model="form.contact_no"
                                :disabled="requestedOtp"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            />
                        </div>
                        <div
                            class="text-xs text-red-600 mt-1"
                            v-if="errors.contact_no"
                        >
                            {{ errors.contact_no }}
                        </div>
                    </div>

                    <div v-if="requestedOtp">
                        <label
                            for="otp"
                            class="block text-sm font-medium leading-6 text-gray-900"
                            >އޯޓީޕީ</label
                        >
                        <div class="mt-2">
                            <input
                                dir="ltr"
                                id="otp"
                                name="otp"
                                type="text"
                                maxlength="6"
                                pattern="\d*"
                                autocomplete="current-otp"
                                v-model="form.otp"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            />
                        </div>
                        <div
                            class="text-xs text-red-600 mt-1"
                            v-if="errors.otp"
                        >
                            {{ errors.otp }}
                        </div>
                    </div>

                    <div>
                        <button
                            type="submit"
                            class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        >
                            ލޮގިން ކުރައްވާ
                        </button>
                        <div
                            class="text-xs text-red-600 mt-3 text-center"
                            v-if="errors?.error"
                        >
                            {{ errors?.error }}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    property_id: {
        type: String,
        required: false,
    },
    name: {
        type: String,
        required: false,
    },
});

const form = useForm({
    name: "",
    contact_no: "",
    otp: "",
});

const requestedOtp = ref(false);

const errors = ref({
    name: null,
    contact_no: null,
});

const onSubmit = () => {
    // requestedOtp.value = true;
    if (props.name && props.property_id) {
        login();
    } else {
        requestOtp();
    }
};

const requestOtp = () => {
    form.post(
        route("auth.otp"),
        {
            onError: (errorMessages) => {
                errors.value = errorMessages;
            },
            onSuccess: () => {
                requestedOtp.value = true;
            },
        },
        {
            only: ["property_id", "name"],
        }
    );
};

const login = () => {
    form.transform((data) => ({
        ...data,
        name: props.name,
        property_id: props.property_id,
    })).post(route("auth.login"), {
        onError: (errorMessages) => {
            errors.value = errorMessages;
        },
        onSuccess: () => {
            requestedOtp.value = true;
        },
    });
};
</script>

<style scoped></style>
