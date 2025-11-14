<template>
    <header class="mt-4 flex w-full justify-center">
        <Link :href="route('home')" view-transition>
            <img
                src="https://laravel.com/img/notification-logo.png"
                alt="Laravel Logo"
                class="size-32"
            />
        </Link>
    </header>

    <main class="container mx-auto mt-4 max-w-2xl rounded bg-white p-6 shadow">
        <slot />
    </main>
    <footer class="mt-2 flex w-full justify-center text-sm text-gray-400">
        All rights reserved. Footer goes here.
    </footer>
</template>
<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
</script>
