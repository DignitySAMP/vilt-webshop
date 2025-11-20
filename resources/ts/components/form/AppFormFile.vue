<template>
    <div class="w-full">
        <div class="flex gap-2">
            <label
                v-if="props.label"
                :for="props.name"
                v-html="props.label"
                class="block text-sm font-medium text-slate-700"
            />
            <span v-if="props.required" class="text-sm text-slate-500" v-html="'*'"/>
        </div>

        <input
            :id="getElementId"
            :name="props.name"
            type="file"
            :accept="props.accept"
            :disabled="props.disabled"
            @input="emit('on-file-upload', $event)"
            class="w-full px-4 py-2 border rounded-lg outline-none transition duration-300 cursor-pointer file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-sm file:font-medium file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200"
            :class="
                props.error
                    ? 'border-red-200 focus:border-red-600'
                    : 'border-slate-200 focus:border-blue-600'
            "
        />

        <span
            v-if="props.error"
            v-html="props.error"
            class="text-red-500 text-sm block mt-1"
        />
    </div>
</template>

<script setup lang="ts">
import { computed } from "vue";

const emit = defineEmits(["on-file-upload"]);
/*
    @on-file-upload should be caught with am evnet:

    const handleFileSelect = (event: Event) => {
        const file = (event.target as HTMLInputElement).files?.[0] || null;
    }
*/

interface Props {
    id?: string;
    name: string;
    label?: string;
    accept?: string;
    disabled?: boolean;
    error?: string;
    required?: boolean,
}

const props = withDefaults(defineProps<Props>(), {
    accept: "image/*",
    disabled: false,
    required: false,
});

const getElementId = computed((): string => props.id ?? props.name);
</script>
