<template>
    <div class="w-full relative">
        <ThaanaInput
            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
            :value="modelValue.name"
            @input="handleInput"
            :placeholder="placeholder"
        />
        <ul
            class="mt-1 w-full max-h-60 border border-gray-200 rounded-md bg-white absolute overflow-y-auto z-20"
            v-show="searchResults.length && isOpen"
        >
            <li
                class="text-sm px-4 py-3 border-b border-gray-100 text-stone-600 cursor-pointer hover:bg-gray-100 transition-colors"
                v-for="result in searchResults"
                :key="result.value"
                @click.stop="setSelected(result)"
            >
                {{ result.name }}
            </li>
        </ul>
    </div>
</template>

<script setup>
import { computed, ref } from "vue";
import ThaanaInput from "thaana-keyboard-vue/src/ThaanaInput.vue";

const props = defineProps({
    modelValue: {
        type: Object,
        required: true,
    },
    placeholder: {
        type: String,
        required: false,
    },

    // fieldValue: {
    //     type: String,
    //     required: true,
    // },
});

const emit = defineEmits(["update:modelValue"]);

const isOpen = ref(false);
const search = ref("");
let debounceTimeout = null;
const source = ref([]);

const searchResults = computed(() => {
    if (!search.value) {
        return [];
    }

    return source.value.filter((item) => {
        if (item.name.toLowerCase().includes(search.value.toLowerCase())) {
            return item;
        }
    });
});

const debounceSearch = () => {
    if (debounceTimeout) clearTimeout(debounceTimeout);

    debounceTimeout = setTimeout(async () => {
        await fetchSearchResults();
    }, 300);
};

const setSelected = (item) => {
    isOpen.value = false;
    search.value = item.name;
    emit("update:modelValue", item);
};

const handleInput = async (event) => {
    isOpen.value = true;
    search.value = event.target.value;
    emit("update:modelValue", { name: search.value, id: null });
    await debounceSearch();
};

const fetchSearchResults = async () => {
    if (!search.value) return;
    try {
        const response = await fetch(
            route("properties.index", {
                query: search.value,
            })
        );
        if (!response.ok) {
            throw new Error("Network response was not ok");
        }
        source.value = await response.json();
    } catch (error) {
        console.error("Error fetching companies", error);
    }
};
</script>

<style scoped></style>
