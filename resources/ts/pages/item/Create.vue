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
                        :required="true"
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
                        :required="true"
                        :error="form.errors.description"
                        :disabled="form.processing"
                    />

                    <div class="grid grid-cols-2 gap-6 mb-4">
                        <AppFormSelect
                            label="Category"
                            name="category"
                            :required="true"
                            :options="
                                usePage<PageProps>().props.categories.map(
                                    (cat: { id: number; name: string }) => ({
                                        value: cat.id,
                                        label: cat.name,
                                    }),
                                )
                            "
                            v-model="form.category"
                            :error="form.errors.category"
                        />

                        <AppFormSelect
                            label="Supplier"
                            name="supplier"
                            :required="true"
                            :options="
                                usePage<PageProps>().props.suppliers.map(
                                    (cat: { id: number; name: string }) => ({
                                        value: cat.id,
                                        label: cat.name,
                                    }),
                                )
                            "
                            v-model="form.supplier"
                            :error="form.errors.supplier"
                        />

                        <AppFormInput
                            placeholder="0.00"
                            name="price"
                            label="Price ($)"
                            type="number"
                            :required="true"
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
                            :required="true"
                            step="0.01"
                            v-model.number="form.stock"
                            :error="form.errors.stock"
                            :disabled="form.processing"
                        />

                        <AppFormFile
                            name="image"
                            label="Product Icon"
                            :required="true"
                            @on-file-upload="handleFileSelect($event)"
                            :error="form.errors.image"
                            accept="image/*"
                        />
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

import IconBack from "@/icons/crud/IconBack.vue";
import IconCreate from "@/icons/crud/IconCreate.vue";
import AppFormButton from "@/components/form/AppFormButton.vue";
import AppFormInput from "@/components/form/AppFormInput.vue";
import AppFormSelect from "@/components/form/AppFormSelect.vue";
import AppFormFile from "@/components/form/AppFormFile.vue";
import { toast } from "vue3-toastify";

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
        onSuccess: () => toast.success('You have created a new product.'),
        onError: (error) => {
            for(const key in error) {
                toast.error(error[key]);
            }
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
