<template>
    <div
        class="bg-white rounded-xl overflow-hidden shadow-sm border border-slate-200 hover:shadow-lg transition-all group"
    >
        <Link :href="show(product.id)">
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
                <div
                    class="text-sm text-slate-500 flex items-center gap-2 mb-3"
                >
                    <span class="font-bold">{{ product.stock }}</span>
                    <span> items in stock. </span>
                </div>
                <span class="text-xl font-bold text-slate-900"
                    >${{ product.price.toFixed(2) }}</span
                >
            </div>
        </Link>

        <div class="px-4 pb-4">
            <AppFormButton
                @click="addToCart(product)"
                name="btn_add_to_cart"
                text="Add to Cart"
            />
        </div>
    </div>
</template>
<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { Item } from "@/types";
import { show } from "@/wayfinder/routes/item";
import { useShoppingCartStore } from "@/stores/AppShoppingCart";
import AppFormButton from "@/components/form/AppFormButton.vue";

const product = defineProps<Item>();

const shopping_cart_store = useShoppingCartStore();
const addToCart = async (item: Item) => {
    await shopping_cart_store.storeItemToBasket(item);
};
</script>
