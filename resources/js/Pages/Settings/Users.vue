<template>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <NewUser />
        </div>
        <div class="my-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div
                    class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8"
                >
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                            <tr>
                                <th
                                    scope="col"
                                    class="py-3.5 pl-4 pr-3 text-right text-sm font-semibold text-gray-900 sm:pl-0"
                                >
                                    ނަން
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900"
                                >
                                    އީމެއިލް
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900"
                                >
                                    ރެޖިސްޓަރ ކުރެވުނު ތާރީޚް
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900"
                                >
                                    ހާލަތު
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3.5 text-sm font-semibold text-gray-900"
                                >
                                    އެކްޝަން
                                </th>
                                <th scope="col" class="relative py-3.5 sm:pr-0">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <tr
                                v-for="user in data.data"
                                :key="user"
                                class="cursor-pointer hover:bg-gray-50"
                                @click="handleClick"
                            >
                                <td
                                    class="whitespace-nowrap px-3 py-5 text-sm text-gray-500"
                                >
                                    {{ user.name }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-5 text-sm text-gray-500"
                                >
                                    {{ user.email }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-5 text-sm text-gray-500"
                                >
                                    {{
                                        dayjs(user.created_at).format(
                                            "DD MMMM YYYY"
                                        )
                                    }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-5 text-sm text-gray-500"
                                >
                                    <Switch
                                        dir="ltr"
                                        @click="toggleUserState(user)"
                                        :class="[
                                            user.is_active
                                                ? 'bg-indigo-600'
                                                : 'bg-gray-200',
                                            'relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2',
                                        ]"
                                    >
                                        <span class="sr-only">Use setting</span>
                                        <span
                                            :class="[
                                                user.is_active
                                                    ? 'translate-x-5'
                                                    : 'translate-x-0',
                                                'pointer-events-none relative inline-block size-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out',
                                            ]"
                                        >
                                            <span
                                                :class="[
                                                    user.is_active
                                                        ? 'opacity-0 duration-100 ease-out'
                                                        : 'opacity-100 duration-200 ease-in',
                                                    'absolute inset-0 flex size-full items-center justify-center transition-opacity',
                                                ]"
                                                aria-hidden="true"
                                            >
                                                <svg
                                                    class="size-3 text-gray-400"
                                                    fill="none"
                                                    viewBox="0 0 12 12"
                                                >
                                                    <path
                                                        d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                    />
                                                </svg>
                                            </span>
                                            <span
                                                :class="[
                                                    user.is_active
                                                        ? 'opacity-100 duration-200 ease-in'
                                                        : 'opacity-0 duration-100 ease-out',
                                                    'absolute inset-0 flex size-full items-center justify-center transition-opacity',
                                                ]"
                                                aria-hidden="true"
                                            >
                                                <svg
                                                    class="size-3 text-indigo-600"
                                                    fill="currentColor"
                                                    viewBox="0 0 12 12"
                                                >
                                                    <path
                                                        d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z"
                                                    />
                                                </svg>
                                            </span>
                                        </span>
                                    </Switch>
                                </td>
                                <td
                                    class="flex justify-around relative whitespace-nowrap py-5 text-sm font-medium sm:pr-0 text-center px-auto"
                                >
                                    <NewUser :user="user" />
                                    <ConfirmDelete
                                        url="users.destroy"
                                        :parameter="{ user: user.id }"
                                    />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <Pagination :links="data.links" v-if="data.length > 0" />
    </div>
</template>

<script setup>
import NewUser from "./NewUser.vue";
import ConfirmDelete from "@/components/ConfirmDelete.vue";
import dayjs from "../../utils/dayjs";
import { useForm } from "@inertiajs/vue3";
import { Switch } from "@headlessui/vue";
import Pagination from "@/components/Pagination.vue";

const props = defineProps({
    data: {
        type: Object,
        required: true,
    },
});

const toggleUserState = async (user) => {
    const form = useForm({
        ...user,
        is_active: !user.is_active,
    });
    form.put(
        route("users.update", {
            user: user.id,
        })
    );
};
</script>

<style lang="scss" scoped></style>
