<template>
    <AppAdminLayout>
        <template v-slot:header>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    {{ usePage<PageProps>().props.app.name ?? "Laravel" }}
                </h1>
                <p class="text-sm text-slate-500 mt-1">
                    Product Management
                </p>
            </div>
            <Link
                :href="route('item.create')"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2 font-medium"
            >
                <IconCreate />

                Add Product
            </Link>
        </template>

        <template v-slot:body>
            <div
                class="bg-white rounded-xl shadow-sm border border-slate-200 mb-6"
            >
                <div class="p-4 flex gap-4 items-center">
                    <div class="flex relative w-full">
                        <IconSearch />

                        <input
                            v-model="searchQuery"
                            @change="onSearch"
                            type="text"
                            placeholder="Search products..."
                            class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-lg outline-none focus:border-blue-600 transition-colors"
                        />
                    </div>
                    <select
                        v-model="categoryQuery"
                        @change="onSearch"
                        class="px-4 py-2 border border-slate-200 rounded-lg outline-none focus:border-blue-600 transition-colors"
                    >
                        <option
                            v-for="cat in categories"
                            :key="cat.id"
                            :value="cat.id"
                        >
                            {{ cat.name }}
                        </option>
                    </select>
                </div>
            </div>

            <div
                class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden"
            >
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider"
                                >
                                    Product
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider"
                                >
                                    Category
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider"
                                >
                                    Price
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider"
                                >
                                    Stock
                                </th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider"
                                >
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            <tr v-if="products.length < 1" class="p-2">
                                <td
                                    colspan="5"
                                    class="px-6 py-4 text-center text-slate-400"
                                >
                                    <span> There are no items. </span>
                                </td>
                            </tr>
                            <tr
                                v-else
                                v-for="product in products"
                                :key="product.id"
                                class="hover:bg-slate-50 transition-colors"
                            >
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img
                                            :src="product.image_url"
                                            class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center text-xl"
                                        />
                                        <div class="font-medium text-slate-900">
                                            {{ product.name }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 capitalize"
                                    >
                                        {{ product.item_category.name }}
                                    </span>
                                </td>
                                <td
                                    class="px-6 py-4 text-slate-900 font-medium"
                                >
                                    ${{ product.price.toFixed(2) }}
                                </td>

                                <td class="px-6 py-4">
                                    <span
                                        :class="[
                                            'text-sm font-medium',
                                            product.stock > 50
                                                ? 'text-green-600'
                                                : product.stock > 20
                                                  ? 'text-yellow-600'
                                                  : 'text-red-600',
                                        ]"
                                    >
                                        {{ product.stock }} units
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div
                                        class="flex items-center justify-end gap-2"
                                    >
                                        <Link
                                            :href="
                                                route('item.edit', product.id)
                                            "
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                        >
                                            <IconEdit />
                                        </Link>

                                        <div class="text-left">
                                            <ItemDelete v-bind="product" />
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <AppPagination
                class="mt-4"
                v-bind="usePage<PageProps>().props.items"
            />
        </template>
    </AppAdminLayout>
</template>
<script setup lang="ts">
import { usePage, router, Link } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";

import AppAdminLayout from "@/layout/AppAdminLayout.vue";
import AppPagination from "@/components/AppPagination.vue";

import ItemDelete from "@/pages/item/Delete.vue";

import IconEdit from "@/icons/IconEdit.vue";
import IconCreate from "@/icons/IconCreate.vue";
import IconSearch from "@/icons/IconSearch.vue";

// props
import { Item, ItemCategory } from "@/types";
import type { PaginationData } from "@/types/pagination";
interface PageProps extends Record<string, unknown> {
    items: PaginationData<Item>;
    categories: ItemCategory[];
    filter: {
        category: number;
        search: string;
    };
}

// data
const products: Item[] = usePage<PageProps>().props.items.data;
const categories: ItemCategory[] = usePage<PageProps>().props.categories;

// search queries
const categoryQuery = ref(1);
const searchQuery = ref("");

const onSearch = () => {
    router.get(
        route("item.index"),
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
