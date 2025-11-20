<template>
    <AppGuestLayout title="Confirm your password">
        <div class="flex flex-col gap-2">
            <span class="text-sm">
                In order to access this part of the application, you must
                confirm your password. Please enter it in the field below and
                submit in order to procees.
            </span>

            <form @submit.prevent class="flex flex-col gap-2">
                <AppFormInput
                    placeholder="**************"
                    name="password"
                    label="Password Confirmation"
                    type="password"
                    autocomplete="password"
                    v-model="form.password"
                    :error="form.errors.password"
                    :disabled="form.processing"
                />
            </form>

            <div class="flex w-full">
                <AppFormButton
                    name="btn_register"
                    :disabled="form.processing"
                    type="submit"
                    @click="submit"
                    text="Confirm password"
                />
            </div>
        </div>
    </AppGuestLayout>
</template>
<script setup lang="ts">
import { InertiaForm, useForm } from "@inertiajs/vue3";
import { store } from "@/wayfinder/routes/password/confirm";
import AppGuestLayout from "@/layout/AppGuestLayout.vue";
import AppFormButton from "@/components/form/AppFormButton.vue";
import AppFormInput from "@/components/form/AppFormInput.vue";

const form: InertiaForm<{
    password: string;
}> = useForm({
    password: "",
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
