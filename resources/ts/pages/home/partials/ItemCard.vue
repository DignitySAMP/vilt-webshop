<template>
    <div
        :key="product.id"
        class="bg-white rounded-xl overflow-hidden shadow-sm border border-slate-200 hover:shadow-lg transition-all group"
    >
        <img
            :src="product.image_url"
            class="bg-slate-100 flex items-center justify-center text-6xl group-hover:scale-105 transition duration-300 h-32 lg:h-64 w-full object-cover"
        />

        <div class="p-4">
            <h3 class="font-semibold text-slate-900 mb-1">
                {{ product.name }}
            </h3>
            <div class="flex items-center gap-2 mb-3">
                <span class="text-sm text-slate-500">{{
                    product.description
                }}</span>
            </div>
            <div class="text-sm text-slate-500 flex items-center gap-2 mb-3">
                <span class="font-bold">{{ product.stock }}</span>
                <span> items in stock. </span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-xl font-bold text-slate-900"
                    >${{ product.price.toFixed(2) }}</span
                >
                <button
                    @click="addToCart(product)"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium"
                >
                    Add to Cart
                </button>
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import { Item } from "@/types";
const product = defineProps<Item>();

import { useShoppingCartStore } from '@/stores/AppShoppingCart'
const shopping_cart_store = useShoppingCartStore();

const addToCart = async (item: Item) => {
    await shopping_cart_store.storeItemToBasket(item);
    await shopping_cart_store.getShoppingBasket();
}
</script>
