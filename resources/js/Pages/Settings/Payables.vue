<template>
    <div class="px-4 sm:px-6 lg:px-8 max-w-2xl">
        <div>
            <dl class="mt-6 divide-y divide-gray-100 text-sm/6">
                <div
                    class="py-6 sm:flex"
                    v-for="(item, index) in data"
                    :key="item.id"
                >
                    <dt
                        class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6"
                    >
                        {{ keyMapping(item.key) }}
                    </dt>
                    <dd
                        class="mt-1 flex justify-between gap-x-6 sm:mt-0 sm:flex-auto"
                    >
                        <div class="text-gray-900">
                            {{
                                index == 0
                                    ? `${NumberFormatter.format(
                                          item.value
                                      )} ރުފިޔާ`
                                    : `${item.value} ދުވަސް`
                            }}

                            <transition name="slide">
                                <input
                                    v-if="activeIndex === index"
                                    type="number"
                                    step="0.1"
                                    name="fine_amount"
                                    id="fine_amount"
                                    dir="ltr"
                                    v-model="form[index].value"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                />
                            </transition>
                        </div>

                        <button
                            type="button"
                            @click="toggleEdit(index)"
                            class="font-semibold text-indigo-600 hover:text-indigo-500"
                        >
                            {{
                                activeIndex === index
                                    ? "ރައްކާ ކުރުން"
                                    : "އެޑިޓް ކުރުން"
                            }}
                        </button>
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { NumberFormatter } from "../../utils/numberFormatter";
import { useForm } from "@inertiajs/vue3";
const props = defineProps({
    data: {
        type: Array,
        required: true,
    },
});

const form = useForm(props.data);

const mappings = {
    fine_amount: "ޖޫރިމަނާ ކުރެވޭ ޢަދަދު",
    validity_period: "ބިލް ދައްކަން ލިބޭ މުއްދަތު",
};

const activeIndex = ref(null);

const toggleEdit = (index) => {
    activeIndex.value = activeIndex.value === index ? null : index;
    if (activeIndex.value === null) {
        updateSetting();
    }
};

const updateSetting = async () => {
    form.put(route("settings.update"), {
        preserveScroll: true,
    });
};

const keyMapping = (key) => {
    return mappings[key];
};
</script>

<style scoped>
.slide-enter-active,
.slide-leave-active {
    transition: max-height 0.3s ease-out, opacity 0.3s ease;
    overflow: hidden;
}
.slide-enter-from,
.slide-leave-to {
    max-height: 0;
    opacity: 0;
}
.slide-enter-to,
.slide-leave-from {
    max-height: 100px; /* Adjust as needed */
    opacity: 1;
}
</style>
