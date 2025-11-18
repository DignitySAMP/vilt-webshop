<template>
    <AppLayout>
        <div class="flex flex-col gap-2">
            <div
                v-if="
                    usePage().props.status !== null &&
                    usePage().props.status === 'verification-link-sent'
                "
                class="rounded border border-green-300 bg-green-100 px-4 py-2 text-center text-sm text-green-800"
            >
                A new verification link has been sent to the email address you
                provided during registration.
            </div>

            <span class="text-sm">
                In order to access this part of the application, you must verify
                your e-mail address. You should have recieved an e-mail during
                your registration.
            </span>
            <span class="text-sm">
                If you lost the e-mail, you may click the button below to
                request a new verification e-mail.
            </span>

            <div class="flex w-full">
                <button
                    :disabled="form.processing"
                    type="button"
                    @click="form.post(route('verification.send'))"
                    class="w-full cursor-pointer rounded bg-blue-600 px-4 py-2 text-gray-50 outline-blue-500/50 transition duration-300 hover:bg-blue-700 focus:outline-4"
                >
                    Request new link
                </button>
            </div>

            <div class="flex justify-end text-sm text-gray-600">
                <span
                    click="form.post(route('logout'))"
                    class="hover:underline"
                >
                    Log out
                </span>
            </div>
        </div>
    </AppLayout>
</template>
<script setup lang="ts">
import AppLayout from "@/layout/AppLayout.vue";
import { useForm, usePage } from "@inertiajs/vue3";
const form = useForm({});
</script>
