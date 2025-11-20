<template>

    <button
        :id="getElementId" :name="props.name"
        :class="getStyle()"
    >
        <div class="flex items-center gap-4 w-full text-center" :class="props.icon !== undefined ? 'w-full justify-between' : 'justify-center'">
            <component v-if="props.icon !== undefined" :is="props.icon" />
            <span class="font-medium">
                {{ props.text }}
            </span>
        </div>
    </button>
</template>
<script setup lang="ts">
// TODO: !!!!!!! Replace all <Link> and <button> before committing...

import { type Component, computed } from 'vue';

interface Props {
    name: string;
    text: string;
    id?: string;
    type?: string;
    icon?: Component
    theme?: "primary" | "secondary" | "error" | "light-blue";
    disabled?: boolean,
}

const props = withDefaults(defineProps<Props>(), {
    type: "button",
    theme: "primary",
    disabled: false
});


const getStyle = () => {
    const style = ["px-4 py-2 w-full rounded-md transition duration-300 flex items-center gap-2"];

    if(props.disabled) {
        style.push("bg-slate-200 text-slate-500 cursor-not-allowed");
        return style;
    }

    switch(props.theme) {
        case "primary": style.push("bg-blue-600 hover:bg-blue-700 text-white"); break;
        case "light-blue": style.push("bg-white text-blue-600 hover:bg-blue-50"); break;
        case "error": style.push("bg-red-600 hover:bg-red-700 text-white"); break;
        default: style.push(" border border-slate-200 bg-slate-100 hover:bg-slate-200 text-slate-600"); break;
    }

    return style.join(" ");
}

const getElementId = computed((): string => props.id ?? props.name);
</script>