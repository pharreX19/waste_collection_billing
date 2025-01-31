<template>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold text-gray-900">
                    ގޭބިސީ ރަޖިސްޓްރީ
                </h1>
                <p class="mt-2 text-sm text-gray-700"></p>
            </div>
            <NewProperty />
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
                                    ރަޖސްޓްރޭޝަން ނަންބަރ /ނަން
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900"
                                >
                                    ވެރިފަރާތް / މަސްއޫލުވެރިޔާ
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900"
                                >
                                    ތަނުގެ ބާވަތް
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900"
                                >
                                    ހާލަތު
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900"
                                >
                                    ރަޖިސްޓްރީ ކުރެވުނު ތާރީޚް
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900"
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
                                v-for="person in data"
                                :key="person.email"
                                class="cursor-pointer hover:bg-gray-50"
                                @click="handleClick"
                            >
                                <td
                                    class="whitespace-nowrap py-3 pl-4 pr-3 text-sm sm:pl-0"
                                >
                                    <div class="flex items-center">
                                        <div class="size-11 shrink-0">
                                            <!-- <img
                                                class="size-11 rounded-full"
                                                :src="person.image"
                                                alt=""
                                            /> -->
                                            <template>
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke-width="1.5"
                                                    stroke="currentColor"
                                                    class="size-6"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
                                                    />
                                                </svg>
                                            </template>
                                        </div>
                                        <div class="mr-4">
                                            <div
                                                class="font-medium text-gray-900"
                                            >
                                                {{ person.name }}
                                            </div>
                                            <div class="mt-1 text-gray-500">
                                                {{ person.registration_no }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-5 text-sm text-gray-500"
                                >
                                    <div
                                        class="flex items-center text-gray-900"
                                        v-for="(
                                            rp, index
                                        ) in person.responsible_persons"
                                    >
                                        <span
                                            :class="[
                                                index === 0
                                                    ? ''
                                                    : 'text-gray-500 mt-1',
                                            ]"
                                            >{{ rp.name }}</span
                                        >
                                    </div>
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-5 text-sm text-gray-500"
                                >
                                    {{ person.category.name }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-5 text-sm text-gray-500"
                                >
                                    <!-- <span
                                        class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20"
                                        >{{
                                            person.is_active
                                                ? "Active"
                                                : "Inactive"
                                        }}</span
                                    > -->
                                    <Switch
                                        dir="ltr"
                                        @click="togglePropertyState(person)"
                                        :class="[
                                            person.is_active
                                                ? 'bg-indigo-600'
                                                : 'bg-gray-200',
                                            'relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2',
                                        ]"
                                    >
                                        <span class="sr-only">Use setting</span>
                                        <span
                                            :class="[
                                                person.is_active
                                                    ? 'translate-x-5'
                                                    : 'translate-x-0',
                                                'pointer-events-none relative inline-block size-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out',
                                            ]"
                                        >
                                            <span
                                                :class="[
                                                    person.is_active
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
                                                    person.is_active
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
                                    class="whitespace-nowrap px-3 py-5 text-sm text-gray-500 text-right"
                                >
                                    {{
                                        dayjs(person.registration_date).format(
                                            "DD MMMM YYYY"
                                        )
                                    }}
                                </td>
                                <td
                                    class="flex justify-around relative whitespace-nowrap py-5 text-right text-sm font-medium sm:pr-0"
                                >
                                    <NewProperty :id="person.id" />
                                    <ConfirmDelete />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <Pagination :links="links" />
    </div>
</template>

<script setup>
import NewProperty from "./NewProperty.vue";
import Pagination from "../../Components/Pagination.vue";
import ConfirmDelete from "../../Components/ConfirmDelete.vue";
import { Switch } from "@headlessui/vue";
import { useForm } from "@inertiajs/vue3";
import dayjs from "../../utils/dayjs";

const props = defineProps({
    data: {
        type: Array,
        required: true,
    },
    links: {
        type: Array,
    },
});

const togglePropertyState = (property) => {
    const form = useForm({
        ...property,
        is_active: !property.is_active,
    });
    form.put(
        route("properties.update", {
            property: property.id,
        })
    );
};
</script>
