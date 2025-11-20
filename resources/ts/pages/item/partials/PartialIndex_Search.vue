<template>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 mb-6">
        <div class="p-4 flex flex-col md:flex-row gap-4 items-center">
            <div class="flex relative w-full">
                <IconSearch
                    class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"
                />

                <input
                    v-model="searchQuery"
                    @change="onSearch"
                    type="text"
                    placeholder="Search products..."
                    class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-lg outline-none focus:border-blue-600 transition duration-300"
                />
            </div>
            <select
                v-model="categoryQuery"
                @change="onSearch"
                class="w-full px-4 py-2 border border-slate-200 rounded-lg outline-none focus:border-blue-600 transition duration-300"
            >
                <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                    {{ cat.name }}
                </option>
            </select>
        </div>
    </div>
</template>

<script setup lang="ts">
import { usePage, router } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";

import { index } from "@/wayfinder/routes/item";
import { ItemCategory } from "@/types";
import { type PageProps } from "@/types/inertia";

import IconSearch from "@/icons/IconSearch.vue";

const categories: ItemCategory[] = usePage<PageProps>().props.categories;
const categoryQuery = ref(1);
const searchQuery = ref("");

const onSearch = () => {
    router.get(
        index(),
        {
            // data
            search: searchQuery.value,
            category: categoryQuery.value,
        },
        {
            // options
            replace: true,
        },
    );
};

onMounted(() => {
    searchQuery.value = usePage<PageProps>().props.filter.search;
    categoryQuery.value = usePage<PageProps>().props.filter.category;
});
</script>
