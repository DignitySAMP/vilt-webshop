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
            <Link
                :href="create()"
                class="w-50"
            >
            <AppFormButton class="flex" name="btn_redirect_create" text="Add Category" :icon="IconCreate"/>
            </Link>
        </template>

        <template v-slot:body>
            <CategorySearch/>

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
                                                edit(
                                                    category.id,
                                                )
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
import { usePage, Link } from "@inertiajs/vue3";

import { ItemCategory } from "@/types";
import { type PageProps } from "@/types/inertia";
import { edit, create } from "@/wayfinder/routes/category";

import AppAdminLayout from "@/layout/AppAdminLayout.vue";
import AppPagination from "@/components/AppPagination.vue";

import CategoryDelete from "@/pages/item_category/Delete.vue";
import CategorySearch from '@/pages/item_category/partials/PartialIndex_Search.vue'

import IconEdit from "@/icons/IconEdit.vue";
import IconCreate from "@/icons/IconCreate.vue";
import AppFormButton from "@/components/form/AppFormButton.vue";

const categories: ItemCategory[] = usePage<PageProps>().props.categories.data;
</script>
