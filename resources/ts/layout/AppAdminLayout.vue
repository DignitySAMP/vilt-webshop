<template>

    <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        {{ pageProps.name ?? 'Laravel' }}
                    </h1>
                    <p class="text-sm text-slate-500 mt-1">
                        {{props.title}}
                    </p>
                </div>
                
                <div>
                    <slot name="header"/>
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto p-6">

        <slot name="body"/>

    </div>

</template>
<script setup lang="ts">
    import { usePage } from '@inertiajs/vue3';


    interface PageProps extends Record<string, unknown> {
        app?: {
            name?: string;
        };
    }

    const pageProps = usePage<PageProps>().props;

    const props = defineProps<{
        title: string
    }>();
</script>