<template>
    <div class="px-4 sm:px-6 lg:px-8 space-y-8">
        <div class="flex flex-row gap-8 mt-2">
            <div class="min-w-52">
                <select
                    id="year"
                    name="year"
                    v-model="form.selectedOption"
                    class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                >
                    <option v-for="option in options" :value="option">
                        {{ option.label }}
                    </option>
                </select>
            </div>

            <div class="w-80">
                <AutoComplete
                    v-model="form.property"
                    :value="form.property.name"
                    placeholder="ގޭގެ ނަން"
                />
            </div>

            <div v-if="form.selectedOption.id === 3">
                <input
                    id="start"
                    name="start"
                    type="date"
                    v-model="form.start_date"
                    class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                />
            </div>
            <div v-if="form.selectedOption.id === 3">
                <input
                    id="end"
                    name="end"
                    type="date"
                    v-model="form.end_date"
                    class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                />
            </div>
            <Link
                type="button"
                class="rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500"
                :href="reportLink"
                :headers="{ Accept: 'text/html', 'Content-Type': 'text/html' }"
            >
                ރިޕޯރޓް ދައްކާ
            </Link>

            <Menu as="div" class="relative inline-block text-left">
                <div>
                    <MenuButton
                        class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                    >
                        ޑައުންލޯޑް ކުރައްވާ
                        <ChevronDownIcon
                            class="-mr-1 size-5 text-gray-400"
                            aria-hidden="true"
                        />
                    </MenuButton>
                </div>

                <transition
                    enter-active-class="transition ease-out duration-100"
                    enter-from-class="transform opacity-0 scale-95"
                    enter-to-class="transform opacity-100 scale-100"
                    leave-active-class="transition ease-in duration-75"
                    leave-from-class="transform opacity-100 scale-100"
                    leave-to-class="transform opacity-0 scale-95"
                >
                    <MenuItems
                        class="absolute right-0 z-10 mt-2 w-36 text-right origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
                    >
                        <div class="py-1">
                            <MenuItem v-slot="{ active }">
                                <a
                                    :href="`${reportDownloadLink}&format=csv`"
                                    :class="[
                                        active
                                            ? 'bg-gray-100 text-gray-900 outline-none'
                                            : 'text-gray-700',
                                        'block px-4 py-2 text-sm',
                                    ]"
                                    >ސީއެސްވީ</a
                                >
                            </MenuItem>
                            <MenuItem v-slot="{ active }">
                                <a
                                    :href="`${reportDownloadLink}&format=pdf`"
                                    :class="[
                                        active
                                            ? 'bg-gray-100 text-gray-900 outline-none'
                                            : 'text-gray-700',
                                        'block px-4 py-2 text-sm',
                                    ]"
                                    >ޕީޑީއެފް</a
                                >
                            </MenuItem>
                        </div>
                    </MenuItems>
                </transition>
            </Menu>
        </div>
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div
                    class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8"
                >
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                            <tr>
                                <th
                                    scope="col"
                                    class="py-3.5 pl-4 pr-3 text-right text-sm font-semibold text-gray-900 sm:pl-0"
                                >
                                    <a href="#" class="group inline-flex">
                                        ގޭގެ ނަން
                                        <span
                                            class="invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible"
                                        >
                                            <ChevronDownIcon
                                                class="size-5"
                                                aria-hidden="true"
                                            />
                                        </span>
                                    </a>
                                </th>
                                <th
                                    scope="col"
                                    class="py-3.5 pl-4 pr-3 text-right text-sm font-semibold text-gray-900 sm:pl-0"
                                >
                                    <a href="#" class="group inline-flex">
                                        ބިލްކުރެވުނު މުއްދަތު
                                        <span
                                            class="invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible"
                                        >
                                            <ChevronDownIcon
                                                class="size-5"
                                                aria-hidden="true"
                                            />
                                        </span>
                                    </a>
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900"
                                >
                                    <a href="#" class="group inline-flex">
                                        ރަސީދު ނަންބަރ
                                        <span
                                            class="mr-3 flex-none rounded bg-gray-100 text-gray-900 group-hover:bg-gray-200"
                                        >
                                            <ChevronDownIcon
                                                class="size-5"
                                                aria-hidden="true"
                                            />
                                        </span>
                                    </a>
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900"
                                >
                                    <a href="#" class="group inline-flex">
                                        މުއްދަތުހަމަވާ ތާރީޚް
                                        <span
                                            class="invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible"
                                        >
                                            <ChevronDownIcon
                                                class="invisible ml-2 size-5 flex-none rounded text-gray-400 group-hover:visible group-focus:visible"
                                                aria-hidden="true"
                                            />
                                        </span>
                                    </a>
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900"
                                >
                                    <a href="#" class="group inline-flex">
                                        މަހުފީ
                                        <span
                                            class="invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible"
                                        >
                                            <ChevronDownIcon
                                                class="invisible ml-2 size-5 flex-none rounded text-gray-400 group-hover:visible group-focus:visible"
                                                aria-hidden="true"
                                            />
                                        </span>
                                    </a>
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900"
                                >
                                    <a href="#" class="group inline-flex">
                                        ޖޫރިމަނާ
                                        <span
                                            class="invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible"
                                        >
                                            <ChevronDownIcon
                                                class="invisible ml-2 size-5 flex-none rounded text-gray-400 group-hover:visible group-focus:visible"
                                                aria-hidden="true"
                                            />
                                        </span>
                                    </a>
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900"
                                >
                                    <a href="#" class="group inline-flex">
                                        ދައްކަންޖެހޭ ޖުމްލަ
                                        <span
                                            class="invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible"
                                        >
                                            <ChevronDownIcon
                                                class="invisible ml-2 size-5 flex-none rounded text-gray-400 group-hover:visible group-focus:visible"
                                                aria-hidden="true"
                                            />
                                        </span>
                                    </a>
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900"
                                >
                                    <a href="#" class="group inline-flex">
                                        ދެއްކި ޖުމްލަ
                                        <span
                                            class="invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible"
                                        >
                                            <ChevronDownIcon
                                                class="invisible ml-2 size-5 flex-none rounded text-gray-400 group-hover:visible group-focus:visible"
                                                aria-hidden="true"
                                            />
                                        </span>
                                    </a>
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900"
                                >
                                    <a href="#" class="group inline-flex">
                                        ސްޓޭޓަސް
                                        <span
                                            class="invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible"
                                        >
                                            <ChevronDownIcon
                                                class="invisible ml-2 size-5 flex-none rounded text-gray-400 group-hover:visible group-focus:visible"
                                                aria-hidden="true"
                                            />
                                        </span>
                                    </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <tr v-for="payable in data" :key="payable.id">
                                <td
                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0"
                                >
                                    {{ payable.property.name }}
                                </td>
                                <td
                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0"
                                >
                                    {{
                                        dayjs(payable.billed_period).format(
                                            "MMMM YYYY"
                                        )
                                    }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                >
                                    {{ payable.receipt_no }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                >
                                    {{
                                        dayjs(payable.due_date).format(
                                            "DD MMMM YYYY"
                                        )
                                    }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                >
                                    {{ payable.amount }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                >
                                    {{ payable.fine }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                >
                                    {{ payable.grand_total }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                >
                                    {{
                                        NumberFormatter.format(
                                            payable.grand_total -
                                                payable.balance
                                        )
                                    }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                >
                                    {{ stateMappings[payable.state] }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <Pagination :links="links" v-if="data.length > 0" />
    </div>
</template>

<script setup>
import { ChevronDownIcon } from "@heroicons/vue/20/solid";
import dayjs from "../../utils/dayjs";
import Pagination from "@/components/Pagination.vue";
import { Link, useForm } from "@inertiajs/vue3";
import AutoComplete from "@/components/AutoComplete.vue";
import { computed, onMounted } from "vue";
import { payableStates, stateMappings } from "../../utils/stateMapping";
import { NumberFormatter } from "../../utils/numberFormatter";
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";

const props = defineProps({
    data: {
        type: Array,
        required: true,
    },
    links: {
        type: Array,
    },
});

const options = [
    { id: 1, label: "މި އަހަރުގެ ރިޕޯރޓް" },
    { id: 2, label: "ފާއިތުވެ ދިޔަ އަހަރުގެ ރިޕޯރޓް" },
    { id: 3, label: "އިތުރު" },
];

const form = useForm({
    selectedOption: options[0],
    start_date: null,
    end_date: null,
    property: {
        name: null,
    },
});

const currentDate = new Date();
const previousYear = currentDate.getFullYear() - 1;

const reportLink = computed(() => {
    return route(
        "payables.reports",
        {
            start_date:
                form.selectedOption.id == 2
                    ? `${previousYear}-01-01`
                    : form.start_date,
            end_date: form.selectedOption.id == 3 ? form.end_date : "",
            name: form.property.name,
        },
        {}
    );
});

const reportDownloadLink = computed(() => {
    return route(
        "payables.download-reports",
        {
            start_date:
                form.selectedOption.id == 2
                    ? `${previousYear}-01-01`
                    : form.start_date,
            end_date: form.selectedOption.id == 3 ? form.end_date : "",
            name: form.property.name,
        },
        {}
    );
});

onMounted(() => {
    const url = new URL(window.location.href);

    const startDate = url.searchParams.get("start_date");
    const endDate = url.searchParams.get("end_date");
    const name = url.searchParams.get("name");

    form.selectedOption =
        !startDate && !endDate
            ? options[0]
            : startDate && endDate
            ? options[2]
            : options[1];

    form.property.name = name;

    if (form.selectedOption.id == 3) {
        form.start_date = startDate;
        form.end_date = endDate;
    }
});
</script>
