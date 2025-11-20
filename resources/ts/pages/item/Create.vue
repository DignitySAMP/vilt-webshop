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
                <div class="w-fit">
                    <AppFormButton
                        name="btn_add_to_cart"
                        :icon="IconCreate"
                        text="Create Product"
                        @click="submit()"
                    />
                </div>
            </div>
        </template>

        <template v-slot:body>
            <div
                class="bg-white rounded-xl shadow-sm border border-slate-200 p-6"
            >
                <form @submit.prevent class="space-y-6">
                    <AppFormInput
                        placeholder="Enter desired product name"
                        name="name"
                        label="Product Name"
                        type="text"
                        autocomplete="name"
                        v-model="form.name"
                        :error="form.errors.name"
                        :disabled="form.processing"
                    />

                    <AppFormInput
                        placeholder="Enter desired product description"
                        name="description"
                        label="Product Description"
                        type="text"
                        autocomplete="description"
                        v-model="form.description"
                        :error="form.errors.description"
                        :disabled="form.processing"
                    />

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

                        <AppFormInput
                            placeholder="0.00"
                            name="price"
                            label="Price ($)"
                            type="number"
                            step="0.01"
                            v-model="form.price"
                            :error="form.errors.price"
                            :disabled="form.processing"
                        />

                        <AppFormInput
                            placeholder="0"
                            name="stock"
                            label="Stock"
                            type="number"
                            step="0.01"
                            v-model.number="form.stock"
                            :error="form.errors.stock"
                            :disabled="form.processing"
                        />

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

                <PreviewItem :item="form" :image_preview="image_preview" />
            </div>
        </template>
    </AppAdminLayout>
</template>
<script setup lang="ts">
import { ref } from "vue";
import { useForm, usePage, Link, InertiaForm } from "@inertiajs/vue3";
import { store, index } from "@/wayfinder/routes/item";
import { type PageProps } from "@/types/inertia";

import AppAdminLayout from "@/layout/AppAdminLayout.vue";
import PreviewItem from "@/pages/item/partials/PartialEdit_Preview.vue";

import IconBack from "@/icons/IconBack.vue";
import IconCreate from "@/icons/IconCreate.vue";
import AppFormButton from "@/components/form/AppFormButton.vue";
import AppFormInput from "@/components/form/AppFormInput.vue";

const form: InertiaForm<{
    name: string;
    description: string;
    category: number;
    supplier: number;
    price: number;
    stock: number;
    image: File | null;
}> = useForm({
    name: "",
    description: "",
    category: usePage<PageProps>().props.categories[0].id ?? 1,
    supplier: usePage<PageProps>().props.suppliers[0].id ?? 1,
    price: 0,
    stock: 0,
    image: null,
});

const submit = () => {
    form.submit(store(), {
        preserveScroll: true,
        forceFormData: true,
        onError: (error: any) => {
            console.error(error);
        },
    });
};

const image_preview = ref<string | null>("");
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
