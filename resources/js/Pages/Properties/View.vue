<template>
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div
            class="mx-auto grid max-w-2xl grid-cols-1 grid-rows-1 items-start gap-x-8 gap-y-8 lg:mx-0 lg:max-w-none lg:grid-cols-3"
        >
            <!-- Invoice summary -->
            <div class="lg:col-start-3 lg:row-end-1">
                <h2 class="sr-only">Summary</h2>
                <div
                    class="rounded-lg bg-gray-50 shadow-sm ring-1 ring-gray-900/5"
                >
                    <dl class="flex flex-wrap">
                        <div class="flex-auto pr-6 pt-6">
                            <dt class="text-sm/6 font-semibold text-gray-900">
                                މިހާތަނަށް ދައްކަންޖެހޭ ޢަދަދު
                            </dt>
                            <dd
                                class="mt-1 text-base font-semibold text-gray-900"
                            >
                                {{ due_amount }}
                            </dd>
                        </div>
                        <div class="flex-none self-end px-6 pt-4">
                            <dt class="sr-only">Status</dt>
                            <dd
                                class="rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-600 ring-1 ring-inset ring-red-600/20"
                            >
                                Overdue
                            </dd>
                        </div>
                        <div
                            class="mt-6 flex w-full flex-none gap-x-4 border-t border-gray-900/5 px-6 pt-6"
                        >
                            <dt class="flex-none">
                                <span class="sr-only">Status</span>
                                <HomeIcon
                                    class="h-6 w-5 text-gray-400"
                                    aria-hidden="true"
                                />
                            </dt>
                            <dd class="text-sm/6 text-gray-900">
                                {{ name }}
                            </dd>
                        </div>

                        <div class="mt-4 flex w-full flex-none gap-x-4 px-6">
                            <dt class="flex-none">
                                <span class="sr-only">Client</span>
                                <UserCircleIcon
                                    class="h-6 w-5 text-gray-400"
                                    aria-hidden="true"
                                />
                            </dt>
                            <dd class="text-sm/6 font-medium text-gray-500">
                                {{ responsible_persons[0].name }}
                            </dd>
                        </div>
                        <div class="mt-4 flex w-full flex-none gap-x-4 px-6">
                            <dt class="flex-none">
                                <span class="sr-only">Due date</span>
                                <CalendarDaysIcon
                                    class="h-6 w-5 text-gray-400"
                                    aria-hidden="true"
                                />
                            </dt>
                            <dd class="text-sm/6 text-gray-500">
                                <time datetime="2023-01-31">{{
                                    registration_date
                                }}</time>
                            </dd>
                        </div>
                    </dl>
                    <div class="mt-6 border-t border-gray-900/5 px-6 py-6">
                        <a
                            href="#"
                            class="text-sm/6 font-semibold text-gray-900"
                        >
                            <span aria-hidden="true">&rarr;</span>
                            ފައިސާ ބަލައިގަތުން
                        </a>
                    </div>
                </div>
            </div>

            <!-- Invoice -->
            <div
                class="-mx-4 px-4 py-8 shadow-sm ring-1 ring-gray-900/5 sm:mx-0 sm:rounded-lg sm:px-8 lg:col-span-2 lg:row-span-2 lg:row-end-2 overflow-x-scroll"
            >
                <YearSelector :selectedYear="selectedYear" />
                <table
                    class="mt-10 w-full whitespace-nowrap text-left text-sm/6"
                >
                    <colgroup>
                        <col class="w-full" />
                        <col />
                        <col />
                        <col />
                    </colgroup>
                    <thead class="border-b border-gray-200 text-gray-900">
                        <tr>
                            <th
                                scope="col"
                                class="px-0 py-3 text-right font-semibold"
                            >
                                ތަފްޞީލް
                            </th>
                            <th
                                scope="col"
                                class="hidden py-3 pl-8 pr-0 text-right font-semibold sm:table-cell"
                            >
                                ރޭޓް
                            </th>
                            <th
                                scope="col"
                                class="hidden py-3 pl-8 pr-0 text-right font-semibold sm:table-cell"
                            >
                                ޖޫރިމަނާ
                            </th>
                            <th
                                scope="col"
                                class="hidden py-3 pl-8 pr-0 text-right font-semibold sm:table-cell"
                            >
                                ޖުމްލަ
                            </th>
                            <th
                                scope="col"
                                class="hidden py-3 pl-8 pr-0 text-right font-semibold sm:table-cell"
                            >
                                މުއްދަތުހަމަވާ ތާރީޚް
                            </th>
                            <th
                                scope="col"
                                class="hidden py-3 pl-8 pr-0 text-right font-semibold sm:table-cell"
                            >
                                ފައިސާ ދެއްކި ތާރީޚް
                            </th>
                            <th
                                scope="col"
                                class="hidden py-3 pl-8 pr-0 text-right font-semibold sm:table-cell"
                            >
                                ރަސީދު ޕްރިންޓް ކުރުން
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="item in payables"
                            :key="item.id"
                            class="border-b border-gray-100 hover:bg-gray-50 cursor-pointer"
                            :class="[
                                selectedPayable === item.id ? 'bg-gray-50' : '',
                            ]"
                            @click="onPayableClick(item)"
                        >
                            <td
                                class="hidden py-5 pl-8 pr-0 text-right align-top tabular-nums text-gray-700 sm:table-cell"
                            >
                                {{ item.billed_period }}
                            </td>
                            <td
                                class="hidden py-5 pl-8 pr-0 text-right align-top tabular-nums text-gray-700 sm:table-cell"
                            >
                                {{ item.amount }}
                            </td>
                            <td
                                class="hidden py-5 pl-8 pr-0 text-right align-top tabular-nums text-gray-700 sm:table-cell"
                            >
                                {{ item.fine }}
                            </td>
                            <td
                                class="hidden py-5 pl-8 pr-0 text-right align-top tabular-nums text-gray-700 sm:table-cell"
                            >
                                {{ item.grand_total }}
                            </td>
                            <td
                                class="hidden py-5 pl-8 pr-0 text-right align-top tabular-nums text-gray-700 sm:table-cell"
                            >
                                {{ item.due_date }}
                            </td>

                            <td
                                class="hidden py-5 pl-8 pr-0 text-right align-top tabular-nums text-gray-700 sm:table-cell"
                            >
                                {{ item.hours }}
                            </td>
                            <td
                                class="hidden py-5 pl-8 pr-0 text-right align-top tabular-nums text-gray-700 sm:table-cell"
                            >
                                <BanknotesIcon
                                    class="h-6 w-5 text-green-400 mx-auto hover:text-green-600"
                                    aria-hidden="true"
                                />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="lg:col-start-3" v-if="payments">
                <h2 class="text-sm/6 font-semibold text-gray-900">
                    ދެއްކި ފައިސާގެ ތަފްޞީލް
                </h2>
                <ul role="list" class="mt-6 space-y-6">
                    <li
                        v-for="(payment, index) in payments"
                        :key="payment.id"
                        class="relative flex gap-x-4"
                    >
                        <div
                            class="absolute left-0 top-0 flex w-6 justify-center text-xs/5 text-gray-500"
                        >
                            {{ payment.state }}
                        </div>
                        <div
                            class="relative flex size-6 flex-none items-center justify-center bg-white"
                        >
                            <div
                                class="size-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300"
                            />
                        </div>
                        <p class="flex-auto py-0.5 text-xs/5 text-gray-500">
                            <span class="font-medium text-gray-900">{{
                                payment.amount
                            }}</span>
                            {{ payment.payment_date }}
                        </p>
                        <time
                            :datetime="payment.dateTime"
                            class="flex-none py-0.5 text-xs/5 text-gray-500"
                            >{{ payment.date }}</time
                        >
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script setup>
import {
    CalendarDaysIcon,
    HomeIcon,
    UserCircleIcon,
} from "@heroicons/vue/20/solid";
import YearSelector from "../../Components/YearSelector.vue";
import { BanknotesIcon } from "@heroicons/vue/24/outline";
import { usePage } from "@inertiajs/vue3";
import { computed, onMounted, ref } from "vue";

const props = defineProps({
    payables: {
        type: Array,
        required: true,
    },
    name: {
        type: String,
        required: true,
    },
    responsible_persons: {
        type: Array,
        required: true,
    },
    registration_date: {
        type: String,
        required: true,
    },
    payables: {
        type: Array,
        required: true,
    },
});

const payments = ref(null);
const selectedPayable = ref(null);
const selectedYear = ref(new Date().getFullYear());

const url = new URL(window.location.href);
const pathname = url.pathname;
const params = Object.fromEntries(url.searchParams.entries());
selectedYear.value = params.year;

onMounted(() => {});

const due_amount = computed(() => {
    return props.payables.reduce((acc, payable) => {
        console.log("payable", payable.state);
        if (payable.state === "pending") {
            return acc + parseFloat(payable.amount);
        }
        return acc;
    }, 0);
});

const onPayableClick = (payable) => {
    selectedPayable.value = payable.id;
    payments.value = payable.payments;
};
</script>
