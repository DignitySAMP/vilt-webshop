<template>
    <AppAdminLayout>
        <template v-slot:header>
            <div class="flex items-center gap-4">
                <Link
                    :href="route('supplier.index')"
                    class="p-2 hover:bg-slate-100 rounded-lg transition duration-300"
                >
                    <IconBack />
                </Link>
                <div class="w-full flex flex-col justify-center items-center md:block">
                    <h1 class="text-2xl font-bold text-slate-900">
                        View Supplier
                    </h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Manage supplier contacts, addresses or orders
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <Link
                    as="button"
                    :href="route('supplier.edit', supplier.id)"
                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300 flex items-center gap-2 font-medium"
                >
                    <IconEdit />

                    Edit Supplier
                </Link>
            </div>
        </template>

        <template v-slot:body>
            <div class="grid md:grid-cols-2 gap-4">
                <div class="bg-white rounded-sm shadow p-4 flex flex-col gap-4">
                    <span class="text-lg font-bold text-gray-500">
                        Information
                    </span>

                    <div class="flex flex-col">
                        <span class="text-gray-600 font-bold"> Name: </span>
                        {{ supplier.name }}
                    </div>

                    <div class="flex flex-col">
                        <span class="text-gray-600 font-bold">
                            Description:
                        </span>
                        {{ supplier.description }}
                    </div>
                </div>
                <div class="bg-white rounded-sm shadow p-4 flex flex-col gap-2">
                    <span class="text-lg font-bold"> Orders </span>

                    <div class="flex flex-col gap-1">
                        <span class="text-sm text-gray-500">
                            Filter orders:
                        </span>

                        <div class="flex gap-2">
                            <select
                                class="w-full px-4 py-2 border border-slate-200 rounded-lg outline-none focus:border-blue-600 transition duration-300"
                            >
                                <option>Show all statusses</option>
                                <option>Show pending orders</option>
                                <option>Show processing orders</option>
                                <option>Show finished orders</option>
                            </select>

                            <select
                                class="w-full px-4 py-2 border border-slate-200 rounded-lg outline-none focus:border-blue-600 transition duration-300"
                            >
                                <option>Oldest to newest creation</option>
                                <option>Newest to oldest creation</option>
                                <option>Oldest to newest update</option>
                                <option>Newest to oldest update</option>
                                <option>No updates</option>
                                <option>Oldest update</option>
                                <option>Most recent update</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2">
                        <div
                            v-for="order in supplier_orders"
                            :key="order.id"
                            class="px-4 py-2 rounded border grid grid-cols-2 shadow text-sm"
                            :class="[
                                {
                                    'bg-red-100 border-red-200 text-red-800':
                                        order.status === 'pending',
                                },

                                {
                                    'bg-amber-100 border-amber-200 text-amber-800':
                                        order.status === 'processing',
                                },

                                {
                                    'bg-emerald-100 border-emerald-200 text-emerald-800':
                                        order.status === 'completed',
                                },
                            ]"
                        >
                            <div class="flex gap-1">
                                <span class="font-bold"> ID: </span>
                                {{ order.id }}
                            </div>

                            <div class="flex gap-1">
                                <span class="font-bold"> Status: </span>
                                {{ order.status }}
                            </div>

                            <div class="flex gap-1">
                                <span class="font-bold"> Created on: </span>
                                {{ new Date(order.created_at).toDateString() }}
                            </div>

                            <div class="flex gap-1">
                                <span class="font-bold"> Last change: </span>
                                {{ new Date(order.updated_at).toDateString() }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md">Contact Info</div>
                <div class="bg-white rounded-lg shadow-md">Addresses Info</div>
            </div>
        </template>
    </AppAdminLayout>
</template>
<script setup lang="ts">
import { usePage, Link } from "@inertiajs/vue3";

import AppAdminLayout from "@/layout/AppAdminLayout.vue";
import IconEdit from "@/icons/IconEdit.vue";
import IconBack from "@/icons/IconBack.vue";

// props
import { Supplier, SupplierOrder } from "@/types";
interface PageProps extends Record<string, unknown> {
    supplier: Supplier;
}

// data
const supplier: Supplier = usePage<PageProps>().props.supplier;
const supplier_orders: SupplierOrder[] =
    usePage<PageProps>().props.supplier.orders;
</script>
