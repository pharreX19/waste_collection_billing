<template>
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <h3 class="text-base font-semibold text-gray-900"></h3>
        <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div
                v-for="item in stats"
                :key="item.id"
                class="relative overflow-hidden rounded-lg bg-white px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6"
            >
                <dt>
                    <div class="absolute rounded-md bg-indigo-500 p-3">
                        <component
                            :is="item.icon"
                            class="size-6 text-white"
                            aria-hidden="true"
                        />
                    </div>
                    <p class="mr-16 truncate text-sm font-medium text-gray-500">
                        {{ item.name }}
                    </p>
                </dt>
                <dd class="mr-16 flex items-baseline pb-6 sm:pb-7">
                    <p class="text-2xl font-semibold text-gray-900">
                        {{ item.stat }}
                    </p>

                    <div
                        class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6"
                    >
                        <div class="text-sm">
                            <p
                                :class="[
                                    item.changeType === 'increase'
                                        ? 'text-green-600'
                                        : 'text-red-600',
                                    'mr-2 flex items-baseline text-sm font-semibold',
                                ]"
                            >
                                <ArrowUpIcon
                                    v-if="item.changeType === 'increase'"
                                    class="size-5 shrink-0 self-center text-green-500"
                                    aria-hidden="true"
                                />
                                <ArrowDownIcon
                                    v-else
                                    class="size-5 shrink-0 self-center text-red-500"
                                    aria-hidden="true"
                                />
                                <span class="sr-only">
                                    {{
                                        item.changeType === "increase"
                                            ? "Increased"
                                            : "Decreased"
                                    }}
                                    by
                                </span>
                                {{ Math.abs(item.change) }}
                            </p>
                        </div>
                    </div>
                </dd>
            </div>
        </dl>
        <div class="flex flex-row mt-10">
            <input
                v-model="selectedDate"
                type="date"
                name="date"
                id="date"
                class="inline-block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 max-w-40"
            />
            <button
                @click="generatePayables"
                type="button"
                class="mx-5 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            >
                Generate Payables
            </button>

            <button
                @click="generateFines"
                type="button"
                class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600"
            >
                Calculate Fine
            </button>
        </div>
    </div>
</template>

<script setup>
import { ArrowDownIcon, ArrowUpIcon } from "@heroicons/vue/20/solid";
import {
    CursorArrowRaysIcon,
    EnvelopeOpenIcon,
    UsersIcon,
} from "@heroicons/vue/24/outline";
import { onMounted, reactive, ref } from "vue";

const props = defineProps({
    properties: {
        type: Array,
        required: true,
    },
    pending: {
        type: Array,
        required: true,
    },
    paid: {
        type: Array,
        required: true,
    },
});

const stats = reactive([
    {
        id: 1,
        name: "ޖުމްލަ ރަޖިސްޓްރީ",
        stat: "0",
        icon: UsersIcon,
        change: "122",
        changeType: "increase",
    },
    {
        id: 2,
        name: "ލިބެންޖެހޭ ޖުމްލަ",
        stat: "0",
        icon: EnvelopeOpenIcon,
        change: "5.4%",
        changeType: "increase",
    },
    {
        id: 3,
        name: "ލިބުނު ޖުމްލަ",
        stat: "0",
        icon: CursorArrowRaysIcon,
        change: "3.2%",
        changeType: "decrease",
    },
]);

const selectedDate = ref();

onMounted(() => {
    const currentYear = new Date().getFullYear();
    const pastYear = currentYear - 1;

    const currentYearPropertyStat =
        findStatForYear(props.properties, currentYear)?.count || 0;
    const currentYearPendingStat =
        findStatForYear(props.pending, currentYear)?.total_amount || 0;
    const currentYearPaidStat =
        findStatForYear(props.paid, currentYear)?.total_amount || 0;

    const pastYearPropertyStat =
        findStatForYear(props.properties, pastYear)?.count || 0;
    const pastYearPendingStat =
        findStatForYear(props.pending, pastYear)?.total_amount || 0;
    const pastYearPaidStat =
        findStatForYear(props.paid, pastYear)?.total_amount || 0;

    stats[0].stat = currentYearPropertyStat + pastYearPropertyStat;
    stats[0].change = currentYearPropertyStat;

    stats[1].stat = currentYearPendingStat;
    stats[1].change = (
        ((currentYearPendingStat - pastYearPendingStat) / pastYearPendingStat) *
        100
    ).toFixed(2);
    stats[1].changeType = stats[1].change > 0 ? "increase" : "decrease";

    stats[2].stat = currentYearPaidStat;
    stats[2].change = (
        ((currentYearPaidStat - pastYearPaidStat) / pastYearPaidStat) *
        100
    ).toFixed(2);
    stats[2].changeType = stats[1].change > 0 ? "increase" : "decrease";
});

const findStatForYear = (data, year) =>
    data.find((item) => item.year === year) || null;

const generatePayables = async () => {
    const response = await fetch(
        route("payables.generate", { date: selectedDate.value })
    );
};

const generateFines = async () => {
    const response = await fetch(route("fines.generate"));
};
</script>

<style lang="scss" scoped></style>
