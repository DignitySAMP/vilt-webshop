<template>
    <AppGuestLayout title="Confirm your password">
        <div class="flex flex-col gap-2">
            <span class="text-sm">
                In order to access this part of the application, you must
                confirm your password. Please enter it in the field below and
                submit in order to procees.
            </span>

            <form @submit.prevent class="flex flex-col gap-2">
                <label for="password" class="text-sm text-gray-700"
                    >Password Confirmation</label
                >
                <input
                    type="password"
                    name="password"
                    id="password"
                    v-model="form.password"
                    class="rounded border border-gray-200 px-4 py-1 shadow outline-gray-600/50 focus:outline-4"
                />
                <span
                    v-if="form.errors.password"
                    v-html="form.errors.password"
                    class="text-sm text-red-700"
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
import { store } from '@/wayfinder/routes/password/confirm';
import AppGuestLayout from "@/layout/AppGuestLayout.vue";
import AppFormButton from "@/components/form/AppFormButton.vue";

const form: InertiaForm<{
    password: string,
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
