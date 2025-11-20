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
                            >Category Name</label
                        >
                        <input
                            v-model="form.name"
                            type="text"
                            class="w-full px-4 py-2 border border-slate-200 rounded-lg outline-none focus:border-blue-600 transition duration-300"
                            placeholder="Enter category name"
                        />
                        <span v-if="form.errors.name">
                            {{ form.errors.name }}
                        </span>
                    </div>
                    <div>
                        <label
                            class="block text-sm font-medium text-slate-700 mb-2"
                            >Category Description</label
                        >
                        <textarea
                            v-model="form.description"
                            class="no-resize w-full px-4 py-2 border border-slate-200 rounded-lg outline-none focus:border-blue-600 transition duration-300"
                            placeholder="Enter category description"
                        />
                        <span v-if="form.errors.description">
                            {{ form.errors.description }}
                        </span>
                    </div>
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

import IconBack from "@/icons/IconBack.vue";
import IconSave from "@/icons/IconSave.vue";

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
        onError: (error: any) => {
            console.error(error);
        },
    });
};
</script>
