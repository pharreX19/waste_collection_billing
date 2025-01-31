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
                        <label
                            for="email"
                            class="block text-sm font-medium leading-6 text-gray-900"
                            >އީމެއިލް އެޑްރެސް</label
                        >
                        <div class="mt-2">
                            <input
                                dir="ltr"
                                id="email"
                                name="email"
                                type="email"
                                autocomplete="email"
                                v-model="form.email"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            />
                        </div>
                        <div
                            class="text-xs text-red-600 mt-1"
                            v-if="errors.email"
                        >
                            {{ errors.email }}
                        </div>
                    </div>

                    <div>
                        <label
                            for="password"
                            class="block text-sm font-medium leading-6 text-gray-900"
                            >ޕާސްވޯޑް</label
                        >
                        <div class="mt-2">
                            <input
                                dir="ltr"
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="current-password"
                                v-model="form.password"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            />
                        </div>
                        <div
                            class="text-xs text-red-600 mt-1"
                            v-if="errors.password"
                        >
                            {{ errors.password }}
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input
                                id="remember-me"
                                name="remember-me"
                                type="checkbox"
                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
                            />
                            <label
                                for="remember-me"
                                class="mr-3 block text-sm leading-6 text-gray-900"
                                >ލޮގިން ކުރަމަށްފަހު ބަހައްޓަވާ</label
                            >
                        </div>

                        <div class="text-sm leading-6">
                            <a
                                href="#"
                                class="font-semibold text-indigo-600 hover:text-indigo-500"
                                >ޕާސްވާޑް ހަނދާނެއްނެތް</a
                            >
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

const form = useForm({
    email: "",
    password: "",
});

const errors = ref({
    email: null,
    password: null,
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
