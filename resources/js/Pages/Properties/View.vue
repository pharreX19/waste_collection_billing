<template>
    <div class="mx-auto max-w-7xl py-16">
        <div
            class="mx-auto grid max-w-2xl grid-cols-1 grid-rows-1 items-start gap-x-8 gap-y-8 lg:mx-0 lg:max-w-none lg:grid-cols-4"
        >
            <!-- Invoice summary -->
            <div class="lg:col-start-4 lg:row-end-1">
                <h2 class="sr-only">Summary</h2>
                <div
                    class="rounded-lg bg-gray-50 shadow-sm ring-1 ring-gray-900/5"
                >
                    <dl class="flex flex-wrap">
                        <div class="flex-auto pr-6 pt-6">
                            <dt class="text-sm/6 font-semibold text-gray-900">
                                ޖުމްލަ ދައްކަންޖެހޭ
                            </dt>
                            <dd
                                class="mt-1 text-base font-semibold text-gray-900"
                            >
                                {{ NumberFormatter.format(dueAmount) }}
                            </dd>
                        </div>
                        <div class="flex-none self-end px-6 pt-4">
                            <dt class="sr-only">Status</dt>
                            <dd
                                class="rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset"
                                :class="[
                                    overDueAmount > 0
                                        ? 'text-red-600 bg-red-50 ring-red-600/20'
                                        : 'text-green-600 bg-green-50 ring-green-600/20',
                                ]"
                            >
                                {{
                                    overDueAmount > 0
                                        ? NumberFormatter.format(
                                              overDueAmount
                                          ) + " މުއްދަތުހަމަވެފައި"
                                        : "މުއްދަތުހަމަވެފައެއް ނެތް"
                                }}
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
                                    dayjs(registration_date).format(
                                        "DD MMMM YYYY"
                                    )
                                }}</time>
                            </dd>
                        </div>
                    </dl>
                    <div class="mt-6 border-t border-gray-900/5 px-6 py-6">
                        <Create :id="id" />
                    </div>
                </div>
            </div>

            <!-- Invoice -->
            <div
                class="-mx-4 px-4 py-8 shadow-sm ring-1 ring-gray-900/5 sm:mx-0 sm:rounded-lg sm:px-8 lg:col-span-3 lg:row-span-2 lg:row-end-2 overflow-x-scroll"
            >
                <YearSelector
                    :selectedYear="selectedYear"
                    :propertyId="responsible_persons[0].pivot.property_id"
                />
                <table
                    class="mt-10 w-full whitespace-nowrap text-left text-sm/6"
                >
                    <thead class="border-b border-gray-200 text-gray-900">
                        <tr>
                            <th
                                scope="col"
                                class="hidden py-3 pl-8 pr-0 text-right font-semibold sm:table-cell"
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
                                ވިޔަ ރެފަރެންސް ނަންބަރ
                            </th>
                            <th
                                scope="col"
                                class="hidden py-3 pr-0 text-center font-semibold sm:table-cell"
                            >
                                އެކްޝަން
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
                                {{
                                    dayjs(item.billed_period).format(
                                        "MMMM YYYY"
                                    )
                                }}
                            </td>
                            <td
                                class="hidden py-5 pl-8 pr-0 text-right align-top tabular-nums text-gray-700 sm:table-cell"
                            >
                                {{ NumberFormatter.format(item.amount) }}
                            </td>
                            <td
                                class="hidden py-5 pl-8 pr-0 text-right align-top tabular-nums text-gray-700 sm:table-cell"
                            >
                                {{ NumberFormatter.format(item.fine) }}
                            </td>
                            <td
                                class="hidden py-5 pl-8 pr-0 text-right align-top tabular-nums text-gray-700 sm:table-cell"
                            >
                                {{ NumberFormatter.format(item.grand_total) }}
                            </td>
                            <td
                                class="hidden py-5 pl-8 pr-0 text-right align-top tabular-nums text-gray-700 sm:table-cell"
                            >
                                {{
                                    dayjs(item.due_date).format("DD MMMM YYYY")
                                }}
                            </td>

                            <td
                                class="hidden py-5 pl-8 pr-0 text-right align-top tabular-nums text-gray-700 sm:table-cell"
                            >
                                {{
                                    payableStates.completed.includes(
                                        item.state.toLowerCase()
                                    )
                                        ? dayjs(item.updated_at).format(
                                              "DD MMMM YYYY"
                                          )
                                        : ""
                                }}
                            </td>
                            <td
                                class="hidden py-5 pl-8 pr-0 text-right align-top tabular-nums text-gray-700 sm:table-cell"
                            >
                                {{ item.viya_reference_no }}
                            </td>
                            <td
                                class="flex items-center justify-around py-5 pr-0 text-right align-top tabular-nums text-gray-700 sm:table-cell"
                                style="display: flex"
                            >
                                <!-- <Link
                                    v-if="item.payments?.length > 0"
                                    class="h-6 w-5 inline-block"
                                    :href="
                                        route('payables.print', {
                                            payable: item.id,
                                        })
                                    "
                                > -->
                                <BanknotesIcon
                                    v-if="item.payments?.length > 0"
                                    class="h-6 w-5 text-green-400 hover:text-green-600"
                                    aria-hidden="true"
                                    @click.stop="onPrint(item)"
                                />
                                <!-- </Link> -->

                                <EditPayable :payable="item" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="lg:col-start-4" v-if="payments?.length > 0">
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
                            class="absolute left-0 top-0 flex w-20 justify-center text-xs/5 text-gray-500"
                        >
                            {{ stateMappings[payment.state] }}
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
                            {{
                                dayjs(payment.payment_date).format(
                                    "DD MMMM YYYY HH:MM"
                                )
                            }}
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
import YearSelector from "@/components/YearSelector.vue";
import { BanknotesIcon } from "@heroicons/vue/24/outline";
import { computed, ref } from "vue";
import dayjs from "../../utils/dayjs";
import Create from "../Payment/Create.vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import { payableStates, stateMappings } from "../../utils/stateMapping";
import { NumberFormatter } from "../../utils/numberFormatter";
import EditPayable from "../Payable/EditPayable.vue";

const props = defineProps({
    payables: {
        type: Array,
        required: true,
    },
    total_pending: {
        type: Array,
        required: false,
        default: [],
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
    // payables: {
    //     type: Array,
    //     required: true,
    // },
});

const page = usePage();

const payments = ref(null);
const selectedPayable = ref(null);
const selectedYear = ref(new Date().getFullYear());

const url = new URL(window.location.href);
const pathname = url.pathname;
const parts = pathname.split("/");

const id = parts[2];
const params = Object.fromEntries(url.searchParams.entries());
selectedYear.value = params.year;

const dueAmount = computed(() => {
    return props.total_pending.reduce((acc, payable) => {
        return payableStates.pending.includes(payable.state.toLowerCase())
            ? acc + parseFloat(payable.total_balance)
            : acc;
    }, 0);
});

const overDueAmount = computed(() => {
    return props.total_pending.reduce((acc, payable) => {
        return payableStates.overdue.includes(payable.state.toLowerCase())
            ? acc + parseFloat(payable.total_balance)
            : acc;
    }, 0);
});

const onPayableClick = (payable) => {
    selectedPayable.value = payable.id;
    payments.value = payable.payments;
};

const onPrint = (item) => {
    router.get(
        route("payables.print", {
            payable: item.id,
        })
    );
};

// const isOfficer = computed(() => page.props.auth.user.role_id === 2);
</script>
