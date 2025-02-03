<template>
    <main class="h-[100vh] w-[100vw] flex flex-row">
        <div class="min-w-[18vw]" v-if="page.props.auth.user">
            <Sidebar />
        </div>

        <div
            class="my-16 overflow-y-scroll"
            :class="[page.props.auth.user ? 'min-w-[82vw]' : 'min-w-[100vw]']"
        >
            <slot />
        </div>
    </main>
</template>

<script setup>
import { usePage } from "@inertiajs/vue3";
import Sidebar from "@/components/Sidebar.vue";

const page = usePage();
</script>

<style scoped></style>
