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
                <p class="text-sm text-slate-500 mt-1">Product Management</p>
            </div>
            <Link class="w-50" :href="create()">
                <AppFormButton
                    class="flex"
                    name="btn_redirect_create"
                    text="Add Product"
                    :icon="IconCreate"
                />
            </Link>
        </template>

        <template v-slot:body>
            <ItemSearch />

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
                                            class="size-10 bg-slate-100 rounded-lg flex items-center justify-center text-xl"
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
                                        {{
                                            product.item_category?.name ||
                                            "Unknown"
                                        }}
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
                                            :href="edit(product.id)"
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                        >
                                            <IconEdit class="size-4" />
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
import { usePage, Link } from "@inertiajs/vue3";

import { Item } from "@/types";
import { type PageProps } from "@/types/inertia";
import { create, edit } from "@/wayfinder/routes/item";
import AppAdminLayout from "@/layout/AppAdminLayout.vue";

import ItemSearch from "@/pages/item/partials/PartialIndex_Search.vue";
import ItemDelete from "@/pages/item/Delete.vue";

import AppPagination from "@/components/AppPagination.vue";

import IconEdit from "@/icons/crud/IconEdit.vue";
import IconCreate from "@/icons/crud/IconCreate.vue";
import AppFormButton from "@/components/form/AppFormButton.vue";

const products: Item[] = usePage<PageProps>().props.items.data;
</script>
