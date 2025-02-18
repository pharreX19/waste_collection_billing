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
                                        <TextInput
                                            name="name"
                                            label="ގޭގެ ނަން"
                                            :disabled="!!props.id"
                                            v-model="form.name"
                                            :errors="errors"
                                            dir="rtl"
                                            lang="dv"
                                        />
                                    </div>

                                    <div class="sm:col-span-4">
                                        <TextInput
                                            name="registration_no"
                                            label="ރަޖިސްޓްރޭޝަން ނަންބަރ"
                                            :disabled="!!props.id"
                                            v-model="form.registration_no"
                                            :errors="errors"
                                        />
                                    </div>

                                    <div class="sm:col-span-4">
                                        <SelectInput
                                            label="ގޭގެ ކެޓަގަރީ"
                                            name="property_category_id"
                                            v-model="form.property_category_id"
                                            :options="categories"
                                            :errors="errors"
                                        />
                                    </div>

                                    <div class="sm:col-span-4">
                                        <TextInput
                                            type="date"
                                            name="registration_date"
                                            label="ރަޖިސްޓްރީކުރެވުނު ތާރީޚް"
                                            :disabled="!!props.id"
                                            v-model="form.registration_date"
                                            :errors="errors"
                                        />
                                    </div>
                                </div>
                            </div>

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
                                    <div
                                        class="sm:col-span-4"
                                        v-if="
                                            !isGovernmentProperty ||
                                            (isGovernmentProperty && index > 0)
                                        "
                                    >
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
                                                    class="col-start-1 row-start-1 block w-full rounded-r-md bg-white py-1.5 pr-3 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                                    dir="ltr"
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
                                    <br v-if="!isGovernmentProperty" />

                                    <div class="sm:col-span-4">
                                        <TextInput
                                            name="name"
                                            label="ފުރިހަމަ ނަން"
                                            :disabled="
                                                !!props.id && index === 0
                                            "
                                            v-model="person.name"
                                            dir="rtl"
                                            lang="dv"
                                        />
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
                                        <TextInput
                                            name="contact_no"
                                            label="މޯބައިލް ނަންބަރ"
                                            :disabled="
                                                !!props.id && index === 0
                                            "
                                            v-model="person.contact_no"
                                            pattern="\d*"
                                            maxlength="7"
                                        />
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
                                </div>

                                <div class="flex gap-3 mt-3" v-if="index === 0">
                                    <CheckboxInput
                                        name="responsible_person"
                                        @update:modelValue="
                                            addResponsiblePersons
                                        "
                                        label="މަސްއޫލުވެރިފަރާތަކީ ވެރިފަރާތްކަމުގައި ނުވާނަމަ"
                                        :modelValue="
                                            responsiblePersonIsNotOwner
                                        "
                                    />
                                </div>
                            </div>
                        </div>

                        <div
                            class="mt-6 flex items-center justify-start gap-x-6"
                        >
                            <Button @click="onCancel" variant="cancel" />

                            <Button type="submit" variant="submit" />
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
import { useForm } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import Button from "@/components/Button.vue";
import TextInput from "@/components/UI/TextInput.vue";
import SelectInput from "@/components/UI/SelectInput.vue";
import CheckboxInput from "@/components/UI/CheckboxInput.vue";

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
const currentDate = new Date();
const registration_date = `${currentDate.getFullYear()}-${String(
    currentDate.getMonth() + 1
).padStart(2, "0")}-${String(currentDate.getDate()).padStart(2, "0")}`;

const form = useForm({
    property_category_id: null,
    name: null,
    registration_no: null,
    registration_date: registration_date,
    responsible_persons: [
        {
            name: null,
            national_id: null,
            contact_no: null,
        },
    ],
});

const responsiblePersonIsNotOwner = computed(
    () => form.responsible_persons.length > 1
);

onMounted(() => {
    fetchPropertyCategories();
    if (props.id) {
        fetchProperty();
    }
});

const onSubmit = function () {
    emit("submit:form", form);
    if (!props.errors) {
        form.reset();
    }
};

const onCancel = function () {
    emit("cancel:form");
    form.reset();
};

const addResponsiblePersons = (value) => {
    if (value) {
        form.responsible_persons.push({
            name: null,
            national_id: null,
            contact_no: null,
        });
    } else {
        form.responsible_persons.pop();
    }
};

const isGovernmentProperty = computed(
    () =>
        categories.value.find(
            (category) => category.id === form.property_category_id
        )?.is_government === 1 || false
);

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
        form.registration_date = data.registration_date.split("T")[0];
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
        form.responsible_persons[index].contact_no = data.contact_no;
    } catch (error) {
        console.error("Error fetching person ", error);
    }
};
</script>

<style lang="scss" scoped></style>
