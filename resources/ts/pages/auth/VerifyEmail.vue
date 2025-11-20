<template>
    <AppGuestLayout title="Verify your e-mail address">
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
                <AppFormButton
                    name="btn_register"
                    :disabled="form.processing"
                    type="submit"
                    @click="form.submit(send())"
                    text="Reset password"
                    :required="true"
                />
            </div>

            <div class="flex justify-end text-sm text-gray-600">
                <span @click="form.submit(logout())" class="hover:underline">
                    Log out
                </span>
            </div>
        </div>
    </AppGuestLayout>
</template>
<script setup lang="ts">
import { useForm, usePage } from "@inertiajs/vue3";
import { logout } from "@/wayfinder/routes";
import { send } from "@//wayfinder/routes/verification";

import AppGuestLayout from "@/layout/AppGuestLayout.vue";
import AppFormButton from "@/components/form/AppFormButton.vue";

const form = useForm({});
</script>
