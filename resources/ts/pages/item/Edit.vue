<template>
    <AppAdminLayout>
        <template v-slot:header>
            <div class="flex items-center gap-4">
                <Link
                    :href="index()"
                    class="p-2 hover:bg-slate-100 rounded-lg transition duration-300"
                >
                    <IconBack />
                </Link>
                <div
                    class="w-full flex flex-col justify-center items-center md:block"
                >
                    <h1 class="text-2xl font-bold text-slate-900">
                        Modify Product
                    </h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Update existing product listing
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button
                    @click="submit"
                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300 flex items-center gap-2 font-medium"
                >
                    <IconSave />

                    Save Product
                </button>
            </div>
        </template>

        <template v-slot:body>
            <form
                @submit.prevent
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
                    <div class="grid md:grid-cols-2 gap-6">
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

                    <PreviewItem :item="form" :image_preview="image_preview" />
                </div>
            </form>
        </template>
    </AppAdminLayout>
</template>
<script setup lang="ts">
import { useForm, InertiaForm, usePage, Link } from "@inertiajs/vue3";
import { ref } from "vue";
import { type PageProps } from "@/types/inertia";
import { index } from "@/wayfinder/routes/item";
import { update } from "@/wayfinder/actions/App/Http/Controllers/ItemController"

import AppAdminLayout from "@/layout/AppAdminLayout.vue";
import PreviewItem from "@/pages/item/partials/PartialEdit_Preview.vue";

import IconBack from "@/icons/IconBack.vue";
import IconSave from "@/icons/IconSave.vue";

const props = usePage<PageProps>().props.item;
const form: InertiaForm<{
    name: string;
    description: string;
    category: number;
    supplier: number;
    price: number;
    stock: number;
    image: File | null;
}> = useForm({
    name: props.name,
    description: props.description,
    category: props.item_category_id,
    supplier: props.supplier_id,
    price: props.price,
    stock: props.stock,
    image: null,
});

const submit = () => {
    form.transform((data) => ({
        ...data,
        _method: 'PATCH',
    }));

    form.submit('post', update(props.id).url, {
        preserveScroll: true,
        forceFormData: true,
        onError: (error: any) => console.error(error),
    });
};

const image_preview = ref(props.image_url);
const handleFileSelect = (event: Event) => {
    const file = (event.target as HTMLInputElement).files?.[0] || null;

    if (file) {
        form.image = file;
        image_preview.value = URL.createObjectURL(file);
    } else {
        form.image = null as any;
        image_preview.value = null;
    }
};
</script>
