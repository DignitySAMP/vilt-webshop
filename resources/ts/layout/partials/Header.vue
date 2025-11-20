<template>
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="px-6 py-4 flex items-center justify-between">
            <Link :href="home()">
                <h1
                    class="text-2xl font-bold text-slate-900"
                    v-html="usePage<PageProps>().props.app.name ?? 'Laravel'"
                />
            </Link>
            <div class="flex items-center gap-4">
                <div class="relative">
                    <AppFormIconButton
                        name="btn_favorites"
                        :icon="IconFavorites"
                    />
                    <span
                        v-if="favouriteItemCount > 0"
                        class="absolute -top-1 -right-1 bg-red-600 text-white text-xs size-5 rounded-full flex items-center justify-center font-medium"
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
                            ? profile()
                            : login()
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
import { type PageProps } from "@/types/inertia";
import { home, profile, login } from "@/wayfinder/routes";

import ShoppingCart from "@/layout/partials/ShoppingCart.vue";
import AppFormIconButton from "@/components/form/AppFormIconButton.vue";

import IconFavorites from "@/icons/shop/IconFavorites.vue";
import IconAccount from "@/icons/layout/IconAccount.vue";
import IconProfile from "@/icons/layout/IconProfile.vue";

const favouriteItemCount: number = 3;
</script>
