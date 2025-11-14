<template>
    <div class="min-h-screen bg-slate-50">
        <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
            <div class="px-6 py-4 flex items-center justify-between">
                <h1 class="text-2xl font-bold text-slate-900">ShopCo</h1>
                <div class="flex items-center gap-4">
                    <button
                        class="p-2 hover:bg-slate-100 rounded-lg transition-colors"
                    >
                        <svg
                            class="w-5 h-5 text-slate-600"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                            />
                        </svg>
                    </button>
                    <div class="relative">
                        <button
                            class="p-2 hover:bg-slate-100 rounded-lg transition-colors"
                        >
                            <svg
                                class="w-5 h-5 text-slate-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                                />
                            </svg>
                        </button>
                        <span
                            v-if="cartItemCount > 0"
                            class="absolute -top-1 -right-1 bg-blue-600 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center font-medium"
                        >
                            {{ cartItemCount }}
                        </span>
                    </div>
                </div>
            </div>
        </header>

        <div
            class="grid grid-cols-[280px_1fr_320px] gap-6 p-6 max-w-[1800px] mx-auto"
        >
            <aside class="space-y-6">
                <div
                    class="bg-white rounded-xl p-6 shadow-sm border border-slate-200"
                >
                    <h2 class="text-lg font-semibold text-slate-900 mb-4">
                        Categories
                    </h2>
                    <div class="space-y-2">
                        <button
                            v-for="cat in categories"
                            :key="cat.id"
                            @click="selectedCategory = cat.id"
                            :class="[
                                'w-full text-left px-4 py-3 rounded-lg transition-all',
                                selectedCategory === cat.id
                                    ? 'bg-blue-50 text-blue-700 font-medium'
                                    : 'text-slate-700 hover:bg-slate-50',
                            ]"
                        >
                            <div class="flex justify-between items-center">
                                <span>{{ cat.name }}</span>
                                <span class="text-sm text-slate-500">{{
                                    cat.count
                                }}</span>
                            </div>
                        </button>
                    </div>
                </div>

                <div
                    class="bg-white rounded-xl p-6 shadow-sm border border-slate-200"
                >
                    <h2 class="text-lg font-semibold text-slate-900 mb-4">
                        Price Range
                    </h2>
                    <div class="space-y-4">
                        <input
                            v-model="priceRange"
                            type="range"
                            class="w-full accent-blue-600"
                            min="0"
                            max="500"
                        />
                        <div
                            class="flex justify-between text-sm text-slate-600"
                        >
                            <span>$0</span>
                            <span>${{ priceRange }}</span>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-linear-to-br from-blue-600 to-indigo-700 rounded-xl p-6 text-white"
                >
                    <div class="flex items-center gap-3 mb-3">
                        <svg
                            class="w-6 h-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"
                            />
                        </svg>
                        <h3 class="font-semibold">Special Offer</h3>
                    </div>
                    <p class="text-sm text-blue-100 mb-4">
                        Get 20% off your first order with code WELCOME20
                    </p>
                    <button
                        class="bg-white text-blue-600 px-4 py-2 rounded-lg font-medium text-sm hover:bg-blue-50 transition-colors w-full"
                    >
                        Copy Code
                    </button>
                </div>
            </aside>

            <main class="space-y-6">
                <div
                    class="bg-white rounded-xl p-4 shadow-sm border border-slate-200"
                >
                    <div class="flex items-center gap-3">
                        <svg
                            class="w-5 h-5 text-slate-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                            />
                        </svg>
                        <input
                            v-model="searchQuery"
                            type="text"
                            placeholder="Search products..."
                            class="flex-1 outline-none text-slate-700"
                        />
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-6">
                    <div
                        v-for="product in filteredProducts"
                        :key="product.id"
                        class="bg-white rounded-xl overflow-hidden shadow-sm border border-slate-200 hover:shadow-lg transition-all group"
                    >
                        <div
                            class="aspect-square bg-slate-100 flex items-center justify-center text-6xl group-hover:scale-105 transition-transform"
                        >
                            {{ product.image }}
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-slate-900 mb-1">
                                {{ product.name }}
                            </h3>
                            <div class="flex items-center gap-2 mb-3">
                                <div class="flex items-center">
                                    <svg
                                        v-for="i in 5"
                                        :key="i"
                                        :class="[
                                            'w-4 h-4',
                                            i <= product.rating
                                                ? 'text-yellow-400'
                                                : 'text-slate-300',
                                        ]"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                                        />
                                    </svg>
                                </div>
                                <span class="text-sm text-slate-500">{{
                                    product.rating
                                }}</span>
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
                </div>
            </main>

            <aside class="space-y-6">
                <div
                    class="bg-white rounded-xl p-6 shadow-sm border border-slate-200 sticky top-24"
                >
                    <h2 class="text-lg font-semibold text-slate-900 mb-4">
                        Shopping Cart
                    </h2>

                    <div v-if="cart.length === 0" class="text-center py-8">
                        <svg
                            class="w-16 h-16 text-slate-300 mx-auto mb-3"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                            />
                        </svg>
                        <p class="text-slate-500 text-sm">Your cart is empty</p>
                    </div>

                    <div v-else class="space-y-4 mb-6">
                        <div
                            v-for="item in cart"
                            :key="item.id"
                            class="flex gap-3 pb-4 border-b border-slate-100"
                        >
                            <div
                                class="w-16 h-16 bg-slate-100 rounded-lg flex items-center justify-center text-2xl shrink-0"
                            >
                                {{ item.image }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4
                                    class="font-medium text-slate-900 text-sm truncate"
                                >
                                    {{ item.name }}
                                </h4>
                                <p class="text-slate-600 text-sm mb-2">
                                    ${{ item.price.toFixed(2) }}
                                </p>
                                <div class="flex items-center gap-2">
                                    <button
                                        @click="updateQuantity(item.id, -1)"
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
                                        @click="updateQuantity(item.id, 1)"
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

                    <div v-if="cart.length > 0" class="space-y-4">
                        <div class="flex items-center gap-2 mb-4">
                            <input
                                v-model="couponCode"
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
    </div>
</template>
<script setup lang="ts">
import { ref, computed } from "vue";

interface Product {
    id: number;
    name: string;
    price: number;
    category: string;
    rating: number;
    image: string;
}

interface CartItem extends Product {
    quantity: number;
}

interface Category {
    id: string;
    name: string;
    count: number;
}

const cart = ref<CartItem[]>([]);
const selectedCategory = ref<string>("all");
const searchQuery = ref<string>("");
const priceRange = ref<number>(500);
const couponCode = ref<string>("");

const categories: Category[] = [
    { id: "all", name: "All Products", count: 24 },
    { id: "electronics", name: "Electronics", count: 8 },
    { id: "clothing", name: "Clothing", count: 12 },
    { id: "home", name: "Home & Living", count: 4 },
];

const products: Product[] = [
    {
        id: 1,
        name: "Premium Wireless Headphones",
        price: 299.99,
        category: "electronics",
        rating: 4.5,
        image: "🎧",
    },
    {
        id: 2,
        name: "Classic Cotton T-Shirt",
        price: 29.99,
        category: "clothing",
        rating: 4.8,
        image: "👕",
    },
    {
        id: 3,
        name: "Modern Desk Lamp",
        price: 89.99,
        category: "home",
        rating: 4.3,
        image: "💡",
    },
    {
        id: 4,
        name: "Smart Watch Pro",
        price: 399.99,
        category: "electronics",
        rating: 4.7,
        image: "⌚",
    },
    {
        id: 5,
        name: "Leather Jacket",
        price: 249.99,
        category: "clothing",
        rating: 4.6,
        image: "🧥",
    },
    {
        id: 6,
        name: "Ceramic Vase Set",
        price: 59.99,
        category: "home",
        rating: 4.4,
        image: "🏺",
    },
    {
        id: 7,
        name: "Bluetooth Speaker",
        price: 149.99,
        category: "electronics",
        rating: 4.6,
        image: "🔊",
    },
    {
        id: 8,
        name: "Denim Jeans",
        price: 79.99,
        category: "clothing",
        rating: 4.5,
        image: "👖",
    },
    {
        id: 9,
        name: "Table Clock",
        price: 45.99,
        category: "home",
        rating: 4.2,
        image: "⏰",
    },
];

const filteredProducts = computed<Product[]>(() => {
    return products.filter(
        (p) =>
            (selectedCategory.value === "all" ||
                p.category === selectedCategory.value) &&
            p.name.toLowerCase().includes(searchQuery.value.toLowerCase()) &&
            p.price <= priceRange.value,
    );
});

const cartItemCount = computed<number>(() => {
    return cart.value.reduce((sum, item) => sum + item.quantity, 0);
});

const cartTotal = computed<number>(() => {
    return cart.value.reduce(
        (sum, item) => sum + item.price * item.quantity,
        0,
    );
});

const addToCart = (product: Product) => {
    const existing = cart.value.find((item) => item.id === product.id);
    if (existing) {
        existing.quantity++;
    } else {
        cart.value.push({ ...product, quantity: 1 });
    }
};

const updateQuantity = (id: number, amount: number) => {
    const item = cart.value.find((i) => i.id === id);
    if (item) {
        item.quantity += amount;
        if (item.quantity <= 0) {
            cart.value = cart.value.filter((i) => i.id !== id);
        }
    }
};
</script>
