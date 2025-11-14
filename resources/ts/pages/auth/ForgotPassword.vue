<template>
    <AppLayout>
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

            <div class="flex justify-between text-sm text-gray-600">
                <Link
                    :href="route('login')"
                    class="hover:underline"
                    view-transition
                >
                    Remember your credentials?
                </Link>

                <Link
                    :href="route('register')"
                    class="hover:underline"
                    view-transition
                >
                    Don't have an account yet?
                </Link>
            </div>

            <div class="flex w-full">
                <button
                    :disabled="form.processing"
                    type="submit"
                    @click="submit"
                    class="w-full cursor-pointer rounded bg-gray-800 px-4 py-2 text-gray-50 outline-gray-600/50 transition duration-300 hover:bg-gray-600 focus:outline-4"
                >
                    Request new password
                </button>
            </div>
        </div>
    </AppLayout>
</template>
<script setup lang="ts">
import AppLayout from "@/layout/AppLayout.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";

const form = useForm({
    email: "",
});

const submit = () => {
    form.post(route("password.email"), {
        preserveScroll: true,
        onSuccess: () => form.reset("email"),
        onError: (error) => console.error(error),
        onFinish: () => form.reset(),
    });
};
</script>
