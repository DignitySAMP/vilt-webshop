<template>
    <span
        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition duration-300"
        @click="showDeleteModal = !showDeleteModal"
    >
        <IconDelete />
    </span>

    <AppModal :show="showDeleteModal" @close="showDeleteModal = false">
        <div class="flex flex-col gap-2">
            <h1 class="text-lg font-bold text-slate-900">Delete Category</h1>

            <p class="text-sm text-slate-500 mt-1">
                If you wish to delete {{ props.name }}, please press the button
                below to confirm your choice. This action is irreversible.
            </p>

            <div class="flex flex-col text-sm">
                <span class="text-slate-500">
                    <span class="font-bold"> Description: </span>
                    {{ props.description }}
                </span>
                <div class="flex flex-col gap-1 text-slate-500">
                    <div class="flex gap-1">
                        <span class="font-bold"> Item count: </span>
                        <span>{{ props.item_count }}</span>
                    </div>
                    <span class="text-slate-500 text-sm">
                        Warning: these will also be removed!
                    </span>
                </div>
            </div>
            <AppFormButton
                name="btn_delete_category"
                @click="submit"
                :text="`Delete ${props.name}`"
                theme="error"
            />
        </div>
    </AppModal>
</template>
<script setup lang="ts">
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { ItemCategory } from "@/types";
import { destroy } from "@/wayfinder/routes/category";

import AppModal from "@/components/AppModal.vue";
import IconDelete from "@/icons/crud/IconDelete.vue";
import AppFormButton from "@/components/form/AppFormButton.vue";

const showDeleteModal = ref<boolean>(false);
const props = defineProps<ItemCategory>();
const form = useForm({});
const submit = () => {
    form.submit(destroy(props.id), {
        preserveScroll: true,
        onError: (error: any) => {
            console.error(error);
        },
        onFinish: () => {
            form.reset();
            showDeleteModal.value = false;
        },
    });
};
</script>
