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
                <AppFormButton
                    name="btn_edit"
                    text="Save Product"
                    :icon="IconSave"
                    @click="submit"
                />
            </div>
        </template>

        <template v-slot:body>
            <form
                @submit.prevent
                class="bg-white rounded-xl shadow-sm border border-slate-200 p-6"
            >
                <div class="space-y-6">
                    <AppFormInput
                        placeholder="Enter desired product name"
                        name="name"
                        label="Product Name"
                        type="text"
                        autocomplete="name"
                        :required="true"
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
                        :required="true"
                        v-model="form.description"
                        :error="form.errors.description"
                        :disabled="form.processing"
                    />

                    <div class="grid md:grid-cols-2 gap-6">
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
                            :required="true"
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
                            :required="true"
                            type="number"
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
import { update } from "@/wayfinder/actions/App/Http/Controllers/ItemController";

import AppAdminLayout from "@/layout/AppAdminLayout.vue";
import PreviewItem from "@/pages/item/partials/PartialEdit_Preview.vue";

import IconBack from "@/icons/IconBack.vue";
import IconSave from "@/icons/IconSave.vue";
import AppFormButton from "@/components/form/AppFormButton.vue";
import AppFormInput from "@/components/form/AppFormInput.vue";
import AppFormSelect from "@/components/form/AppFormSelect.vue";
import AppFormFile from "@/components/form/AppFormFile.vue";

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
        _method: "PATCH",
    }));

    form.submit("post", update(props.id).url, {
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
