<template>
    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
        <button
            type="button"
            @click="handeModalOpen"
            class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
        >
            ގޭބިސި ރަޖިސްޓްރީ ކުރައްވާ
        </button>
    </div>
    <TransitionRoot as="template" :show="open">
        <Dialog class="relative z-10" @close="open = false">
            <TransitionChild
                as="template"
                enter="ease-out duration-300"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="ease-in duration-200"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-gray-500/75 transition-opacity" />
            </TransitionChild>

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
                            class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-xl sm:p-6"
                        >
                            <form @submit.prevent="onSave">
                                <div class="space-y-12 text-right">
                                    <div
                                        class="border-b border-gray-900/10 pb-12"
                                    >
                                        <h2
                                            class="text-base/7 font-semibold text-gray-900"
                                        >
                                            ވެރިފަރާތުގެ މަޢުލޫމާތު
                                        </h2>
                                        <!-- <p class="mt-1 text-sm/6 text-gray-600">
                                            Use a permanent address where you
                                            can receive mail.
                                        </p> -->

                                        <div
                                            class="mt-5 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-8"
                                        >
                                            <div class="sm:col-span-4">
                                                <label
                                                    for="query"
                                                    class="block text-sm/6 font-medium text-gray-900"
                                                    >އައިޑީ ކާޑް ނަންބަރ</label
                                                >
                                                <div class="mt-2 flex">
                                                    <div
                                                        class="-mr-px grid grow grid-cols-1 focus-within:relative"
                                                    >
                                                        <input
                                                            type="text"
                                                            name="query"
                                                            id="query"
                                                            class="col-start-1 row-start-1 block w-full rounded-r-md bg-white py-1.5 pl-10 pr-3 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:pl-9 sm:text-sm/6"
                                                        />
                                                    </div>
                                                    <button
                                                        type="button"
                                                        class="flex shrink-0 items-center gap-x-1.5 rounded-l-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 hover:bg-gray-50 focus:relative focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"
                                                    >
                                                        <MagnifyingGlassIcon
                                                            class="-ml-0.5 size-4 text-gray-400"
                                                            aria-hidden="true"
                                                        />
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="sm:col-span-4">
                                                <label
                                                    for="name"
                                                    class="block text-sm/6 font-medium text-gray-900"
                                                    >ފުރިހަމަ ނަން</label
                                                >
                                                <div class="mt-2">
                                                    <input
                                                        type="text"
                                                        name="name"
                                                        id="name"
                                                        autocomplete="given-name"
                                                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                                    />
                                                </div>
                                            </div>

                                            <div class="sm:col-span-4">
                                                <label
                                                    for="contact_no"
                                                    class="block text-sm/6 font-medium text-gray-900"
                                                    >މޯބައިލް ނަންބަރ</label
                                                >
                                                <div class="mt-2">
                                                    <input
                                                        id="contact_no"
                                                        name="contact_no"
                                                        type="contact_no"
                                                        autocomplete="contact_no"
                                                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                                    />
                                                </div>
                                            </div>

                                            <div class="sm:col-span-4">
                                                <label
                                                    for="address"
                                                    class="block text-sm/6 font-medium text-gray-900"
                                                    >ދާއިމީ އެޑްރެސް</label
                                                >
                                                <div class="mt-2">
                                                    <input
                                                        type="text"
                                                        name="address"
                                                        id="address"
                                                        autocomplete="address"
                                                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="border-b border-gray-900/10 pb-12"
                                    >
                                        <h2
                                            class="text-base/7 font-semibold text-gray-900"
                                        >
                                            ގޭބިސީގެ މަޢުލޫމާތު
                                        </h2>
                                        <!-- <p class="mt-1 text-sm/6 text-gray-600">
                                            Use a permanent address where you
                                            can receive mail.
                                        </p> -->

                                        <div
                                            class="mt-5 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-8"
                                        >
                                            <div class="sm:col-span-4">
                                                <label
                                                    for="name"
                                                    class="block text-sm/6 font-medium text-gray-900"
                                                    >ގޭގެ ނަން</label
                                                >
                                                <div class="mt-2">
                                                    <input
                                                        type="text"
                                                        name="name"
                                                        id="name"
                                                        autocomplete="given-name"
                                                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                                    />
                                                </div>
                                            </div>

                                            <div class="sm:col-span-4">
                                                <label
                                                    for="registration_no"
                                                    class="block text-sm/6 font-medium text-gray-900"
                                                    >ރަޖިސްޓްރޭޝަން
                                                    ނަންބަރ</label
                                                >
                                                <div class="mt-2">
                                                    <input
                                                        type="text"
                                                        name="registration_no"
                                                        id="registration_no"
                                                        autocomplete="family-name"
                                                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                                    />
                                                </div>
                                            </div>

                                            <div class="sm:col-span-4">
                                                <label
                                                    for="property_category_id"
                                                    class="block text-sm/6 font-medium text-gray-900"
                                                    >ގޭގެ ކެޓަގަރީ</label
                                                >
                                                <div class="mt-2">
                                                    <select
                                                        id="property_category_id"
                                                        name="property_category_id"
                                                        class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                                    >
                                                        <option>
                                                            United States
                                                        </option>
                                                        <option selected="">
                                                            Canada
                                                        </option>
                                                        <option>Mexico</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="mt-6 flex items-center justify-start gap-x-6"
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
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import { ref } from "vue";
import { PhotoIcon, UserCircleIcon } from "@heroicons/vue/24/solid";
import { ChevronDownIcon } from "@heroicons/vue/16/solid";
import {
    Dialog,
    DialogPanel,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import { CheckIcon } from "@heroicons/vue/24/outline";
import { MagnifyingGlassIcon, UsersIcon } from "@heroicons/vue/16/solid";

const open = ref(false);

const handeModalOpen = () => {
    open.value = true;
};

const onCancel = () => {
    open.value = false;
};

const onSave = () => {
    open.value = false;
};
</script>
