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
                        <div class="space-y-12 text-right">
                            <div
                                class="border-b border-gray-900/10 pb-12"
                                v-for="(
                                    person, index
                                ) in form.responsible_persons"
                                :key="index"
                            >
                                <h2
                                    class="text-base/7 font-semibold text-gray-900"
                                >
                                    {{
                                        index === 0
                                            ? "ވެރިފަރާތުގެ މަޢުލޫމާތު"
                                            : "މަސްއޫލުވެރިފަރާތުގެ މަޢުލޫމާތު"
                                    }}
                                </h2>

                                <div
                                    class="mt-5 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-8"
                                >
                                    <div class="sm:col-span-4">
                                        <label
                                            for="national_id"
                                            class="block text-sm/6 font-medium text-gray-900"
                                            >އައިޑީ ކާޑް ނަންބަރ</label
                                        >
                                        <div class="mt-2 flex">
                                            <div
                                                class="-mr-px grid grow grid-cols-1 focus-within:relative"
                                            >
                                                <input
                                                    class="col-start-1 row-start-1 block w-full rounded-r-md bg-white py-1.5 pl-10 pr-3 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:pl-9 sm:text-sm/6"
                                                    name="national_id"
                                                    id="national_id"
                                                    maxlength="7"
                                                    v-model="person.national_id"
                                                    :disabled="
                                                        props.id && index === 0
                                                    "
                                                />
                                            </div>
                                            <button
                                                :disabled="
                                                    props.id && index === 0
                                                "
                                                type="button"
                                                @click="searchPerson(index)"
                                                class="flex shrink-0 items-center gap-x-1.5 rounded-l-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 hover:bg-gray-50 focus:relative focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"
                                            >
                                                <MagnifyingGlassIcon
                                                    class="-ml-0.5 size-4 text-gray-400"
                                                    aria-hidden="true"
                                                />
                                            </button>
                                        </div>
                                        <div
                                            class="text-xs text-red-600 mt-1"
                                            v-if="
                                                errors[
                                                    `responsible_persons.${index}.national_id`
                                                ]
                                            "
                                        >
                                            {{
                                                errors[
                                                    `responsible_persons.${index}.national_id`
                                                ]
                                            }}
                                        </div>
                                    </div>

                                    <div class="sm:col-span-4">
                                        <label
                                            for="name"
                                            class="block text-sm/6 font-medium text-gray-900"
                                            >ފުރިހަމަ ނަން</label
                                        >
                                        <div class="mt-2">
                                            <ThaanaInput
                                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                                name="name"
                                                id="name"
                                                v-model="person.name"
                                                :value="person.name"
                                                :disabled="
                                                    props.id && index === 0
                                                "
                                            />
                                        </div>
                                        <div
                                            class="text-xs text-red-600 mt-1"
                                            v-if="
                                                errors[
                                                    `responsible_persons.${index}.name`
                                                ] &&
                                                errors[
                                                    `responsible_persons.${index}.name`
                                                ].indexOf('property name') < 0
                                            "
                                        >
                                            {{
                                                errors[
                                                    `responsible_persons.${index}.name`
                                                ]
                                            }}
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
                                                type="text"
                                                pattern="\d*"
                                                maxlength="7"
                                                v-model="person.contact_no"
                                                :disabled="
                                                    props.id && index === 0
                                                "
                                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                            />
                                        </div>
                                        <div
                                            class="text-xs text-red-600 mt-1"
                                            v-if="
                                                errors[
                                                    `responsible_persons.${index}.contact_no`
                                                ]
                                            "
                                        >
                                            {{
                                                errors[
                                                    `responsible_persons.${index}.contact_no`
                                                ]
                                            }}
                                        </div>
                                    </div>

                                    <div class="sm:col-span-4">
                                        <label
                                            for="address"
                                            class="block text-sm/6 font-medium text-gray-900"
                                            >ދާއިމީ އެޑްރެސް</label
                                        >
                                        <div class="mt-2">
                                            <ThaanaInput
                                                type="text"
                                                name="address"
                                                id="address"
                                                v-model="person.address"
                                                :value="person.address"
                                                :disabled="
                                                    props.id && index === 0
                                                "
                                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                            />
                                        </div>
                                        <div
                                            class="text-xs text-red-600 mt-1"
                                            v-if="
                                                errors[
                                                    `responsible_persons.${index}.address`
                                                ]
                                            "
                                        >
                                            {{
                                                errors[
                                                    `responsible_persons.${index}.address`
                                                ]
                                            }}
                                        </div>
                                    </div>
                                </div>

                                <div class="flex gap-3 mt-3" v-if="index === 0">
                                    <div class="flex h-6 shrink-0 items-center">
                                        <div
                                            class="group grid size-4 grid-cols-1"
                                        >
                                            <input
                                                id="responsible_person"
                                                aria-describedby="responsible_person"
                                                name="responsible_person"
                                                type="checkbox"
                                                :checked="
                                                    form.responsible_persons
                                                        .length > 1
                                                "
                                                @change="addResponsiblePersons"
                                                class="col-start-1 row-start-1 appearance-none rounded border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto"
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
                                    </div>
                                    <div class="text-sm/6">
                                        <span
                                            id="comments-description"
                                            class="text-gray-500"
                                            >މަސްއޫލުވެރިފަރާތަކީ
                                            ވެރިފަރާތްކަމުގައި ނުވާނަމަ</span
                                        >
                                    </div>
                                </div>
                            </div>

                            <div class="border-b border-gray-900/10 pb-12">
                                <h2
                                    class="text-base/7 font-semibold text-gray-900"
                                >
                                    ގޭބިސީގެ މަޢުލޫމާތު
                                </h2>

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
                                            <ThaanaInput
                                                type="text"
                                                name="name"
                                                id="name"
                                                v-model="form.name"
                                                :disabled="props.id"
                                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                            />
                                        </div>
                                        <div
                                            class="text-xs text-red-600 mt-1"
                                            v-if="
                                                errors.name &&
                                                errors.name.indexOf(
                                                    'property name'
                                                ) > 0
                                            "
                                        >
                                            {{ errors.name }}
                                        </div>
                                    </div>

                                    <div class="sm:col-span-4">
                                        <label
                                            for="registration_no"
                                            class="block text-sm/6 font-medium text-gray-900"
                                            >ރަޖިސްޓްރޭޝަން ނަންބަރ</label
                                        >
                                        <div class="mt-2">
                                            <input
                                                type="text"
                                                name="registration_no"
                                                id="registration_no"
                                                v-model="form.registration_no"
                                                :disabled="props.id"
                                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                            />
                                        </div>
                                        <div
                                            class="text-xs text-red-600 mt-1"
                                            v-if="errors.registration_no"
                                        >
                                            {{ errors.registration_no }}
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
                                                v-model="
                                                    form.property_category_id
                                                "
                                                class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                            >
                                                <option
                                                    v-for="category in categories"
                                                    :value="category.id"
                                                >
                                                    {{ category.name }}
                                                </option>
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
                                :disabled="form.processing"
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
import { router, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import ThaanaInput from "thaana-keyboard-vue/src/ThaanaInput.vue";

const props = defineProps({
    errors: {
        type: Object,
        required: false,
    },

    id: {
        type: String,
        required: false,
    },
});

const emit = defineEmits(["submit:form", "cancel:form"]);
const categories = ref([]);

const form = useForm({
    property_category_id: null,
    name: null,
    registration_no: null,
    registration_date: new Date(),
    responsible_persons: [
        {
            name: null,
            national_id: null,
            contact_no: null,
            address: null,
            island: "Eydhafushi",
        },
    ],
});

onMounted(() => {
    fetchPropertyCategories();
    if (props.id) {
        fetchProperty();
    }
});

const onSubmit = function () {
    emit("submit:form", form);
};

const onCancel = function () {
    emit("cancel:form");
};

const addResponsiblePersons = (event) => {
    if (event.target.checked) {
        form.responsible_persons.push({
            name: null,
            national_id: null,
            contact_no: null,
            address: null,
            island: "Eydhafushi",
        });
    } else {
        form.responsible_persons.pop();
    }
};

const fetchPropertyCategories = async () => {
    try {
        const response = await fetch(route("categories.index"));
        if (!response.ok) {
            throw new Error("Network response was not ok");
        }
        categories.value = await await response.json().then((value) => value);
        if (!props.id) {
            form.property_category_id = categories.value[0].id;
        }
    } catch (error) {
        console.error("Error fetching companies", error);
    }
};

const fetchProperty = async () => {
    try {
        const response = await fetch(route("properties.show", props.id));
        if (!response.ok) {
            throw new Error("Network response was not ok");
        }
        const data = await response.json();
        form.property_category_id = data.property_category_id;
        form.name = data.name;
        form.registration_no = data.registration_no;
        form.responsible_persons = data.responsible_persons;
    } catch (error) {
        console.error("Error fetching companies", error);
    }
};

const searchPerson = async (index) => {
    try {
        const response = await fetch(
            route("people.search", {
                nid: form.responsible_persons[index].national_id,
            })
        );
        if (!response.ok) {
            throw new Error("Network response was not ok");
        }
        const data = await response.json();
        form.responsible_persons[index].national_id = data.national_id;
        form.responsible_persons[index].name = data.name;
        form.responsible_persons[index].address = "ހެލޯވާރލްޑް";
        form.responsible_persons[index].contact_no = data.contact_no;
    } catch (error) {
        console.error("Error fetching companies", error);
    }
};
</script>

<style lang="scss" scoped></style>
