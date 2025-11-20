<template>
    <AppAdminLayout>
        <template v-slot:header>
            <div class="flex items-center gap-4">
                <Link
                    :href="index()"
                    class="p-2 hover:bg-slate-100 rounded-lg transition duration-300"
                >
                    <IconBack class="size-5 text-slate-600" />
                </Link>
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Add New Category
                    </h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Create a new category
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <AppFormButton
                    @click="submit"
                    name="btn_create_category"
                    text="Create Category"
                    :icon="IconCreate"
                />
            </div>
        </template>

        <template v-slot:body>
            <div
                class="bg-white rounded-xl shadow-sm border border-slate-200 p-6"
            >
                <form @submit.prevent class="space-y-6">
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
                </form>
            </div>
        </template>
    </AppAdminLayout>
</template>
<script setup lang="ts">
import { useForm, Link, InertiaForm } from "@inertiajs/vue3";
import { index, store } from "@/wayfinder/routes/category";
import AppAdminLayout from "@/layout/AppAdminLayout.vue";

import IconBack from "@/icons/crud/IconBack.vue";
import IconCreate from "@/icons/crud/IconCreate.vue";
import AppFormButton from "@/components/form/AppFormButton.vue";
import AppFormInput from "@/components/form/AppFormInput.vue";
import { toast } from "vue3-toastify";

const form: InertiaForm<{
    name: string;
    description: string;
}> = useForm({
    name: "",
    description: "",
});

const submit = () => {
    form.submit(store(), {
        preserveScroll: true,
        onSuccess: () => toast.success("You have created a new item category."),
        onError: (error) => {
            for (const key in error) {
                toast.error(error[key]);
            }
        },
    });
};
</script>
