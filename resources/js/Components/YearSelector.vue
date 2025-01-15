<template>
    <div class="outline rounded-md outline-gray-100 p-2 max-w-fit">
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
            <nav class="flex space-x-4" aria-label="Tabs">
                <a
                    v-for="tab in tabs"
                    :key="tab.name"
                    @click="onClick(tab.name)"
                    :class="[
                        tab.current
                            ? 'bg-indigo-100 text-indigo-700'
                            : 'text-gray-500 hover:text-gray-700',
                        'rounded-md px-3 py-2 text-sm font-medium cursor-pointer',
                    ]"
                    :aria-current="tab.current ? 'page' : undefined"
                    >{{ tab.name }}</a
                >
            </nav>
        </div>
    </div>
</template>

<script setup>
import { ChevronDownIcon } from "@heroicons/vue/16/solid";
import { reactive } from "vue";

const tabs = reactive([
    { name: "2021", href: "#", current: false },
    { name: "2022", href: "#", current: false },
    { name: "2023", href: "#", current: true },
    { name: "2024", href: "#", current: false },
    { name: "2025", href: "#", current: false },
]);

const onClick = (name) => {
    tabs.forEach((tab) => {
        tab.current = tab.name === name;
    });
};
</script>
