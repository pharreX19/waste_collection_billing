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
                        <TextInput
                            name="name"
                            label="ގޭގެ ނަން ނުވަތަ ރަޖިސްޓްރީ ކޯޑް"
                            :disabled="requestedOtp"
                            v-model="form.name"
                            :errors="errors"
                        />
                    </div>

                    <div>
                        <TextInput
                            name="contact_no"
                            label="މޯބައިލް ނަންބަރ"
                            :disabled="requestedOtp"
                            v-model="form.contact_no"
                            :errors="errors"
                        />
                    </div>

                    <div v-if="requestedOtp">
                        <TextInput
                            name="otp"
                            label="އޯޓީޕީ"
                            maxlength="6"
                            pattern="\d*"
                            v-model="form.otp"
                            :errors="errors"
                        />
                    </div>

                    <div>
                        <Button
                            type="submit"
                            variant="submit"
                            label=" ލޮގިން ކުރައްވާ"
                            class="w-full"
                        />
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
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import TextInput from "@/components/UI/TextInput.vue";
import Button from "@/components/Button.vue";

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
