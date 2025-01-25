<template>
    <div class="mx-auto max-w-2xl text-center">
        <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
            {{ voucher.reference }}
        </h2>
        <p class="mt-2 text-lg leading-8 text-gray-600">
            {{ voucher.title }}
        </p>
    </div>
    <div
        id="printable-content"
        class="max-w-3xl flex flex-col justify-start items-center p-8 rounded-lg relative"
    >
        <div class="grid grid-cols-3 w-[100%]">
            <div>
                <h1 class="text-xs font-bold">{{ voucher.company.name }}</h1>
                <p class="text-xs">{{ voucher.company.address }}</p>
                <p class="text-xs">{{ voucher.company.street }}</p>
                <p class="text-xs">Male`, {{ voucher.company.zip_code }}</p>
                <p class="text-xs">Tel: {{ voucher.company.telephone }}</p>
            </div>

            <div class="text-lg text-center underline font-bold">
                PAYMENT VOUCHER
            </div>

            <div class="text-right">
                <h2 class="text-xs font-semibold">
                    <span class="font-normal">Reference: </span>
                    {{ voucher.reference }}
                </h2>
                <p class="text-xs">
                    Date: {{ dayjs(voucher.created_at).format("DD MMM YYYY") }}
                </p>
                <p class="text-xs" v-if="voucher.bank">
                    Bank: {{ voucher.bank.short_code }}
                </p>
                <p class="text-xs" v-if="!voucher.cheque_no">
                    Payment Method: {{ voucher.payment_method.name }}
                </p>
                <p class="text-xs" v-if="voucher.cheque_no">
                    Cheque No: {{ voucher.cheque_no }}
                </p>
                <p class="text-xs" v-if="voucher.cheque_date">
                    Cheque Dated: {{ voucher.cheque_date }}
                </p>
                <p class="text-xs">
                    Currency: {{ voucher.currency.short_code }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 mb-1">
            <p class="text-xs font-medium">
                <span class="font-bold text-xs mr-3">Title of Account: </span>
                {{ voucher.title }}
            </p>
            <p class="text-xs font-medium">
                <span class="font-bold text-xs mr-16">Pay To: </span>
                {{ voucher.favour }}
            </p>
        </div>

        <table border="border">
            <thead>
                <tr>
                    <th class="qty text-left text-xs">Particular</th>
                    <th class="dsc text-xs">Reference</th>
                    <th class="price text-xs">
                        {{ voucher.currency.short_code }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in voucher.voucher_items">
                    <td class="qty text-xs">{{ item.particular }}</td>
                    <td class="dsc text-xs">
                        {{ item.reference }}
                    </td>
                    <td class="price text-xs">
                        {{ NumberFormatter.format(item.amount) }}
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="text-xs w-full">
                    <td colspan="2" class="wording p-1 font-medium">
                        Total {{ voucher.currency.short_code }}:
                        {{
                            toWords(voucher.total, voucher.currency.short_code)
                                .charAt(0)
                                .toUpperCase() +
                            toWords(
                                voucher.total,
                                voucher.currency.short_code
                            ).slice(1)
                        }}
                        Only
                    </td>

                    <td class="border text-right p-1 font-bold">
                        {{ NumberFormatter.format(voucher.total) }}
                    </td>
                </tr>
            </tfoot>
        </table>

        <div
            class="absolute bottom-8 right-8 left-8 grid grid-cols-4 text-center text-gray-600 h-10"
        >
            <div class="border border-gray-300 text-xs">Entered by:</div>
            <div class="border border-gray-300 text-xs">Checked by:</div>
            <div class="border border-gray-300 text-xs">Authorized by:</div>
            <div class="border border-gray-300 text-xs">Received by:</div>
        </div>
    </div>
</template>

<script setup>
import { onMounted } from "vue";
// import { formatCurrency, NumberFormatter } from "../../utils/currencyFormatter";
// import { toWords } from "../../utils/numberWording";
import { router } from "@inertiajs/vue3";
import dayjs from "dayjs";

const props = defineProps({
    voucher: {
        type: Object,
        required: true,
    },
});

onMounted(() => {
    window.addEventListener("afterprint", () => {
        router.get(route("vouchers.index"));
    });
    window.print();
});
</script>

<style scoped>
table {
    width: 100%;
    table-layout: fixed;
}

table,
th,
td {
    border: 1px solid rgb(234, 232, 232);
}

.qty {
    width: 65%;
    text-align: left;
    padding-right: 4px;
    padding: 3px;
    text-overflow: clip;
    overflow: hidden;
    /* text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden; */
}
.price {
    width: 15%;
    text-align: right;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    text-align: right;
    padding: 3px;
}
.dsc {
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    width: 25%;
    max-width: 25%;
    text-align: left;
    padding: 3px;
}

.wording {
    border-left: 1px solid transparent;
    border-bottom: 1px solid transparent;
}
</style>

<style>
@media screen {
    #printable-content {
        max-width: 210mm; /* A5 width */
        height: 148mm; /* A5 height */
        margin: 20px auto;
        padding: 10mm;
        /* background: white; */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
}

@media print {
    body {
        visibility: hidden;
    }
    #printable-content {
        visibility: visible;
    }

    #printable-content {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        padding: 10mm;
    }

    @page {
        size: A5 landscape;
        margin: 0;
    }

    button {
        display: none !important;
    }
}
</style>
