<template>
    <div class="min-h-screen bg-slate-50">
        <Header />

        <div
            class="grid md:grid-cols-[180px_1fr] lg:grid-cols-[280px_1fr] gap-4 p-3 md:p-6 max-w-[1800px] mx-auto"
        >
            <Filters @on-search="onSearch" />

            <main class="space-y-6">
                <div
                    class="bg-white rounded-xl p-4 shadow-sm border border-slate-200"
                >
                    <div class="flex items-center gap-3">
                        <IconSearch class="size-5 text-slate-400" />
                        <input
                            @change="
                                onSearch(
                                    usePage<PageProps>().props.filter.category,
                                    usePage<PageProps>().props.filter
                                        .price_range,
                                )
                            "
                            v-model="searchText"
                            type="text"
                            placeholder="Search products..."
                            class="flex-1 outline-none text-slate-700"
                        />
                    </div>
                </div>

                <div
                    class="grid md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-4"
                >
                    <ItemCard
                        v-for="product in items"
                        :key="product.id"
                        v-bind="product"
                    />
                </div>
            </main>
        </div>
    </div>
</template>
<script setup lang="ts">
import Header from "@/pages/home/partials/Header.vue";
import Filters from "@/pages/home/partials/Filters.vue";

import ItemCard from "./partials/ItemCard.vue";
import IconSearch from "@/icons/IconSearch.vue";

import { ItemCategory, Item } from "@/types";
import { ref } from "vue";
import { router, usePage } from "@inertiajs/vue3";

interface PageProps extends Record<string, unknown> {
    categories: ItemCategory[];
    item: Item;
}
const items = usePage<PageProps>().props.items.data;

const searchText = ref<string>(usePage<PageProps>().props.filter.search);
const onSearch = (category: number, price_range: number) => {
    console.log(searchText.value, category, price_range);
    router.get(
        route("home"),
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

//onMounted(() => (searchQuery.value = usePage<PageProps>().props.filter.search));
</script>
