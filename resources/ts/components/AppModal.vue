<template>
    <div
        v-if="props.show"
        class="fixed inset-0 backdrop-blur-sm bg-black/30 flex items-center justify-center z-50"
        @click="emit('close')"
    >
        <div class="bg-white rounded-md p-6 max-w-md w-full mx-4" @click.stop>
            <slot />
        </div>
    </div>
</template>

<script setup lang="ts">
interface Props { 
    show: boolean
}
const props = defineProps<Props>();

const emit = defineEmits(["close"]);
</script>
