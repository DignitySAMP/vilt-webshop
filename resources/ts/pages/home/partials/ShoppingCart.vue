<template>
    <div class="relative">
        <button
            @click="showShoppingCart = !showShoppingCart"
            class="p-2 hover:bg-slate-100 rounded-lg transition-colors"
        >
            <IconShoppingCart class="w-5 h-5 text-slate-600" />
        </button>
        <span
            v-if="cartItemCount > 0"
            class="absolute -top-1 -right-1 bg-blue-600 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center font-medium"
        >
            {{ cartItemCount }}
        </span>

        <aside
            v-if="showShoppingCart"
            class="absolute right-1 w-96 top-8 space-y-6"
        >
            <div
                class="bg-white rounded-xl p-6 shadow-2xl border border-slate-200 lg:sticky top-24"
            >
                <h2 class="text-lg font-semibold text-slate-900 mb-4">
                    Shopping Cart
                </h2>

                <div v-if="cart.length === 0" class="text-center py-8">
                    <IconShoppingCart
                        class="w-16 h-16 text-slate-300 mx-auto mb-3"
                    />
                    <p class="text-slate-500 text-sm">Your cart is empty</p>
                </div>

                <div v-else class="space-y-4 mb-6">
                    <div
                        v-for="item in cart"
                        :key="item.id"
                        class="flex gap-3 w-full pb-4 border-b border-slate-100"
                    >
                        <div
                            class="w-16 h-16 bg-slate-100 rounded-lg flex items-center justify-center text-2xl shrink-0"
                        >
                            {{ item.image }}
                        </div>
                        <div class="flex w-full flex-col gap-2">
                            <div
                                class="flex justify-between w-full gap-2 min-w-0"
                            >
                                <h4
                                    class="font-medium text-slate-900 max-w-40 text-sm truncate"
                                >
                                    {{ item.name }}
                                </h4>
                                <p class="text-slate-600 text-sm mb-2">
                                    ${{ item.price.toFixed(2) }}
                                </p>
                            </div>
                            <div>
                                <div
                                    class="flex justify-end items-center gap-2"
                                >
                                    <button
                                        class="w-6 h-6 bg-slate-100 rounded flex items-center justify-center hover:bg-slate-200 transition-colors"
                                    >
                                        <svg
                                            class="w-3 h-3"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M20 12H4"
                                            />
                                        </svg>
                                    </button>
                                    <span
                                        class="text-sm font-medium text-slate-700 w-8 text-center"
                                        >{{ item.quantity }}</span
                                    >
                                    <button
                                        class="w-6 h-6 bg-slate-100 rounded flex items-center justify-center hover:bg-slate-200 transition-colors"
                                    >
                                        <svg
                                            class="w-3 h-3"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 4v16m8-8H4"
                                            />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="cart.length > 0" class="space-y-4">
                    <div class="flex items-center gap-2 mb-4">
                        <input
                            type="text"
                            placeholder="Coupon code"
                            class="flex-1 px-3 py-2 border border-slate-200 rounded-lg text-sm outline-none focus:border-blue-600 transition-colors"
                        />
                        <button
                            class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg text-sm font-medium hover:bg-slate-200 transition-colors"
                        >
                            Apply
                        </button>
                    </div>

                    <div class="space-y-2 pt-4 border-t border-slate-200">
                        <div
                            class="flex justify-between text-sm text-slate-600"
                        >
                            <span>Subtotal</span>
                            <span>${{ cartTotal.toFixed(2) }}</span>
                        </div>
                        <div
                            class="flex justify-between text-sm text-slate-600"
                        >
                            <span>Shipping</span>
                            <span class="text-green-600">Free</span>
                        </div>
                        <div
                            class="flex justify-between text-lg font-bold text-slate-900 pt-2 border-t border-slate-200"
                        >
                            <span>Total</span>
                            <span>${{ cartTotal.toFixed(2) }}</span>
                        </div>
                    </div>

                    <button
                        class="w-full bg-blue-600 text-white py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors"
                    >
                        Checkout
                    </button>
                </div>
            </div>
        </aside>
    </div>
</template>
<script setup lang="ts">
import IconShoppingCart from "@/icons/IconShoppingCart.vue";
import { ref } from "vue";

const showShoppingCart = ref<boolean>(false);

interface CartItem {
    id: number;
    name: string;
    price: number;
    category: string;
    image: string;
    quantity: number;
}

const cartItemCount: number = 6;
const cartTotal: number = 1254.43;

const cart = ref<CartItem[]>([
    {
        id: 1,
        name: "Test",
        price: 123.45,
        category: "Test",
        image: "",
        quantity: 2,
    },
    {
        id: 2,
        name: "654321 meti tset a si sihT 654321 meti tset a si sihT 654321 meti tset a si sihT",
        price: 654.32,
        category: "yrogetaC",
        image: "",
        quantity: 5,
    },
]);
</script>
