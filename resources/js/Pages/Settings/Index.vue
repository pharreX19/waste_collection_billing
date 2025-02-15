<template>
    <div class="px-4 sm:px-6 lg:px-8">
        <div>
            <div class="grid grid-cols-1 sm:hidden">
                <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                <select
                    aria-label="Select a tab"
                    class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-2 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"
                >
                    <option
                        v-for="tab in tabs"
                        :key="tab.name"
                        :selected="tab.current"
                        @change="selectedTab = tab.name"
                    >
                        {{ tab.name }}
                    </option>
                </select>
                <ChevronDownIcon
                    class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end fill-gray-500"
                    aria-hidden="true"
                />
            </div>
            <div class="hidden sm:block">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <Link
                            v-for="tab in tabs"
                            :key="tab.name"
                            :href="tab.href"
                            @click="selectedTab = tab.name"
                            :class="[
                                tab.current
                                    ? 'border-indigo-500 text-indigo-600'
                                    : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700',
                                'whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium',
                            ]"
                            :aria-current="tab.current ? 'page' : undefined"
                            >{{ tab.name }}</Link
                        >
                    </nav>
                </div>
            </div>
            <div class="mt-10">
                <component :is="activeComp" :data="users"></component>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { ChevronDownIcon } from "@heroicons/vue/16/solid";
import { computed, ref } from "vue";
import Users from "./Users.vue";
import Categories from "./Categories.vue";
import Payables from "./Payables.vue";

const props = defineProps({
    users: {
        type: Array,
        required: true,
    },
});

const tabs = [
    { name: "ސްޓާފް ލިސްޓް", href: "settings?type=users", current: true },
    {
        name: "ގޭބިސީ ކެޓަގަރީ",
        href: "settings?type=categories",
        current: false,
    },
    { name: "ބިލްތަކާއި ބެހޭ", href: "settings?type=payables", current: false },
];

const activeComp = computed(() => {
    const url = new URL(window.location.href);
    const selectedTab = url.searchParams.get("type");

    switch (selectedTab) {
        case "users":
            return Users;
        case "categories":
            return Categories;
        default:
            return Payables;
    }
});
</script>
