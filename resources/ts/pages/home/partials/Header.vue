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
                    <ShoppingCart />
                </div>
                <Link
                    :href="
                        usePage<PageProps>().props.auth !== null
                            ? route('profile')
                            : route('login')
                    "
                    as="button"
                    class="p-2 hover:bg-slate-100 rounded-lg transition-colors"
                >
                    <IconAccount
                        v-if="usePage<PageProps>().props.auth === null"
                    />
                    <IconProfile v-else />
                </Link>
            </div>
        </div>
    </header>
</template>
<script setup lang="ts">
import { usePage, Link } from "@inertiajs/vue3";
import ShoppingCart from "@/pages/home/partials/ShoppingCart.vue";
import IconFavorites from "@/icons/IconFavorites.vue";
import IconAccount from "@/icons/IconAccount.vue";
import IconProfile from "@/icons/IconProfile.vue";

interface PageProps extends Record<string, unknown> {
    app: {
        name: string;
    };
}

const favouriteItemCount: number = 3;
</script>
