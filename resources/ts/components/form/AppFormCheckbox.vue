<template>
    <div class="flex items-center gap-2">
        <input
            type="checkbox"
            :name="props.name"
            :id="getElementId"
            v-model="model"
            :autocomplete="props.autocomplete"
            class="size-4 checked:accent-gray-500"
        />
        <label class="text-sm text-gray-700" :for="props.name">{{
            props.label
        }}</label>
    </div>
</template>
<script setup lang="ts">
import { computed } from "vue";

const model = defineModel();
interface Props {
    label: string;
    name: string;
    id?: string;
    autocomplete?: string;
}

const props = defineProps<Props>();

const getElementId = computed((): string => props.id ?? props.name);
</script>
