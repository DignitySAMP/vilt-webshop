<template>
    <AppAdminLayout title="Category Management">
        <template v-slot:header>
            <Link
                :href="route('category.create')"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2 font-medium"
            >
                <IconCreate />

                Add New Category
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
                            placeholder="Search categories..."
                            class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-lg outline-none focus:border-blue-600 transition-colors"
                        />
                    </div>
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
                                    Name
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider"
                                >
                                    Description
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider"
                                >
                                    Items
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider"
                                >
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            <tr v-if="categories.length < 1" class="p-2">
                                <td
                                    colspan="5"
                                    class="px-6 py-4 text-center text-slate-400"
                                >
                                    <span> There are no categories. </span>
                                </td>
                            </tr>
                            <tr
                                v-else
                                v-for="category in categories"
                                :key="category.id"
                                class="hover:bg-slate-50 transition-colors"
                            >
                            <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="font-medium text-slate-900">
                                            {{ category.name }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="font-medium text-slate-900">
                                            {{ category.description }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="font-medium text-slate-900">
                                            {{ category.item_count }}
                                        </div>
                                    </div>
                                </td>
                               
                                <td class="px-6 py-4 text-right">
                                    <div
                                        class="flex items-center justify-end gap-2"
                                    >
                                        <Link
                                            :href="
                                                route('category.edit', category.id)
                                            "
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                        >
                                            <IconEdit />
                                        </Link>

                                        <div class="text-left">
                                            <CategoryDelete v-bind="category" />
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
                v-bind="usePage<PageProps>().props.categories"
            />
        </template>
    </AppAdminLayout>
</template>
<script setup lang="ts">
import { usePage, router, Link } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";

import AppAdminLayout from "@/layout/AppAdminLayout.vue";
import AppPagination from "@/components/AppPagination.vue";

import CategoryDelete from "@/pages/item_category/Delete.vue";

import IconEdit from "@/icons/IconEdit.vue";
import IconCreate from "@/icons/IconCreate.vue";
import IconSearch from "@/icons/IconSearch.vue";

// props
import { ItemCategory } from "@/types";
interface PageProps extends Record<string, unknown> {
    categories: ItemCategory[];
    filter: {
        category: number;
        search: string;
    };
}
const categories: ItemCategory[] = usePage<PageProps>().props.categories.data;

// search queries
const searchQuery = ref("");

const onSearch = () => {
    router.get(
        route("category.index"),
        {
            // data
            search: searchQuery.value
        },
        {
            // options
            replace: true,
        },
    );
};

onMounted(() => searchQuery.value = usePage<PageProps>().props.filter.search);
</script>
