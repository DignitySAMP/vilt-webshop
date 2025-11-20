<template>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 mb-6">
        <div class="p-4 flex flex-col md:flex-row gap-4 items-center">
            <AppFormInputSearch
                placeholder="Search products..."
                @on-search-query="onSearch"
                v-model="searchQuery"
            />

            <AppFormSelect
                @change="onSearch"
                name="category"
                :options="
                    categories.map((cat: { id: number; name: string }) => ({
                        value: cat.id,
                        label: cat.name,
                    }))
                "
                v-model="categoryQuery"
            />
        </div>
    </div>
</template>

<script setup lang="ts">
import { usePage, router } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";

import { index } from "@/wayfinder/routes/item";
import { ItemCategory } from "@/types";
import { type PageProps } from "@/types/inertia";

import AppFormSelect from "@/components/form/AppFormSelect.vue";
import AppFormInputSearch from "@/components/form/AppFormInputSearch.vue";

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
