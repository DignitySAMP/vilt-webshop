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
                        @click="submit"
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
                <form @submit.prevent class="space-y-6">
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
                        <span v-if="form.errors.name">
                            {{ form.errors.name }}
                        </span>
                    </div>

                    <div>
                        <label
                            class="block text-sm font-medium text-slate-700 mb-2"
                            >Product Description</label
                        >
                        <textarea
                            v-model="form.description"
                            class="no-resize w-full px-4 py-2 border border-slate-200 rounded-lg outline-none focus:border-blue-600 transition duration-300"
                            placeholder="Enter product description"
                        />
                        <span v-if="form.errors.description">
                            {{ form.errors.description }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-4">
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
                            </select>

                            <span v-if="form.errors.category">
                                {{ form.errors.category }}
                            </span>
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-slate-700 mb-2"
                                >Supplier</label
                            >
                            <select
                                v-model="form.supplier"
                                class="w-full px-4 py-2 border border-slate-200 rounded-lg outline-none focus:border-blue-600 transition duration-300"
                            >
                                <option
                                    v-for="(
                                        supplier, key
                                    ) in usePage<PageProps>().props.suppliers"
                                    :key="key"
                                    :value="supplier.id"
                                >
                                    {{ supplier.name }}
                                </option>
                            </select>

                            <span v-if="form.errors.category">
                                {{ form.errors.category }}
                            </span>
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

                            <span v-if="form.errors.price">
                                {{ form.errors.price }}
                            </span>
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
                            <span v-if="form.errors.stock">
                                {{ form.errors.stock }}
                            </span>
                        </div>
                        <div>
                            <label
                                class="block text-sm font-medium text-slate-700 mb-2"
                                >Product Icon</label
                            >
                            <input
                                type="file"
                                @input="handleFileSelect($event)"
                                class="w-full px-4 py-2 border border-slate-200 rounded-lg outline-none focus:border-blue-600 transition duration-300"
                                placeholder="Click to upload an image..."
                            />

                            <span v-if="form.errors.image">
                                {{ form.errors.image }}
                            </span>
                        </div>
                    </div>
                </form>
                <div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">
                        Preview
                    </h3>
                    <div
                        class="bg-slate-50 rounded-lg p-4 border border-slate-200"
                    >
                        <div class="flex items-center gap-4">
                            <img
                                v-if="form.image && previewImage !== null"
                                :src="previewImage"
                                class="size-20 bg-white rounded-lg flex items-center justify-center text-4xl border border-slate-200"
                            />
                            <div
                                v-else-if="!form.image"
                                class="size-20 bg-white rounded-lg flex items-center justify-center text-4xl border border-slate-200"
                            >
                                <span
                                    class="text-slate-400"
                                    v-html="form.name[0] ?? '?'"
                                />
                            </div>
                            <div class="flex flex-col gap-1">
                                <div class="flex items-center gap-2">
                                    <h4
                                        class="font-semibold text-slate-900 text-lg"
                                    >
                                        {{ form.name || "Product Name" }}
                                    </h4>

                                    <span
                                        class="text-sm text-slate-600 capitalize"
                                        v-html="
                                            usePage<PageProps>().props.categories.filter(
                                                (cat: any) =>
                                                    cat.id === form.category,
                                            )[0].name
                                        "
                                    />
                                    <span class="text-slate-400" v-html="'•'" />
                                    <span
                                        class="text-sm text-slate-600"
                                        v-html="`${form.stock} in stock`"
                                    />
                                </div>
                                <div class="text-xl font-bold text-slate-900">
                                    ${{ form.price.toFixed(2) }}
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
import { ref } from "vue";
interface PageProps extends Record<string, unknown> {
    categories: ItemCategory[];
}

interface FormProps {
    name: string;
    description: string;
    category: number;
    supplier: number;
    price: number;
    stock: number;
    image: File | null;
}

const previewImage = ref<string | null>("");
const form = useForm<FormProps>({
    name: "",
    description: "",
    category: usePage<PageProps>().props.categories[0].id ?? 1,
    supplier: usePage<PageProps>().props.suppliers[0].id ?? 1,
    price: 0,
    stock: 0,
    image: null,
});

const submit = () => {
    form.post(route("item.store"), {
        preserveScroll: true,
        onError: (error: any) => {
            console.error(error);
        },
    });
};

const handleFileSelect = (event: Event) => {
    const file = (event.target as HTMLInputElement).files?.[0] || null;

    if (file) {
        form.image = file;
        previewImage.value = URL.createObjectURL(file);
    } else {
        form.image = null as any;
        previewImage.value = null;
    }
};
</script>
