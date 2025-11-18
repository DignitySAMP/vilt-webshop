<template>
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div
            class="relative px-6 py-4 flex flex-row items-end md:items-center gap-4"
        >
            <div
                class="flex flex-col gap-2 md:flex-row w-full md:items-center md:justify-between"
            >
                <slot name="header" />
            </div>

            <div
                @click="collapseDropdown = !collapseDropdown"
                class="relative w-fit bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors flex items-center gap-2 font-medium"
            >
                <IconBreadcrumbs />

                <div
                    v-if="collapseDropdown"
                    class="absolute top-11 right-1 w-64 bg-white border border-gray-100 shadow-md rounded-lg px-4 py-2 flex flex-col gap-2 divide-y-2 divide-gray-100"
                >
                    <div v-for="item in menuItems" :key="item.name">
                        <Link
                            :href="item.url"
                            class="flex w-full justify-between"
                        >
                            <component :is="item.icon" class="size-5" />
                            <span>
                                {{ item.name }}
                            </span>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto p-6">
        <slot name="body" />
    </div>
</template>
<script setup lang="ts">
import IconBreadcrumbs from "@/icons/IconBreadcrumbs.vue";
import IconItem from "@/icons/IconItem.vue";
import IconItemCategory from "@/icons/IconItemCategory.vue";
import { type Component, ref } from "vue";
import { Link } from "@inertiajs/vue3";
import IconSupplier from "@/icons/IconSupplier.vue";

const collapseDropdown = ref<boolean>(false);

interface menuItemShim {
    name: string;
    icon: Component;
    url: string;
}

const menuItems: menuItemShim[] = [
    {
        name: "Items",
        icon: IconItem,
        url: route("item.index"),
    },
    {
        name: "Item Categories",
        icon: IconItemCategory,
        url: route("category.index"),
    },
    {
        name: "Supplier",
        icon: IconSupplier,
        url: route("supplier.index"),
    },
];

// TODO: Add click event that closes the dropdown when clicking outside of it
</script>
