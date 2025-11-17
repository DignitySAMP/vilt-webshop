<template>
    <button
        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition duration-300"
        @click="showDeleteModal = !showDeleteModal"
    >
        <IconDelete />
    </button>

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
                    {{ props.description }}
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

            <button
                class="px-4 py-2 rounded-lg shadow-md w-full bg-red-600 text-white hover:bg-red-700"
            >
                Delete {{ props.name }}
            </button>
        </div>
    </AppModal>
</template>
<script setup lang="ts">
import { ref } from "vue";

import AppModal from "@/components/AppModal.vue";
import IconDelete from "@/icons/IconDelete.vue";

const showDeleteModal = ref<boolean>(false);

import { Item } from "@/types";
const props = defineProps<Item>();
</script>
