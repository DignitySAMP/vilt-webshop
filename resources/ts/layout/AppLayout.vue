<template>
    <div class="min-h-screen bg-slate-50">
        <Header />

        <slot />
    </div>
</template>
<script setup lang="ts">
import Header from "@/layout/partials/Header.vue";
</script>
