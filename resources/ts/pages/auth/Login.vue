<template>
    <AppGuestLayout>
        <form @submit.prevent class="flex flex-col gap-2">
            <div class="flex flex-col gap-2">
                <label class="text-sm text-gray-700" for="email"
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
                <label class="text-sm text-gray-700" for="password"
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

            <div class="flex items-center gap-2">
                <input
                    type="checkbox"
                    name="remember"
                    id="remember"
                    v-model="form.remember"
                    autocomplete="remember"
                    class="size-4 checked:accent-gray-500"
                />
                <label class="text-sm text-gray-700" for="remember"
                    >Remember me?</label
                >
            </div>

            <div class="flex justify-between text-sm text-gray-600">
                <Link
                    :href="register()"
                    class="hover:underline"
                    view-transition
                >
                    Don't have an account yet?
                </Link>

                <Link
                    :href="request()"
                    class="hover:underline"
                    view-transition
                >
                    Forgot your password?
                </Link>
            </div>

            <div class="flex w-full">
                <button
                    :disabled="form.processing"
                    type="submit"
                    @click="submit"
                    class="w-full cursor-pointer rounded bg-blue-600 px-4 py-2 text-gray-50 outline-blue-500/50 transition duration-300 hover:bg-blue-700 focus:outline-4"
                >
                    Log in
                </button>
            </div>
        </form>
    </AppGuestLayout>
</template>
<script setup lang="ts">
import AppGuestLayout from "@/layout/AppGuestLayout.vue";
import { InertiaForm, Link, useForm } from "@inertiajs/vue3";
// form
import { store } from '@/wayfinder/routes/login';

// redirects
import { register } from '@/wayfinder/routes';
import { request } from '@/wayfinder/routes/password';

const form: InertiaForm<{
    email: string;
    password: string;
    remember: boolean
}> = useForm({
    email: "", // OR username: ''
    password: "",
    remember: false,
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
