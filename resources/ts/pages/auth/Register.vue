<template>
    <AppGuestLayout title="Register an account">
        <form @submit.prevent class="flex flex-col gap-2">
            <div class="flex flex-col gap-2">
                <label for="name" class="text-sm text-gray-700">Name</label>
                <input
                    type="name"
                    name="name"
                    id="name"
                    v-model="form.name"
                    autocomplete="name"
                    class="rounded border border-gray-200 px-4 py-1 shadow outline-gray-600/50 focus:outline-4"
                />
                <span
                    v-if="form.errors.name"
                    v-html="form.errors.name"
                    class="text-sm text-red-700"
                />
            </div>

            <div class="flex flex-col gap-2">
                <label for="email" class="text-sm text-gray-700"
                    >Email address</label
                >
                <input
                    type="email"
                    name="email"
                    id="email"
                    v-model="form.email"
                    autocomplete="email"
                    class="rounded border border-gray-200 px-4 py-1 shadow outline-gray-600/50 focus:outline-4"
                />
                <span
                    v-if="form.errors.email"
                    v-html="form.errors.email"
                    class="text-sm text-red-700"
                />
            </div>

            <div class="flex flex-col gap-2">
                <label for="password" class="text-sm text-gray-700"
                    >Password</label
                >
                <input
                    type="password"
                    name="password"
                    id="password"
                    v-model="form.password"
                    autocomplete="password"
                    class="rounded border border-gray-200 px-4 py-1 shadow outline-gray-600/50 focus:outline-4"
                />
                <span
                    v-if="form.errors.password"
                    v-html="form.errors.password"
                    class="text-sm text-red-700"
                />
            </div>

            <div class="flex flex-col gap-2">
                <label for="password_confirmation" class="text-sm text-gray-700"
                    >Password Confirmation</label
                >
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    autocomplete="new-password"
                    class="rounded border border-gray-200 px-4 py-1 shadow outline-gray-600/50 focus:outline-4"
                />
                <span
                    v-if="form.errors.password_confirmation"
                    v-html="form.errors.password_confirmation"
                    class="text-sm text-red-700"
                />
            </div>

            <div class="flex justify-end text-sm text-gray-600">
                <Link
                    :href="login()"
                    class="hover:underline"
                    view-transition
                >
                    Already have an account?
                </Link>
            </div>

            <div class="flex w-full">
                <AppFormButton
                    name="btn_register"
                    :disabled="form.processing"
                    type="submit"
                    @click="submit"
                    text="Register"
                />
            </div>
        </form>
    </AppGuestLayout>
</template>
<script setup lang="ts">
import { InertiaForm, Link, useForm } from "@inertiajs/vue3";

import { store } from '@/wayfinder/routes/register' // form
import { login } from '@/wayfinder/routes' // redirect

import AppGuestLayout from "@/layout/AppGuestLayout.vue";
import AppFormButton from "@/components/form/AppFormButton.vue";

const form: InertiaForm<{
        name: string,
        email: string,
        password: string,
        password_confirmation: string
    }> = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.submit(store(), {
        preserveScroll: true,
        onSuccess: () => form.reset("password"),
        onError: (error) => console.error(error),
        onFinish: () => form.reset(),
    });
};
</script>
