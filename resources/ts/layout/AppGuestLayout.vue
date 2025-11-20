<template>
    <div class="min-h-screen bg-slate-50 flex items-center justify-center p-6">
        <div class="w-full max-w-md">
            <div class="mb-8 text-center">
                <Link :href="home()" class="">
                    <h1
                        class="text-3xl font-bold text-slate-900"
                        v-html="
                            usePage<PageProps>().props.app.name ?? 'Laravel'
                        "
                    />
                    <p class="text-slate-600">{{ props.title }}</p>
                </Link>
            </div>

            <div
                class="bg-white rounded-xl shadow-sm border border-slate-200 p-8"
            >
                <slot />
            </div>

            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-slate-50 text-slate-500">
                            Or continue with
                        </span>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-2 gap-3">
                    <AppFormButton
                        name="btn_google"
                        :icon="IconGoogle"
                        text="Google"
                        theme="secondary"
                    />
                    <AppFormButton
                        name="btn_facebook"
                        :icon="IconFacebook"
                        text="Facebook"
                        theme="secondary"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { usePage, Link } from "@inertiajs/vue3";
import { type PageProps } from "@/types/inertia";
import { home } from "@/wayfinder/routes";

import AppFormButton from "@/components/form/AppFormButton.vue";

import IconGoogle from "@/icons/logo/IconGoogle.vue";
import IconFacebook from "@/icons/logo/IconFacebook.vue";

interface Props {
    title: string;
}
const props = defineProps<Props>();
</script>
