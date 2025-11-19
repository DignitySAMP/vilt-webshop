<template>
    <AppAdminLayout>
        <template v-slot:header>
            <div
                class="w-full flex flex-col justify-center items-center md:block"
            >
                <h1
                    class="text-2xl font-bold text-slate-900"
                    v-html="usePage<PageProps>().props.app.name ?? 'Laravel'"
                />
                <p class="text-sm text-slate-500 mt-1">Supplier Management</p>
            </div>
            <Link
                :href="route('item.create')"
                class="min-w-40 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2 font-medium"
            >
                <IconCreate />

                Add Supplier
            </Link>
        </template>

        <template v-slot:body>
            <div
                class="bg-white rounded-xl shadow-sm border border-slate-200 mb-6"
            >
                <div class="p-4 flex gap-4 items-center">
                    <div class="flex relative w-full">
                        <IconSearch
                            class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"
                        />

                        <input
                            v-model="searchQuery"
                            @change="onSearch"
                            type="text"
                            placeholder="Search suppliers..."
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
                                    Pending Orders
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider"
                                >
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            <tr v-if="suppliers.length < 1" class="p-2">
                                <td
                                    colspan="5"
                                    class="px-6 py-4 text-center text-slate-400"
                                >
                                    <span> There are no suppliers. </span>
                                </td>
                            </tr>
                            <tr
                                v-else
                                v-for="supplier in suppliers"
                                :key="supplier.id"
                                class="hover:bg-slate-50 transition-colors"
                            >
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="font-medium text-slate-900">
                                            {{ supplier.name }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-slate-900">
                                        {{ supplier.description }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-slate-900">
                                        {{ supplier.pending_orders }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div
                                        class="flex items-center justify-end gap-2"
                                    >
                                        <Link
                                            :href="
                                                route(
                                                    'supplier.show',
                                                    supplier.id,
                                                )
                                            "
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                        >
                                            <IconView />
                                        </Link>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <AppPagination
                class="mt-4"
                v-bind="usePage<PageProps>().props.suppliers"
            />
        </template>
    </AppAdminLayout>
</template>
<script setup lang="ts">
import { usePage, router, Link } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";

import AppAdminLayout from "@/layout/AppAdminLayout.vue";
import AppPagination from "@/components/AppPagination.vue";

import IconView from "@/icons/IconView.vue";
import IconCreate from "@/icons/IconCreate.vue";
import IconSearch from "@/icons/IconSearch.vue";

// props
import { Supplier } from "@/types";

import { type PageProps } from "@/types/inertia";

// data
const suppliers: Supplier[] = usePage<PageProps>().props.suppliers.data;

// search queries
const searchQuery = ref("");

const onSearch = () => {
    router.get(
        route("supplier.index"),
        {
            // data
            search: searchQuery.value,
        },
        {
            // options
            replace: true,
        },
    );
};

onMounted(() => (searchQuery.value = usePage<PageProps>().props.filter.search));
</script>
