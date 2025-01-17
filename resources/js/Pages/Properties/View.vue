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
                                10000ރ
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
                            <dd class="text-sm/6 text-gray-900">ޖަންބުމާގެ</dd>
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
                                އަޙްމަދު މުޙައްމަދު ދީދީ
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
                                <time datetime="2023-01-31"
                                    >23 ޖަނަވަރީ 2023</time
                                >
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
                class="-mx-4 px-4 py-8 shadow-sm ring-1 ring-gray-900/5 sm:mx-0 sm:rounded-lg sm:px-8 lg:col-span-2 lg:row-span-2 lg:row-end-2"
            >
                <YearSelector />
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
                                މަސް
                            </th>
                            <th
                                scope="col"
                                class="hidden py-3 pl-8 pr-0 text-right font-semibold sm:table-cell"
                            >
                                ޖުމްލަ
                            </th>
                            <th
                                scope="col"
                                class="py-3 pl-8 pr-0 text-right font-semibold"
                            >
                                ފައިސާ ދެއްކި ތާރީޚް
                            </th>
                            <th
                                scope="col"
                                class="py-3 pl-8 pr-0 text-right font-semibold"
                            >
                                ރަސީދު ޕްރިންޓް ކުރުން
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="item in invoice.items"
                            :key="item.id"
                            class="border-b border-gray-100 hover:bg-gray-50 cursor-pointer"
                        >
                            <td class="max-w-0 px-0 py-5 align-top text-right">
                                <div class="truncate font-medium text-gray-900">
                                    {{ item.title }}
                                </div>
                                <div class="truncate text-gray-500">
                                    {{ item.description }}
                                </div>
                            </td>
                            <td
                                class="hidden py-5 pl-8 pr-0 text-right align-top tabular-nums text-gray-700 sm:table-cell"
                            >
                                {{ item.rate }}
                            </td>
                            <td
                                class="hidden py-5 pl-8 pr-0 text-right align-top tabular-nums text-gray-700 sm:table-cell"
                            >
                                {{ item.price }}
                            </td>

                            <td
                                class="py-5 pl-8 pr-0 text-right align-top tabular-nums text-gray-700"
                            >
                                {{ item.hours }}
                            </td>
                            <td
                                class="py-5 pl-8 pr-0 text-right align-top tabular-nums text-gray-700"
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

            <!-- <div class="lg:col-start-3">
                <h2 class="text-sm/6 font-semibold text-gray-900">
                    އިތުރު ތަފްޞީލް
                </h2>
                <ul role="list" class="mt-6 space-y-6">
                    <li
                        v-for="(activityItem, activityItemIdx) in activity"
                        :key="activityItem.id"
                        class="relative flex gap-x-4"
                    >
                        <div
                            :class="[
                                activityItemIdx === activity.length - 1
                                    ? 'h-6'
                                    : '-bottom-6',
                                'absolute left-0 top-0 flex w-6 justify-center',
                            ]"
                        ></div>
                        <div
                            class="relative flex size-6 flex-none items-center justify-center bg-white"
                        >
                            <div
                                class="size-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300"
                            />
                        </div>
                        <p class="flex-auto py-0.5 text-xs/5 text-gray-500">
                            <span class="font-medium text-gray-900">{{
                                activityItem.person.name
                            }}</span>
                            {{ activityItem.type }}
                        </p>
                        <time
                            :datetime="activityItem.dateTime"
                            class="flex-none py-0.5 text-xs/5 text-gray-500"
                            >{{ activityItem.date }}</time
                        >
                    </li>
                </ul>
            </div> -->
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

const invoice = {
    subTotal: "ރ8,800.00",
    tax: "ރ1,760.00",
    total: "ރ10,560.00",
    items: [
        {
            id: 1,
            title: "މަހު ފީ 250ރ",
            description: "ޖޫރިމަނާ 30ރ",
            hours: "2 ޖަނަވަރީ 2023",
            rate: "މެއި 2023",
            price: "300ރ",
        },
        {
            id: 2,
            title: "މަހު ފީ 250ރ",
            description: "",
            hours: "2 ފެބްރުއަރީ 2023",
            rate: "ޖޫން 2023",
            price: "300ރ",
        },
        {
            id: 3,
            title: "މަހު ފީ 250ރ",
            description: "ޖޫރިމަނާ 30ރ",
            hours: "2 މާރޗް 2023",
            rate: "ޖުލައި 2023",
            price: "300ރ",
        },
        {
            id: 4,
            title: "މަހު ފީ 250ރ",
            description: "ޖޫރިމަނާ 30ރ",
            hours: "2 އެޕްރީލް 2023",
            rate: "އޮގަސްޓް 2023",
            price: "300ރ",
        },
        {
            id: 5,
            title: "މަހު ފީ 250ރ",
            description: "ޖޫރިމަނާ 30ރ",
            hours: "2 މާރޗް 2023",
            rate: "ޖުލައި 2023",
            price: "300ރ",
        },
        {
            id: 6,
            title: "މަހު ފީ 250ރ",
            description: "ޖޫރިމަނާ 30ރ",
            hours: "2 އެޕްރީލް 2023",
            rate: "އޮގަސްޓް 2023",
            price: "300ރ",
        },
        {
            id: 7,
            title: "މަހު ފީ 250ރ",
            description: "ޖޫރިމަނާ 30ރ",
            hours: "2 ޖަނަވަރީ 2023",
            rate: "މެއި 2023",
            price: "300ރ",
        },
        {
            id: 8,
            title: "މަހު ފީ 250ރ",
            description: "",
            hours: "2 ފެބްރުއަރީ 2023",
            rate: "ޖޫން 2023",
            price: "300ރ",
        },
        {
            id: 9,
            title: "މަހު ފީ 250ރ",
            description: "ޖޫރިމަނާ 30ރ",
            hours: "2 މާރޗް 2023",
            rate: "ޖުލައި 2023",
            price: "300ރ",
        },
        {
            id: 10,
            title: "މަހު ފީ 250ރ",
            description: "ޖޫރިމަނާ 30ރ",
            hours: "2 އެޕްރީލް 2023",
            rate: "އޮގަސްޓް 2023",
            price: "300ރ",
        },
        {
            id: 11,
            title: "މަހު ފީ 250ރ",
            description: "ޖޫރިމަނާ 30ރ",
            hours: "2 މާރޗް 2023",
            rate: "ޖުލައި 2023",
            price: "300ރ",
        },
        {
            id: 12,
            title: "މަހު ފީ 250ރ",
            description: "ޖޫރިމަނާ 30ރ",
            hours: "2 އެޕްރީލް 2023",
            rate: "އޮގަސްޓް 2023",
            price: "300ރ",
        },
    ],
};

const activity = [
    {
        id: 1,
        type: "މަހުގެ ކުނި ނެގުމުގެ ފީ",
        person: { name: "މެއި" },
        date: "7d ago",
        dateTime: "2023-01-23T10:32",
    },
    {
        id: 2,
        type: "މަހުގެ ކުނި ނެގުމުގެ ފީ",
        person: { name: "އޭޕްރީލް" },
        date: "6d ago",
        dateTime: "2023-01-23T11:03",
    },
    {
        id: 3,
        type: "މަހުގެ ކުނި ނެގުމުގެ ފީ",
        person: { name: "މެއި" },
        date: "6d ago",
        dateTime: "2023-01-23T11:24",
    },
    {
        id: 4,
        type: "މަހުގެ ކުނި ނެގުމުގެ ފީ",
        person: { name: "ޖޫން" },
        date: "2d ago",
        dateTime: "2023-01-24T09:12",
    },
    {
        id: 5,
        type: "މަހުގެ ކުނި ނެގުމުގެ ފީ",
        person: { name: "ޖުލައި" },
        date: "1d ago",
        dateTime: "2023-01-24T09:20",
    },
];
</script>
