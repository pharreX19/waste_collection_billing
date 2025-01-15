<template>
    <main class="h-[100vh] w-[100vw] flex flex-row">
        <div class="min-w-[18vw]">
            <Sidebar />
        </div>

        <div class="mt-16 min-w-[82vw] overflow-y-scroll">
            <slot />
        </div>
    </main>
</template>

<script setup>
import Sidebar from "./Components/Sidebar.vue";
</script>

<style scoped></style>
