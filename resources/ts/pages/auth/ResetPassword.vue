<template>
    <AppGuestLayout>
        <div class="flex flex-col gap-2">
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
                    autocomplete="new-password"
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
                    class="rounded border border-gray-200 px-4 py-1 shadow outline-gray-600/50 focus:outline-4"
                />
                <span
                    v-if="form.errors.password_confirmation"
                    v-html="form.errors.password_confirmation"
                    class="text-sm text-red-700"
                />
            </div>

            <div class="flex w-full">
                <button
                    :disabled="form.processing"
                    type="submit"
                    @click="submit"
                    class="w-full cursor-pointer rounded bg-blue-600 px-4 py-2 text-gray-50 outline-blue-500/50 transition duration-300 hover:bg-blue-700 focus:outline-4"
                >
                    Reset Password
                </button>
            </div>
        </div>
    </AppGuestLayout>
</template>
<script setup lang="ts">
import AppGuestLayout from "@/layout/AppGuestLayout.vue";
import { InertiaForm, useForm } from "@inertiajs/vue3";
import { update } from '@/wayfinder/routes/password';

interface Props {
    token: string;
    email: string;
}

const props = defineProps<Props>();

const form: InertiaForm<{
    email: string,
    password: string,
    password_confirmation: string
}> = useForm({
    email: props.email,
    password: "",
    password_confirmation: "",
    token: props.token,
});

const submit = () => {
    form.submit(update(), {
        preserveScroll: true,
        onSuccess: () => form.reset("password"),
        onError: (error) => console.error(error),
        onFinish: () => form.reset(),
    });
};
</script>
