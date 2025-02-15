<template>
    <div
        class="flex flex-col min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
    >
        <div
            id="printable-content"
            class="w-full flex flex-col justify-between items-center p-8 rounded-lg relative"
        >
            <!-- Header Section -->
            <div class="flex justify-between w-full">
                <div class="text-right w-full">
                    <h1 class="text-base font-bold">
                        އޭދަފުށި ރަށު ކައުންސިލް އިދާރާ
                    </h1>
                    <p class="text-xs">ބ އޭދަފުށި</p>
                </div>
                <div class="text-left w-full">
                    <h1 class="text-base font-bold">
                        ރަސީދު ނަންބަރ:
                        <span>{{ payable.receipt_no }}</span>
                    </h1>
                    <p class="text-xs">
                        ތާރީޚް:
                        <span>{{
                            dayjs(payable.updated_at).format("DD MMMM YYYY")
                        }}</span>
                    </p>
                </div>
            </div>

            <!-- Invoice Title -->
            <div class="font-bold w-full text-center">
                <h1 class="text-xl underline">ފައިސާ ބަލައިގަތް ރަސީރު</h1>
            </div>

            <!-- Details Section -->
            <div class="mt-5 text-right grid grid-cols-5 gap-2 w-full">
                <p class="font-bold">ނަން</p>
                <p class="col-span-4 text-base font-normal">
                    {{ payable.property.name }}
                </p>

                <p class="font-bold">ތަފްޞީލު</p>
                <p class="col-span-4 text-base font-normal">
                    {{ dayjs(payable.billed_period).format("MMMM YYYY") }}
                    ގެ ކުނިނެގުމުގެ ފީ
                </p>

                <p class="font-bold">މަހު ފީ</p>
                <p class="col-span-4 text-base font-normal">
                    {{ NumberFormatter.format(payable.amount) }}
                </p>

                <p class="font-bold">ޖޫރިމަނާ</p>
                <p class="col-span-4 text-base font-normal">
                    {{
                        payable.fine == 0
                            ? "-"
                            : NumberFormatter.format(payable.fine)
                    }}
                </p>

                <p class="font-bold">ޖުމްލަ ދައްކަންޖެހޭ</p>
                <p class="col-span-4 text-base font-normal">
                    {{ NumberFormatter.format(payable.grand_total) }}
                </p>

                <p class="font-bold">ޖުމްލަ ދެއްކި</p>
                <div class="col-span-4">
                    <p class="col-span-4 text-base font-normal">
                        {{
                            NumberFormatter.format(
                                payable.grand_total - payable.balance
                            )
                        }}
                    </p>
                </div>

                <p class="font-bold">ފައިސާ ދެއްކި ތާރީޚް</p>
                <p class="col-span-4 text-base font-normal">
                    {{ dayjs(payable.updated_at).format("DD MMMM YYYY HH:MM") }}
                </p>
            </div>

            <!-- Footer Section -->
            <div class="grid grid-cols-2 w-full text-smr">
                <div class="col-start-2 text-center">
                    <p class="font-bold">ފައިސާ ބަލައިގަތް</p>
                    <!-- <p class="text-base font-normal">
                            {{ page.props.auth.user.name }}
                        </p> -->
                </div>
            </div>

            <div class="text-sm">
                {{ dayjs(payable.updated_at).format("DD MMMM YYYY") }}
            </div>
        </div>
        <div class="mt-10 flex flex-row items-center justify-around min-w-80">
            <Button label="ފަހަތަށް" variant="cancel" @click="onCancel" />
            <Button label="ޕްރިންޓް ކުރައްވާ" @click="onPrint" />
        </div>
    </div>
</template>

<script setup>
import dayjs from "../../utils/dayjs";
import { router } from "@inertiajs/vue3";
import { NumberFormatter } from "../../utils/numberFormatter";
import Button from "@/components/Button.vue";

const props = defineProps({
    payable: {
        type: Object,
        required: true,
    },
});

const onPrint = () => {
    window.print();
};

const onCancel = () => {
    const year = props.payable.billed_period.split("-")[0];
    router.visit(
        route("payables.index", {
            property: props.payable.property_id,
            year: year,
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
