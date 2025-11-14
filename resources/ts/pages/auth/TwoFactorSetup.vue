<template>
    <AppLayout>
        <div
            v-if="usePage().props.mfa_enabled"
            class="flex flex-col gap-4 text-gray-700"
        >
            <span
                v-if="confirmed"
                class="rounded border border-green-300 bg-green-100 px-4 py-2 text-sm text-green-800"
            >
                You have enabled two factor authentication.
            </span>

            <button
                @click="submitDisable"
                class="flex w-full rounded bg-red-600 px-4 py-2 text-white hover:bg-red-500"
            >
                Disable 2FA
            </button>
        </div>
        <div v-else class="flex flex-col gap-4 text-gray-700">
            <button
                @click="submitEnable"
                class="rounded bg-gray-800 px-4 py-2 text-white transition duration-300 hover:bg-gray-600"
                :disabled="form.processing"
            >
                Enable 2FA
            </button>

            <div v-if="qrCode" class="flex flex-col gap-2">
                <span class="text-lg font-semibold">Scan the QR code</span>
                <div v-html="qrCode"></div>

                <div class="flex flex-col gap-2">
                    <input
                        type="text"
                        name="code"
                        id="code"
                        v-model="form.code"
                        placeholder="Code from your authenticator"
                        autocomplete="new-password"
                        class="rounded border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-gray-600 focus:outline-none"
                    />
                    <span
                        v-if="form.errors.code"
                        v-html="form.errors.code"
                        class="text-sm text-red-600"
                    ></span>
                </div>

                <button
                    type="button"
                    @click="submitConfirm"
                    :disabled="form.processing"
                    class="w-full cursor-pointer rounded bg-gray-800 px-4 py-2 text-gray-50 outline-gray-600/50 transition duration-300 hover:bg-gray-600 focus:outline-4"
                >
                    Confirm 2FA
                </button>

                <span
                    v-if="form.errors['confirmTwoFactorAuthentication']"
                    class="text-sm text-red-700"
                    v-html="form.errors['confirmTwoFactorAuthentication']"
                />
            </div>

            <div v-if="recoveryCodes?.length" class="flex flex-col gap-2">
                <div class="flex items-center gap-1">
                    <span class="text-lg font-semibold">Recovery Codes</span>
                    <span class="text-xs">(save these)</span>
                </div>

                <pre
                    class="rounded bg-gray-800 p-4 whitespace-pre text-gray-100"
                ><div v-for="code in recoveryCodes" :key="code">{{ code }}</div></pre>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { ref } from "vue";

import AppLayout from "@/layout/AppLayout.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import axios from "axios";

const form = useForm<
    {
        code: string;
    } & Record<string, string | string[]>
>({
    code: "",
});

const qrCode = ref(null);
const recoveryCodes = ref([]);

const submitEnable = () => {
    form.post(route("two-factor.enable"), {
        preserveScroll: true,
        onSuccess: async () => {
            await fetch2FAQRCode();
            await fetch2FARecoveryCodes();
        },
        onError: (error) => console.error(error),
        onFinish: () => form.reset(),
    });
};

const confirmed = ref(false);
const submitConfirm = () => {
    form.post(route("two-factor.confirm"), {
        preserveScroll: true,
        onSuccess: async () => {
            confirmed.value = true;
            await fetch2FARecoveryCodes(); // refresh codes after confirmation
        },
        onError: (error) => console.error(error),
        onFinish: () => form.reset(),
    });
};

const fetch2FAQRCode = async () => {
    try {
        const response = await axios.get(route("two-factor.qr-code"));
        qrCode.value = response.data.svg;
    } catch (error) {
        console.error(error);
    }
};

const fetch2FARecoveryCodes = async () => {
    try {
        const response = await axios.get(route("two-factor.recovery-codes"));
        recoveryCodes.value = response.data;
    } catch (error) {
        console.error(error);
    }
};

const submitDisable = () => {
    form.delete(route("two-factor.disable"), {
        preserveScroll: true,
        onSuccess: () => {
            qrCode.value = null;
            recoveryCodes.value = [];
        },
    });
};
</script>
