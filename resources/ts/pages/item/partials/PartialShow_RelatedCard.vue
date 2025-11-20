<template>
    <Link as="div" :href="show(product.id)"
        class="bg-white rounded-xl overflow-hidden shadow-sm border border-slate-200 hover:shadow-lg transition-all group cursor-pointer"
    >
        <img
            :src="product.image_url"
            class="bg-slate-100 flex items-center justify-center group-hover:scale-105 transition duration-300 h-48 w-full object-cover"
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
                <span>items in stock.</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-xl font-bold text-slate-900"
                    >${{ product.price.toFixed(2) }}</span
                >
                <button
                    @click.stop="addToCart()"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium"
                >
                    Add to Cart
                </button>
            </div>
        </div>
    </Link>
</template>
<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { useShoppingCartStore } from "@/stores/AppShoppingCart";
import { show } from "@/wayfinder/routes/item";

// TODO: clean this up... raw prop data
interface RelatedItemInterface {
    id: number;
    item_category_id: number;
    supplier_id: number;
    name: string;
    description: string;
    image: string;
    price: number;
    stock: number;
    created_at: string;
    updated_at: string;
    image_url: string;
    item_category: {
        id: number;
        name: string;
        description: string;
        item_count: number;
        created_at: string;
        updated_at: string;
    };
    supplier: {
        id: number;
        name: string;
        description: string;
        pending_orders: number;
        created_at: string;
        updated_at: string;
    };
}

const product = defineProps<RelatedItemInterface>();

const shopping_cart_store = useShoppingCartStore();
const addToCart = async () => await shopping_cart_store.storeItemToBasket(product);

</script>
