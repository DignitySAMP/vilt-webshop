<template>
    <AppLayout>
        <div
            class="grid md:grid-cols-[180px_1fr] lg:grid-cols-[280px_1fr] gap-4 p-3 md:p-6 max-w-[1800px] mx-auto"
        >
            <Filters @on-search="onSearch" />

            <main class="space-y-6">
                <div
                    class="bg-white rounded-xl p-4 shadow-sm border border-slate-200"
                >
                    <AppFormInputSearch
                        placeholder="Search for your next purchase..."
                        :borders="false"
                        @on-search-query="onSearch"
                        v-model="searchText"
                    />
                </div>

                <div
                    v-if="items.length > 0"
                    class="grid md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-4"
                >
                    <ItemCard
                        v-for="product in items"
                        :key="product.id"
                        v-bind="product"
                    />
                </div>

                <div v-else class="w-full flex justify-center items-center">
                    <span class="w-full text-slate-700 text-center">
                        No items found.
                    </span>
                </div>
            </main>
        </div>
    </AppLayout>
</template>
<script setup lang="ts">
import { ref } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import { home } from "@/wayfinder/routes";

import AppLayout from "@/layout/AppLayout.vue";
import Filters from "@/pages/home/partials/Filters.vue";

import ItemCard from "./partials/ItemCard.vue";

import { type PageProps } from "@/types/inertia";
import AppFormInputSearch from "@/components/form/AppFormInputSearch.vue";
const items = usePage<PageProps>().props.items.data;

const searchText = ref<string>(usePage<PageProps>().props.filter.search);
const onSearch = (category: number, price_range: number) => {
    router.get(
        home(),
        {
            // data
            search: searchText.value,
            category: category,
            price_range: price_range,
        },
        {
            // options
            replace: true,
        },
    );
};
</script>
