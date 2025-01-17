<template>
    <div class="flex justify-center" dir="rtl">
        <!-- v-if="data.data.length > 0" -->
        <nav
            class="isolate inline-flex -space-x-px rounded-md shadow-sm"
            aria-label="Pagination"
            v-for="(link, index) in props.links"
        >
            <Link
                preserve-scroll
                :href="link.url"
                aria-current="page"
                :class="[
                    link.active
                        ? 'relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-medium text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600'
                        : 'relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0',
                ]"
                v-html="link.label"
            ></Link>
        </nav>
    </div>
</template>

<script setup>
import { ChevronLeftIcon, ChevronRightIcon } from "@heroicons/vue/20/solid";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    links: {
        type: Array,
        required: true,
    },
});
</script>

<style lang="scss" scoped></style>
