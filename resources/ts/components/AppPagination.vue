<template>
    <div class="flex flex-col gap-1 justify-center items-center">
        <div class="flex gap-2 justify-center items-center">
            <div v-for="(links, index) in props.links" :key="index">
                <span
                    v-if="links.url === null"
                    v-html="links.label"
                    class="select-none rounded-md shadow-sm border px-4 py-2 bg-gray-100 text-gray-400 border-gray-300 cursor-not-allowed"
                />

                <Link
                    :href="links.url"
                    v-if="links.url !== null"
                    class="select-none rounded-md shadow-sm border px-4 py-2 cursor-pointer"
                    :class="
                        current_page === links.page
                            ? 'bg-blue-600 text-blue-100 border-blue-600 hover:bg-blue-700'
                            : 'bg-white border-slate-200 hover:bg-gray-100'
                    "
                >
                    <span v-html="links.label" />
                </Link>
            </div>
        </div>
        <div class="mt-4 text-sm text-slate-600">
            Showing {{ to ?? "0" }} of {{ total ?? "0" }} results
        </div>
    </div>
</template>
<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import type { PaginationMeta } from "@/types/pagination";
const props = defineProps<PaginationMeta>();
</script>
