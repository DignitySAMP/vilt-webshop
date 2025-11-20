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
                        Modify Category
                    </h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Update existing category
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <AppFormButton
                    name="btn_edit_category"
                    text="Save Category"
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
                        placeholder="Enter desired category name"
                        name="name"
                        label="Category Name"
                        type="text"
                        autocomplete="name"
                        v-model="form.name"
                        :error="form.errors.name"
                        :disabled="form.processing"
                        :required="true"
                    />

                    <AppFormInput
                        placeholder="Enter desired category description"
                        name="description"
                        label="Category Description"
                        type="text"
                        autocomplete="description"
                        v-model="form.description"
                        :error="form.errors.description"
                        :disabled="form.processing"
                        :required="true"
                    />
                </div>
            </form>
        </template>
    </AppAdminLayout>
</template>
<script setup lang="ts">
import { useForm, usePage, Link, InertiaForm } from "@inertiajs/vue3";
import { ItemCategory } from "@/types";
import { type PageProps } from "@/types/inertia";

import AppAdminLayout from "@/layout/AppAdminLayout.vue";

import { index, update } from "@/wayfinder/routes/category";

import IconBack from "@/icons/crud/IconBack.vue";
import IconSave from "@/icons/crud/IconSave.vue";
import AppFormButton from "@/components/form/AppFormButton.vue";
import AppFormInput from "@/components/form/AppFormInput.vue";
import { toast } from "vue3-toastify";

const categoryProp: ItemCategory = usePage<PageProps>().props.category;

const form: InertiaForm<{
    name: string;
    description: string;
}> = useForm({
    name: categoryProp.name,
    description: categoryProp.description,
});

const submit = () => {
    form.submit(update(categoryProp.id), {
        preserveScroll: true,
        onSuccess: () =>
            toast.success(`You have updated ${categoryProp.name}.`),
        onError: (error) => {
            for (const key in error) {
                toast.error(error[key]);
            }
        },
    });
};
</script>
