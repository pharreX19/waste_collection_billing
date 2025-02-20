<template>
    <div class="px-4 sm:px-6 lg:px-8 space-y-8 max-w-3xl">
        <div
            class="mx-auto max-w-2xl space-y-16 sm:space-y-20 lg:mx-0 lg:max-w-none"
        >
            <div>
                <h2 class="text-base/7 font-semibold text-gray-900">
                    ޔޫޒަރ ޕްރޮފައިލް
                </h2>

                <dl
                    class="mt-6 divide-y divide-gray-100 border-t border-gray-200 text-sm/6"
                >
                    <div class="py-6 sm:flex">
                        <dt
                            class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6"
                        >
                            ފުރިހަމަ ނަން
                        </dt>
                        <dd
                            class="mt-1 flex justify-between gap-x-6 sm:mt-0 sm:flex-auto"
                        >
                            <div class="text-gray-600">{{ user.name }}</div>
                        </dd>
                    </div>
                    <div class="py-6 sm:flex">
                        <dt
                            class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6"
                        >
                            އީމެއިލް އެޑްރެސް
                        </dt>
                        <dd
                            class="mt-1 flex justify-between gap-x-6 sm:mt-0 sm:flex-auto"
                        >
                            <div class="text-gray-600">
                                {{ user.email }}
                            </div>
                        </dd>
                    </div>
                    <div class="py-6 sm:flex">
                        <dt
                            class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6"
                        >
                            ޔޫޒަރ ރޯލް
                        </dt>
                        <dd
                            class="mt-1 flex justify-between gap-x-6 sm:mt-0 sm:flex-auto"
                        >
                            <div class="text-gray-600">
                                {{ userRole }}
                            </div>
                        </dd>
                    </div>
                    <div class="py-6 sm:flex">
                        <dt
                            class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6"
                        >
                            ރެޖިސްޓަރ ކުރެވުނު ތާރީޚް
                        </dt>
                        <dd
                            class="mt-1 flex justify-between gap-x-6 sm:mt-0 sm:flex-auto"
                        >
                            <div class="text-gray-600">
                                {{
                                    dayjs(user.created_at).format(
                                        "DD MMMM YYYY"
                                    )
                                }}
                            </div>
                        </dd>
                    </div>
                </dl>
            </div>

            <div>
                <h2 class="text-base/7 font-semibold text-gray-900">
                    ޕާސްވާރޑް ބަދަލުކުރުން
                </h2>
                <form class="md:col-span-2" @submit.prevent="updatePassword">
                    <div
                        class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 sm:max-w-sm sm:grid-cols-6"
                    >
                        <div class="col-span-full">
                            <TextInput
                                type="password"
                                label="މިހާރުގެ ޕާސްވާރޑް"
                                name="current_password"
                                v-model="form.current_password"
                                :errors="errors"
                            />
                        </div>

                        <div class="col-span-full">
                            <TextInput
                                type="password"
                                label="އައު ޕާސްވާރޑް"
                                name="password"
                                v-model="form.password"
                                :errors="errors"
                            />
                        </div>

                        <div class="col-span-full">
                            <TextInput
                                type="password"
                                label="ޕާސްވާރޑް ކޮންފަރމޭޝަން"
                                name="password_confirmation"
                                v-model="form.password_confirmation"
                                :errors="errors"
                            />
                        </div>
                    </div>
                    <div class="mt-8 flex">
                        <Button type="submit" variant="submit" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import dayjs from "../../utils/dayjs";
import TextInput from "@/components/UI/TextInput.vue";
import Button from "@/components/Button.vue";
import { computed, ref } from "vue";
import { toast } from "vue3-toastify";

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    current_password: "",
    password: "",
    password_confirmation: "",
});

const roles = {
    user: "ޔޫޒަރ ރޯލް",
    officer: "ސްޓާފް ރޯލް",
    admin: "އެޑްމިން ރޯލް",
};

const errors = ref({});

const userRole = computed(() => {
    return roles[props.user.role.name.toLowerCase()];
});

const updatePassword = () => {
    form.put(route("users.update", [props.user.id]), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            toast.success("ތިޔަ ފަރާތުގެ ޕާސްވާރޑް އަޕްޑޭޓް ކުރެވިއްޖެ");
        },
        onError: (errorMessages) => {
            errors.value = errorMessages;
        },
    });
};
</script>
