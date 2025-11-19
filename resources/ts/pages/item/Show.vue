<template>
    <AppLayout>
        <div class="max-w-[1400px] mx-auto p-3 md:p-6">
            <div
                class="bg-white rounded-xl overflow-hidden shadow-sm border border-slate-200"
            >
                <div class="grid md:grid-cols-2 gap-6 md:gap-8 p-4 md:p-8">
                    <div
                        class="bg-slate-50 rounded-lg overflow-hidden flex items-center justify-center"
                    >
                        <img
                            :src="item.image_url"
                            :alt="item.name"
                            class="w-full h-auto object-cover"
                        />
                    </div>

                    <div class="flex flex-col gap-6">
                        <div>
                            <h1 class="text-3xl font-bold text-slate-900 mb-2">
                                {{ item.name }}
                            </h1>
                            <p class="text-slate-600 text-lg">
                                {{ item.description }}
                            </p>
                        </div>

                        <div class="flex items-baseline gap-3">
                            <span class="text-4xl font-bold text-slate-900">
                                ${{ item.price.toFixed(2) }}
                            </span>
                        </div>

                        <div class="space-y-3 py-4 border-y border-slate-200">
                            <div class="flex items-center justify-between">
                                <span class="text-slate-600"
                                    >Stock Available</span
                                >
                                <span class="font-semibold text-slate-900">
                                    {{ item.stock }} items
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-600">Category</span>
                                <span class="font-semibold text-slate-900">
                                    {{ item.item_category.name }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-600">Supplier</span>
                                <span class="font-semibold text-slate-900">
                                    {{ item.supplier.name }}
                                </span>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <button
                                @click="addToCart"
                                :disabled="item.stock === 0"
                                :class="[
                                    'flex-1 px-6 py-3 rounded-lg font-semibold transition-colors',
                                    item.stock > 0
                                        ? 'bg-blue-600 text-white hover:bg-blue-700'
                                        : 'bg-slate-200 text-slate-500 cursor-not-allowed',
                                ]"
                            >
                                {{
                                    item.stock > 0
                                        ? "Add to Cart"
                                        : "Out of Stock"
                                }}
                            </button>
                            <button
                                @click="toggleFavourite"
                                class="px-6 py-3 border-2 border-slate-200 rounded-lg hover:border-slate-300 transition-colors"
                            >
                                <IconFavorites
                                    class="size-6"
                                    :class="
                                        isFavourite
                                            ? 'fill-red-500 text-red-500'
                                            : 'text-slate-400'
                                    "
                                />
                            </button>
                        </div>

                        <div class="bg-blue-50 rounded-lg p-4">
                            <div class="flex items-center gap-3">
                                <IconShipping class="size-10 text-indigo-300" />

                                <div class="text-sm text-blue-900">
                                    <p class="font-semibold mb-1">
                                        Free Shipping
                                    </p>
                                    <p class="text-blue-700">
                                        On orders over $50
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-xl overflow-hidden shadow-sm border border-slate-200 mt-6"
            >
                <div class="p-4 md:p-6">
                    <h2 class="text-2xl font-bold text-slate-900 mb-6">
                        Related Items
                    </h2>
                    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <PartialShowRelatedCard
                            v-for="product in usePage<PageProps>().props
                                .similar"
                            :key="product.id"
                            v-bind="product"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/layout/AppLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import IconFavorites from "@/icons/IconFavorites.vue";
import IconShipping from "@/icons/IconShipping.vue";
import { type PageProps } from "@/types/inertia";

const item = usePage<PageProps>().props.item;
const isFavourite = ref(false);

import { useShoppingCartStore } from "@/stores/AppShoppingCart";
import PartialShowRelatedCard from "@/pages/item/partials/PartialShowRelatedCard.vue";

const shopping_cart_store = useShoppingCartStore();

const addToCart = async () => {
    await shopping_cart_store.storeItemToBasket(item);
};

const toggleFavourite = () => {
    isFavourite.value = !isFavourite.value;
    console.log("addToFavourites");
};
</script>
