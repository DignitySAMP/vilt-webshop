<template>
    <span
        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition duration-300"
        @click="showDeleteModal = !showDeleteModal"
    >
        <IconDelete />
    </span>

    <AppModal :show="showDeleteModal" @close="showDeleteModal = false">
        <div class="flex flex-col gap-2">
            <h1 class="text-lg font-bold text-slate-900">Delete Item</h1>

            <p class="text-sm text-slate-500 mt-1">
                If you wish to delete {{ props.name }}, please press the button
                below to confirm your choice. This action is irreversible.
            </p>

            <div class="flex flex-col text-sm">
                <span class="text-slate-500">
                    <span class="font-bold"> Description: </span>
                    <span class="truncate">{{ props.description }}</span>
                </span>
                <span class="text-slate-500">
                    <span class="font-bold"> Price: </span>
                    $ {{ props.price.toFixed(2) }}
                </span>
                <span class="text-slate-500">
                    <span class="font-bold"> Stock: </span>
                    {{ props.stock }}
                </span>
            </div>

            <AppFormButton
                name="btn_item_delete"
                :text="`Delete ${props.name}`"
                theme="error"
                @click="submit"
            />
        </div>
    </AppModal>
</template>
<script setup lang="ts">
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { destroy } from "@/wayfinder/routes/item";
import { Item } from "@/types";

import AppModal from "@/components/AppModal.vue";
import IconDelete from "@/icons/crud/IconDelete.vue";
import AppFormButton from "@/components/form/AppFormButton.vue";

const props = defineProps<Item>();
const showDeleteModal = ref<boolean>(false);
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
