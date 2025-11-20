<template>
    <article>
        <h3 class="text-lg font-semibold text-slate-900 mb-4">Preview</h3>
        <div class="bg-slate-50 rounded-lg p-4 border border-slate-200">
            <div class="flex items-center gap-4">
                <img
                    v-if="props.image_preview"
                    :src="props.image_preview"
                    class="size-20 bg-white rounded-lg flex items-center justify-center text-4xl border border-slate-200"
                />
                <figure
                    v-else
                    class="size-20 bg-white rounded-lg flex items-center justify-center text-4xl border border-slate-200"
                >
                    <span
                        class="text-slate-400"
                        v-html="props.item.name[0] ?? '?'"
                    />
                </figure>
                <div class="flex flex-col">
                    <h4 class="font-semibold text-slate-900 text-lg">
                        {{ props.item.name || "Product Name" }}
                    </h4>
                    <div class="flex items-center gap-2">
                        <span
                            class="text-sm text-slate-600 capitalize"
                            v-html="
                                usePage<PageProps>().props.categories.filter(
                                    (cat: any) =>
                                        cat.id === props.item.category,
                                )[0].name
                            "
                        />
                        <span class="text-slate-400" v-html="'•'" />
                        <span
                            class="text-sm text-slate-600"
                            v-html="`${props.item.stock} in stock`"
                        />
                    </div>
                    <span class="text-xl font-bold text-slate-900">
                        ${{ numberToFixed(props.item.price ?? 0) }}
                    </span>
                </div>
            </div>
        </div>
    </article>
</template>

<script setup lang="ts">
import { usePage } from "@inertiajs/vue3";
import { type PageProps } from "@/types/inertia";

interface Props {
    item: {
        name: string;
        description: string;
        category: number;
        supplier: number;
        price: number | null;
        stock: number | null;
        image: File | null;
    };
    image_preview: string | null;
}
const props = defineProps<Props>();

// safely formats a number to have 2 decimals
const numberToFixed = (input: number) => {
    return Number(input).toFixed(2);
};
</script>
