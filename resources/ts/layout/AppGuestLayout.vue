<template>
    <div class="min-h-screen bg-slate-50 flex items-center justify-center p-6">
        <div class="w-full max-w-md">
            <div class="mb-8 text-center">
                <Link :href="route('home')" class="">
                    <h1
                        class="text-3xl font-bold text-slate-900"
                        v-html="
                            usePage<PageProps>().props.app.name ?? 'Laravel'
                        "
                    />
                    <p class="text-slate-600">Authentication</p>
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
                    <button
                        type="button"
                        class="flex items-center justify-center gap-2 px-4 py-3 bg-white border border-slate-200 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors"
                    >
                        <svg
                            class="w-5 h-5"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                        >
                            <path
                                d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .307 5.387.307 12s5.56 12 12.173 12c3.573 0 6.267-1.173 8.373-3.36 2.16-2.16 2.84-5.213 2.84-7.667 0-.76-.053-1.467-.173-2.053H12.48z"
                            />
                        </svg>
                        Google
                    </button>
                    <button
                        type="button"
                        class="flex items-center justify-center gap-2 px-4 py-3 bg-white border border-slate-200 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                        >
                            <path
                                fill="currentColor"
                                d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95"
                            />
                        </svg>
                        Facebook
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { usePage, Link } from "@inertiajs/vue3";

interface PageProps extends Record<string, unknown> {
    app: {
        name: string;
    };
}
</script>
