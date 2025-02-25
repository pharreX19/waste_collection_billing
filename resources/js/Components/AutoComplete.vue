<template>
    <div class="w-full relative">
        <TextInput
            name="name"
            label=""
            :placeholder="placeholder"
            v-model="modelValue.name"
            @update:modelValue="handleInput"
            autoComplete="off"
            dir="rtl"
            lang="dv"
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
import TextInput from "@/components/UI/TextInput.vue";

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

const handleInput = async (value) => {
    isOpen.value = true;
    search.value = value;
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
