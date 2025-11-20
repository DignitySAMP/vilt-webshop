<template>
    <AppGuestLayout title="Authenticate yourself">
        <form @submit.prevent class="flex flex-col gap-2">
            <AppFormInput
                placeholder="your@email.com"
                name="email"
                label="E-mail address"
                type="email"
                autocomplete="email"
                v-model="form.email"
                :error="form.errors.email"
                :disabled="form.processing"
                :required="true"
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
                :required="true"
            />

            <AppFormCheckbox
                name="remember"
                v-model="form.remember"
                label="Remember me?"
                autocomplete="remember"
            />

            <div class="flex justify-between text-sm text-gray-600">
                <Link
                    :href="register()"
                    class="hover:underline"
                    view-transition
                >
                    Don't have an account yet?
                </Link>

                <Link :href="request()" class="hover:underline" view-transition>
                    Forgot your password?
                </Link>
            </div>

            <div class="flex w-full">
                <AppFormButton
                    name="btn_register"
                    :disabled="form.processing"
                    type="submit"
                    @click="submit"
                    text="Log in"
                />
            </div>
        </form>
    </AppGuestLayout>
</template>
<script setup lang="ts">
import { InertiaForm, Link, useForm } from "@inertiajs/vue3";
import { store } from "@/wayfinder/routes/login";
import { register } from "@/wayfinder/routes";
import { request } from "@/wayfinder/routes/password";

import AppGuestLayout from "@/layout/AppGuestLayout.vue";
import AppFormButton from "@/components/form/AppFormButton.vue";
import AppFormInput from "@/components/form/AppFormInput.vue";
import AppFormCheckbox from "@/components/form/AppFormCheckbox.vue";
import { toast } from "vue3-toastify";

const form: InertiaForm<{
    email: string;
    password: string;
    remember: boolean;
}> = useForm({
    email: "", // OR username: ''
    password: "",
    remember: false,
});

const submit = () => {
    form.submit(store(), {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('You have logged in.');
            form.reset("password");
        },
        onError: (error) => {
            for(const key in error) {
                toast.error(error[key]);
            }
            console.error(error);
        },
        onFinish: () => form.reset(),
    });
};
</script>
