<template>
    <AppAdminLayout title="Product Management" :show_title="false">
        <template v-slot:header>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <Link
                        :href="route('item.index')"
                        class="p-2 hover:bg-slate-100 rounded-lg transition duration-300"
                    >
                        <IconBack />
                    </Link>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900">
                            Add New Product
                        </h1>
                        <p class="text-sm text-slate-500 mt-1">
                            Create a new product listing
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <button
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300 flex items-center gap-2 font-medium"
                    >
                        <IconCreate />

                        Create Product
                    </button>
                </div>
            </div>
        </template>

        <template v-slot:body>
            <div
                class="bg-white rounded-xl shadow-sm border border-slate-200 p-6"
            >
                <div class="space-y-6">
                    <div>
                        <label
                            class="block text-sm font-medium text-slate-700 mb-2"
                            >Product Name</label
                        >
                        <input
                            v-model="form.name"
                            type="text"
                            class="w-full px-4 py-2 border border-slate-200 rounded-lg outline-none focus:border-blue-600 transition duration-300"
                            placeholder="Enter product name"
                        />
                    </div>

                    <div class="grid grid-cols-3 gap-6">
                        <div>
                            <label
                                class="block text-sm font-medium text-slate-700 mb-2"
                                >Category</label
                            >
                            <select
                                v-model="form.category"
                                class="w-full px-4 py-2 border border-slate-200 rounded-lg outline-none focus:border-blue-600 transition duration-300"
                            >
                                <option
                                    v-for="(
                                        category, key
                                    ) in usePage<PageProps>().props.categories"
                                    :key="key"
                                    :value="category.id"
                                >
                                    {{ category.name }}
                                </option>
                                <option value="clothing">Clothing</option>
                                <option value="home">Home & Living</option>
                            </select>
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-slate-700 mb-2"
                                >Price ($)</label
                            >
                            <input
                                v-model.number="form.price"
                                type="number"
                                step="0.01"
                                class="w-full px-4 py-2 border border-slate-200 rounded-lg outline-none focus:border-blue-600 transition duration-300"
                                placeholder="0.00"
                            />
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-slate-700 mb-2"
                                >Stock</label
                            >
                            <input
                                v-model.number="form.stock"
                                type="number"
                                class="w-full px-4 py-2 border border-slate-200 rounded-lg outline-none focus:border-blue-600 transition duration-300"
                                placeholder="0"
                            />
                        </div>
                    </div>

                    <div>
                        <label
                            class="block text-sm font-medium text-slate-700 mb-2"
                            >Product Icon</label
                        >
                        <input
                            type="file"
                            maxlength="2"
                            class="w-full px-4 py-2 border border-slate-200 rounded-lg outline-none focus:border-blue-600 transition duration-300"
                            placeholder="Click to upload an image..."
                        />
                    </div>

                    <div class="pt-6 border-t border-slate-200">
                        <h3 class="text-lg font-semibold text-slate-900 mb-4">
                            Preview
                        </h3>
                        <div
                            class="bg-slate-50 rounded-lg p-4 border border-slate-200"
                        >
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-20 h-20 bg-white rounded-lg flex items-center justify-center text-4xl border border-slate-200"
                                >
                                    {{ form.image }}
                                </div>
                                <div>
                                    <h4
                                        class="font-semibold text-slate-900 text-lg"
                                    >
                                        {{ form.name || "Product Name" }}
                                    </h4>
                                    <div class="flex items-center gap-3 mt-1">
                                        <span
                                            class="text-sm text-slate-600 capitalize"
                                            v-html="
                                                usePage<PageProps>().props.categories.filter(
                                                    (cat) =>
                                                        cat.id ===
                                                        form.category,
                                                )[0].name
                                            "
                                        />
                                        <span
                                            class="text-slate-300"
                                            v-html="'•'"
                                        />
                                        <span
                                            class="text-sm text-slate-600"
                                            v-html="`{{ form.stock }} in stock`"
                                        />
                                    </div>
                                    <div
                                        class="text-xl font-bold text-slate-900 mt-2"
                                    >
                                        ${{ form.price.toFixed(2) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AppAdminLayout>
</template>
<script setup lang="ts">
import { useForm, usePage, Link } from "@inertiajs/vue3";
import AppAdminLayout from "@/layout/AppAdminLayout.vue";

import IconBack from "@/icons/IconBack.vue";
import IconCreate from "@/icons/IconCreate.vue";

import { ItemCategory } from "@/types";
interface PageProps extends Record<string, unknown> {
    categories: ItemCategory[];
}

interface FormProps {
    name: string;
    category: number;
    price: number;
    stock: number;
    image: string;
}

const form = useForm<FormProps>({
    name: "",
    category: usePage<PageProps>().props.categories[0].id ?? 1,
    price: 0,
    stock: 0,
    image: "",
});
</script>
