<template>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <NewCategory />
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
                                    ތަފްޞީލު
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900"
                                >
                                    މަހު ފީ
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900"
                                >
                                    ސަރުކާރާއި ގުޅުންހުރި ކެޓަގަރީ
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
                                v-for="category in data.data"
                                :key="category"
                                class="cursor-pointer hover:bg-gray-50"
                                @click="handleClick"
                            >
                                <td
                                    class="whitespace-nowrap px-3 py-5 text-sm text-gray-500"
                                >
                                    {{ category.name }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-5 text-sm text-gray-500"
                                >
                                    {{ category.description }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-5 text-sm text-gray-500"
                                >
                                    {{ category.service_fee }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-5 text-sm text-gray-500"
                                >
                                    <span
                                        v-if="category.is_government"
                                        class="bg-green-600 flex size-5 items-center justify-center rounded-full ring-8 ring-white"
                                    >
                                        <CheckIcon
                                            class="size-3 text-white"
                                            aria-hidden="true"
                                        />
                                    </span>
                                </td>
                                <td
                                    class="flex justify-center relative whitespace-nowrap py-5 text-sm font-medium sm:pr-0 text-center px-auto"
                                >
                                    <NewCategory :category="category" />
                                    <!-- <ConfirmDelete
                                        :property_id="`${category.id}`"
                                    /> -->
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <Pagination :links="data.links" />
    </div>
</template>

<script setup>
import NewUser from "./NewUser.vue";
import ConfirmDelete from "@/components/ConfirmDelete.vue";
import dayjs from "../../utils/dayjs";
import { useForm } from "@inertiajs/vue3";
import { Switch } from "@headlessui/vue";
import Pagination from "@/components/Pagination.vue";
import NewCategory from "./NewCategory.vue";
import { CheckIcon, HandThumbUpIcon, UserIcon } from "@heroicons/vue/20/solid";

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
