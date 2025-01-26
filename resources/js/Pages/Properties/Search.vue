<template>
    <div
        class="flex flex-col flex-1 justify-center items-center h-full min-w-96"
    >
        <h2
            class="text-center text-2xl font-bold leading-9 tracking-tight text-gray-900"
        >
            ގޭބިސީ ހޯދާ
        </h2>
        <div class="mt-8 flex w-96 h-12">
            <!-- <input
                type="email"
                name="email"
                id="email"
                aria-label="Email"
                class="block w-full h-full rounded-md bg-white px-3 py-1.5 text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 text-xl"
                placeholder="ގޭގެ ނަން ނުވަތަ ރަޖިސްޓްރީ ކޯޑް"
            /> -->

            <AutoComplete v-model="form.property" />
        </div>

        <button
            :disabled="!form.property?.id"
            type="button"
            class="rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500"
            @click="onClick"
        >
            ތަފްޞީލް ދައްކާ
        </button>
    </div>
</template>

<script setup>
import { router, useForm } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import AutoComplete from "../../Components/AutoComplete.vue";

const form = useForm({
    property: {
        name: null,
    },
});

const onClick = () => {
    if (!form.property.id) return;

    router.visit(
        route("payables.index", {
            property: form.property.id,
            year: new Date().getFullYear(),
        }),
        {
            headers: {
                Accept: "text/html",
                "Content-type": "text/html",
            },
        }
    );
};
</script>
