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
            <AutoComplete
                v-model="form.property"
                placeholder="ގޭގެ ނަން ޖައްސަވާ"
            />
        </div>

        <Button label="ތަފްޞީލް ދައްކާ" @click="onClick" variant="submit" />
    </div>
</template>

<script setup>
import { router, useForm } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import AutoComplete from "@/components/AutoComplete.vue";
import Button from "@/components/Button.vue";

const form = useForm({
    property: {
        name: null,
    },
});

const onClick = () => {
    if (!form.property.id) return;

    const id = form.property.id;
    form.property = {
        name: null,
    };

    router.visit(
        route("payables.index", {
            property: id,
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
