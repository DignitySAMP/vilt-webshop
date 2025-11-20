<template>
    <AppGuestLayout title="Forgot your password?">
        <div class="flex flex-col gap-2">
            <span
                v-if="usePage().props.status"
                v-html="usePage().props.status"
                class="rounded border border-green-300 bg-green-100 px-4 py-2 text-sm text-green-800"
            />

            <span class="text-sm text-gray-700">
                If you forgot your password, enter your e-mail below to recieve
                an e-mail with a reset link.
            </span>

            <form @submit.prevent class="flex flex-col gap-2">
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
            </form>

            <div class="flex justify-between text-sm text-gray-600">
                <Link :href="login()" class="hover:underline" view-transition>
                    Remember your credentials?
                </Link>

                <Link
                    :href="register()"
                    class="hover:underline"
                    view-transition
                >
                    Don't have an account yet?
                </Link>
            </div>

            <div class="flex w-full">
                <AppFormButton
                    name="btn_register"
                    :disabled="form.processing"
                    type="submit"
                    @click="submit"
                    text="Request new password"
                />
            </div>
        </div>
    </AppGuestLayout>
</template>
<script setup lang="ts">
import { InertiaForm, Link, useForm, usePage } from "@inertiajs/vue3";
import { email } from "@/wayfinder/routes/password";
import { login, register } from "@/wayfinder/routes";

import AppGuestLayout from "@/layout/AppGuestLayout.vue";
import AppFormButton from "@/components/form/AppFormButton.vue";
import AppFormInput from "@/components/form/AppFormInput.vue";

const form: InertiaForm<{
    email: string;
}> = useForm({
    email: "",
});

const submit = () => {
    form.submit(email(), {
        preserveScroll: true,
        onSuccess: () => form.reset("email"),
        onError: (error) => console.error(error),
        onFinish: () => form.reset(),
    });
};
</script>
