<template>
    <aside class="md:space-y-6 grid grid-cols-2 gap-2 md:block">
        <div
            class="w-full h-fit flex flex-col bg-white rounded-xl p-2 md:p-4 shadow-sm border border-slate-200"
        >
            <div class="flex w-full justify-between md:block">
                <h2 class="text-lg font-semibold text-slate-900 mb-0 md:mb-4">
                    Categories
                </h2>
                <div
                    class="block md:hidden"
                    @click="collapseCategories = !collapseCategories"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                    >
                        <path
                            fill="currentColor"
                            d="m12 15l-4.243-4.242l1.415-1.414L12 12.172l2.828-2.828l1.415 1.414z"
                        />
                    </svg>
                </div>
            </div>
            <div
                class="mt-2 md:mt-0 block space-y-2 md:block"
                :class="collapseCategories ? 'flex flex-col' : 'hidden'"
            >
                <button
                    @click="selectedCategory = null"
                    :class="[
                        'w-full text-left px-2 py-1 md:px-4 md:py-3 rounded-lg transition duration-300',
                        selectedCategory === null
                            ? 'bg-blue-50 text-blue-700 font-medium'
                            : 'text-slate-700 hover:bg-slate-50',
                    ]"
                >
                    <div class="flex justify-between items-center">
                        <span>Show All Items</span>
                    </div>
                </button>
                <button
                    v-for="cat in categories"
                    :key="cat.id"
                    @click="selectedCategory = cat.id"
                    :class="[
                        'w-full text-left px-2 py-1 md:px-4 md:py-3 rounded-lg transition duration-300',
                        selectedCategory == cat.id
                            ? 'bg-blue-50 text-blue-700 font-medium'
                            : 'text-slate-700 hover:bg-slate-50',
                    ]"
                >
                    <div class="flex justify-between items-center">
                        <span>{{ cat.name }}</span>
                        <span class="text-sm text-slate-500">{{
                            cat.item_count
                        }}</span>
                    </div>
                </button>
            </div>
        </div>

        <div
            class="w-full h-fit bg-white rounded-xl p-2 md:p-4 shadow-sm border border-slate-200"
        >
            <div class="flex w-full justify-between md:block">
                <h2 class="text-lg font-semibold text-slate-900 mb-0 md:mb-4">
                    Price Range
                </h2>
                <div
                    class="block md:hidden"
                    @click="collapsePriceRange = !collapsePriceRange"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                    >
                        <path
                            fill="currentColor"
                            d="m12 15l-4.243-4.242l1.415-1.414L12 12.172l2.828-2.828l1.415 1.414z"
                        />
                    </svg>
                </div>
            </div>
            <div
                class="mt-2 md:mt-0 block space-y-4 md:block"
                :class="collapsePriceRange ? 'flex flex-col' : 'hidden'"
            >
                <input
                    v-model="priceRange"
                    type="range"
                    @change="emit('on-search', selectedCategory, priceRange)"
                    class="w-full accent-blue-600"
                    :min="minPrice"
                    :max="maxPrice"
                />
                <div class="flex justify-between text-sm text-slate-600">
                    <span>${{ minPrice }}</span>

                    <input
                        class="w-16 text-center text-indigo-600 font-bold"
                        @change="
                            emit('on-search', selectedCategory, priceRange)
                        "
                        type="number"
                        :min="minPrice"
                        :max="maxPrice"
                        v-model="priceRange"
                    />

                    <span>${{ maxPrice }}</span>
                </div>
            </div>
        </div>

        <Coupon class="block col-span-2" />
    </aside>
</template>
<script setup lang="ts">
import { ref, watch } from "vue";
import Coupon from "@/pages/home/partials/Coupon.vue";

// props
import { ItemCategory } from "@/types";
import { usePage } from "@inertiajs/vue3";
interface PageProps extends Record<string, unknown> {
    categories: ItemCategory[];
}
const categories = usePage<PageProps>().props.categories;

// ceil minmax the range slider
const minPrice = usePage<PageProps>().props.filter.min_price;
const maxPrice = usePage<PageProps>().props.filter.max_price;

// emit filter data to parent, so router.get can be called with interia
const emit = defineEmits(["on-search"]);
const selectedCategory = ref<number | null>(
    usePage<PageProps>().props.filter.category,
);
const priceRange = ref<number>(
    usePage<PageProps>().props.filter.price_range ??
        usePage<PageProps>().props.filter.avg_price,
);

// mobile:
const collapseCategories = ref<boolean>(false);
const collapsePriceRange = ref<boolean>(false);

// trigger search emit for static element without listener
watch(selectedCategory, () => {
    emit("on-search", selectedCategory.value, priceRange.value);
});
</script>
