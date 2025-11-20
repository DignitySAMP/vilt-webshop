<template>
    <AppGuestLayout title="Register an account">
        <form @submit.prevent class="flex flex-col gap-2">
            <AppFormInput
                placeholder="Firstname Lastname"
                name="input_name"
                label="Name"
                type="text"
                autocomplete="name"
                v-model="form.name"
                :error="form.errors.name"
                :disabled="form.processing"
            />
            <AppFormInput
                placeholder="your@email.com"
                name="email"
                label="E-mail Address"
                type="email"
                autocomplete="email"
                v-model="form.email"
                :error="form.errors.email"
                :disabled="form.processing"
            />
            <AppFormInput
                placeholder="**************"
                name="password"
                label="Password"
                type="password"
                autocomplete="password"
                v-model="form.password"
                :error="form.errors.password"
                :disabled="form.processing"
            />
            <AppFormInput
                placeholder="**************"
                name="password_confirmation"
                label="Password (confirm)"
                type="password"
                autocomplete="new-password"
                v-model="form.password_confirmation"
                :error="form.errors.password_confirmation"
                :disabled="form.processing"
            />

            <div class="flex justify-end text-sm text-gray-600">
                <Link :href="login()" class="hover:underline" view-transition>
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

import { store } from "@/wayfinder/routes/register"; // form
import { login } from "@/wayfinder/routes"; // redirect

import AppGuestLayout from "@/layout/AppGuestLayout.vue";
import AppFormButton from "@/components/form/AppFormButton.vue";
import AppFormInput from "@/components/form/AppFormInput.vue";

const form: InertiaForm<{
    name: string;
    email: string;
    password: string;
    password_confirmation: string;
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
