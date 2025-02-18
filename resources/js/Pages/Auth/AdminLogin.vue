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
                އެކައުންޓަށް ލޮގިން ކުރައްވާ
            </h2>
        </div>

        <div class="mt-6 sm:mx-auto sm:w-full sm:max-w-[480px]">
            <div class="bg-white px-6 py-12 shadow sm:rounded-lg sm:px-12">
                <form class="space-y-6" @submit.prevent="login">
                    <div>
                        <TextInput
                            name="email"
                            label="އީމެއިލް އެޑްރެސް"
                            v-model="form.email"
                            :errors="errors"
                        />
                    </div>

                    <div>
                        <TextInput
                            name="password"
                            type="password"
                            label="ޕާސްވޯޑް"
                            v-model="form.password"
                            :errors="errors"
                        />
                    </div>

                    <div class="flex items-center justify-between">
                        <CheckboxInput
                            name="remember-me"
                            v-model="form.remember_me"
                            label="ލޮގިން ކުރަމަށްފަހު ބަހައްޓަވާ"
                        />

                        <div class="text-sm leading-6">
                            <a
                                href="#"
                                class="font-semibold text-indigo-600 hover:text-indigo-500"
                                >ޕާސްވާޑް ހަނދާނެއްނެތް</a
                            >
                        </div>
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
import CheckboxInput from "@/components/UI/CheckboxInput.vue";
import Button from "@/components/Button.vue";

const form = useForm({
    email: "",
    password: "",
    remember_me: false,
});

const errors = ref({
    email: null,
    password: null,
    remember_me: false,
});

const login = () => {
    form.post(route("auth.admin-login"), {
        onError: (errorMessages) => {
            errors.value = errorMessages;
        },
    });
};
</script>

<style scoped></style>
