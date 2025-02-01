<template>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div
            class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
        >
            <TransitionChild
                as="template"
                enter="ease-out duration-300"
                enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                enter-to="opacity-100 translate-y-0 sm:scale-100"
                leave="ease-in duration-200"
                leave-from="opacity-100 translate-y-0 sm:scale-100"
                leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            >
                <DialogPanel
                    class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl sm:p-6"
                >
                    <form @submit.prevent="onSubmit">
                        <div class="space-y-6 text-right">
                            <h2 class="text-base/7 font-semibold text-gray-900">
                                ދައްކަންޖެހޭ ފައިސާގެ ތަފްޞީލު
                            </h2>

                            <table
                                class="min-w-full table-fixed divide-y divide-gray-300"
                            >
                                <thead>
                                    <tr>
                                        <th
                                            scope="col"
                                            class="relative px-7 sm:w-12 sm:px-6"
                                        >
                                            <div
                                                class="group absolute left-4 top-1/2 -mt-2 grid size-4 grid-cols-1"
                                            >
                                                <input
                                                    type="checkbox"
                                                    class="col-start-1 row-start-1 appearance-none rounded border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto"
                                                    :checked="
                                                        indeterminate ||
                                                        selectedPayables.length ===
                                                            payables.length
                                                    "
                                                    :indeterminate="
                                                        indeterminate
                                                    "
                                                    @change="
                                                        selectedPayables =
                                                            $event.target
                                                                .checked
                                                                ? payables.map(
                                                                      (p) => p
                                                                  )
                                                                : []
                                                    "
                                                />
                                                <svg
                                                    class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-[:disabled]:stroke-gray-950/25"
                                                    viewBox="0 0 14 14"
                                                    fill="none"
                                                >
                                                    <path
                                                        class="opacity-0 group-has-[:checked]:opacity-100"
                                                        d="M3 8L6 11L11 3.5"
                                                        stroke-width="2"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                    />
                                                    <path
                                                        class="opacity-0 group-has-[:indeterminate]:opacity-100"
                                                        d="M3 7H11"
                                                        stroke-width="2"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                    />
                                                </svg>
                                            </div>
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900"
                                        >
                                            މުއްދަތު
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900"
                                        >
                                            މަހުފީ
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900"
                                        >
                                            ޖޫރިމަނާ
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900"
                                        >
                                            މުއްދަތުހަމަވާ ތާރީޚް
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900"
                                        >
                                            ޖުމްލަ
                                        </th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="divide-y divide-gray-200 bg-white"
                                >
                                    <tr
                                        v-for="payable in payables"
                                        :key="payable.id"
                                        :class="[
                                            selectedPayables.includes(
                                                payable
                                            ) && 'bg-gray-50',
                                        ]"
                                    >
                                        <td
                                            class="relative px-7 sm:w-12 sm:px-6"
                                        >
                                            <div
                                                v-if="
                                                    selectedPayables.includes(
                                                        payable
                                                    )
                                                "
                                                class="absolute inset-y-0 left-0 w-0.5 bg-indigo-600"
                                            ></div>
                                            <div
                                                class="group absolute left-4 top-1/2 -mt-2 grid size-4 grid-cols-1"
                                            >
                                                <input
                                                    type="checkbox"
                                                    class="col-start-1 row-start-1 appearance-none rounded border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto"
                                                    :value="payable"
                                                    v-model="selectedPayables"
                                                />
                                                <svg
                                                    class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-[:disabled]:stroke-gray-950/25"
                                                    viewBox="0 0 14 14"
                                                    fill="none"
                                                >
                                                    <path
                                                        class="opacity-0 group-has-[:checked]:opacity-100"
                                                        d="M3 8L6 11L11 3.5"
                                                        stroke-width="2"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                    />
                                                    <path
                                                        class="opacity-0 group-has-[:indeterminate]:opacity-100"
                                                        d="M3 7H11"
                                                        stroke-width="2"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                    />
                                                </svg>
                                            </div>
                                        </td>
                                        <td
                                            :class="[
                                                'whitespace-nowrap py-4 pr-3 text-sm font-medium',
                                                selectedPayables.includes(
                                                    payable
                                                )
                                                    ? 'text-indigo-600'
                                                    : 'text-gray-900',
                                            ]"
                                        >
                                            {{
                                                dayjs(
                                                    payable.billed_period
                                                ).format("MMMM YYYY")
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
                                            {{
                                                dayjs(payable.due_date).format(
                                                    "DD MMMM YYYY"
                                                )
                                            }}
                                        </td>
                                        <td
                                            class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                        >
                                            {{ payable.grand_total }}
                                        </td>
                                    </tr>
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td
                                            class="whitespace-nowrap px-3 py-4 text-base font-bold text-black"
                                        >
                                            އެކު ޖުމްލަ
                                        </td>
                                        <td
                                            class="whitespace-nowrap px-3 py-4 text-base font-bold text-black"
                                        >
                                            {{
                                                NumberFormatter.format(
                                                    total_due
                                                )
                                            }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div
                            class="mt-3 flex items-center justify-start gap-x-6"
                        >
                            <button
                                @click="onCancel"
                                type="button"
                                class="text-sm/6 font-semibold text-gray-900"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                            >
                                Save
                            </button>
                        </div>
                    </form>
                </DialogPanel>
            </TransitionChild>
        </div>
    </div>
</template>

<script setup>
import { MagnifyingGlassIcon } from "@heroicons/vue/16/solid";
import { onMounted } from "vue";
import { DialogPanel, TransitionChild } from "@headlessui/vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import dayjs from "../utils/dayjs";
import { NumberFormatter } from "../utils/numberFormatter";

const props = defineProps({
    errors: {
        type: Object,
        required: false,
    },

    id: {
        type: String,
        required: true,
    },
});

const payables = ref([]);
const selectedPayables = ref([]);

const indeterminate = computed(
    () =>
        selectedPayables.value.length > 0 &&
        selectedPayables.value.length < payables.length
);

const total_due = computed(() => {
    return selectedPayables.value.reduce(
        (acc, item) => acc + parseFloat(item.grand_total),
        0
    );
});

const emit = defineEmits(["cancel:form"]);

const page = usePage();
// const form = useForm({
//     selectedPayables: [],
// });

onMounted(() => {
    fetchProperty();
});

const onSubmit = async () => {
    if (selectedPayables.value.length == 0) return;

    const body = selectedPayables.value.map((payable) => ({
        payable_id: payable.id,
        amount: payable.grand_total,
    }));

    try {
        const response = await fetch(route("payments.store"), {
            method: "POST",
            body: JSON.stringify(body),
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": page.props.csrf_token,
            },
        });
        if (!response.ok) {
            throw new Error("Network response was not ok", response);
        }

        selectedPayables.value = [];
        fetchProperty();
    } catch (error) {
        console.error("Error fetching companies", error);
    }

    // form.transform((data) =>
    //     data.selectedPayables.map((payable) => ({
    //         payable_id: payable.id,
    //         amount: payable.grand_total,
    //     }))
    // ).post(route("payments.store"), {
    //     onSuccess: () => fetchProperty(),
    //     onError: (err) => console.log("error", error),
    // });
};

const onCancel = function () {
    emit("cancel:form");
};

const fetchProperty = async () => {
    try {
        const response = await fetch(
            route("payables.index", {
                property: props.id,
                state: "pending",
            }),
            {
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                },
            }
        );
        if (!response.ok) {
            throw new Error("Network response was not ok");
        }
        const data = await response.json();
        payables.value = data.property.payables;
    } catch (error) {
        console.error("Error fetching companies", error);
    }
};
</script>
