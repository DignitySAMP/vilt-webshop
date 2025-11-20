<template>
    <AppGuestLayout title="Reset your password">
        <div class="flex flex-col gap-2">
            <AppFormInput
                placeholder="your@email.com"
                name="email"
                label="E-mail Address"
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
                autocomplete="password-new"
                v-model="form.password"
                :error="form.errors.password"
                :disabled="form.processing"
                :required="true"
            />
            <AppFormInput
                placeholder="**************"
                name="password_confirmation"
                label="Password (confirm)"
                type="password"
                v-model="form.password_confirmation"
                :error="form.errors.password_confirmation"
                :disabled="form.processing"
                :required="true"
            />

            <div class="flex w-full">
                <AppFormButton
                    name="btn_register"
                    :disabled="form.processing"
                    type="submit"
                    @click="submit"
                    text="Reset password"
                />
            </div>
        </div>
    </AppGuestLayout>
</template>
<script setup lang="ts">
import { InertiaForm, useForm } from "@inertiajs/vue3";
import { update } from "@/wayfinder/routes/password";

import AppGuestLayout from "@/layout/AppGuestLayout.vue";
import AppFormButton from "@/components/form/AppFormButton.vue";
import AppFormInput from "@/components/form/AppFormInput.vue";
import { toast } from "vue3-toastify";

interface Props {
    token: string;
    email: string;
}

const props = defineProps<Props>();

const form: InertiaForm<{
    email: string;
    password: string;
    password_confirmation: string;
}> = useForm({
    email: props.email,
    password: "",
    password_confirmation: "",
    token: props.token,
});

const submit = () => {
    form.submit(update(), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset("password");
            toast.warning('Your password has been reset.');
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
