<template>
    <button
        :id="getElementId"
        :name="props.name"
        class="p-2 hover:bg-slate-100 text-slate-500 rounded-lg transition duration-300"
        :class="
            props.background
                ? 'bg-slate-100 hover:bg-slate-200 '
                : 'hover:bg-slate-100'
        "
    >
        <span class="size-5">
            <component :is="props.icon" />
        </span>
    </button>
</template>
<script setup lang="ts">
import { computed, type Component } from "vue";

interface Props {
    id?: string;
    name: string;
    icon?: Component;
    background?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    background: false,
});
const getElementId = computed((): string => props.id ?? props.name);
</script>
