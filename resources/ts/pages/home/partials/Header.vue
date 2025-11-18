<template>
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="px-6 py-4 flex items-center justify-between">
            <h1
                class="text-2xl font-bold text-slate-900"
                v-html="usePage<PageProps>().props.app.name ?? 'Laravel'"
            />
            <div class="flex items-center gap-4">
                <div class="relative">
                    <button
                        class="p-2 hover:bg-slate-100 rounded-lg transition-colors"
                    >
                        <IconFavorites class="w-5 h-5 text-slate-600" />
                    </button>
                    <span
                        v-if="favouriteItemCount > 0"
                        class="absolute -top-1 -right-1 bg-red-600 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center font-medium"
                    >
                        {{ favouriteItemCount }}
                    </span>
                </div>
                <div class="relative">
                    <button
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
                </div>
                <Link
                    :href="route('login')"
                    as="button"
                    class="p-2 hover:bg-slate-100 rounded-lg transition-colors"
                >
                    <IconAccount />
                </Link>
            </div>
        </div>
    </header>
</template>
<script setup lang="ts">
import { usePage, Link } from "@inertiajs/vue3";
import IconFavorites from "@/icons/IconFavorites.vue";
import IconShoppingCart from "@/icons/IconShoppingCart.vue";
import IconAccount from "@/icons/IconAccount.vue";

interface PageProps extends Record<string, unknown> {
    app: {
        name: string;
    };
}

const favouriteItemCount: number = 3;
const cartItemCount: number = 6;
</script>
