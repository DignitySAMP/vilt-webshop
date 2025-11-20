<template>
    <div class="w-full">
        <label
            v-if="props.label"
            :for="props.name"
            v-html="props.label"
            class="block text-sm font-medium text-slate-700"
        />
        <select
            :id="getElementId"
            :name="props.name"
            v-model="model"
            class="w-full px-4 py-2 border border-slate-200 rounded-lg outline-none focus:border-blue-600 transition duration-300"
        >
            <option
                v-for="(option, index) in props.options"
                :key="index"
                :value="option.value"
            >
                {{ option.label }}
            </option>
        </select>
        <span
            v-if="props.error"
            v-html="props.error"
            class="text-red-500 text-sm"
        />
    </div>
</template>
<script setup lang="ts">
import { computed } from "vue";
const model = defineModel();

interface Option {
    label: string;
    value: string | number;
}

interface Props {
    id?: string;
    name: string;
    label?: string;
    options: Option[];
    error?: string;
}

const props = defineProps<Props>();

const getElementId = computed((): string => props.id ?? props.name);
</script>
