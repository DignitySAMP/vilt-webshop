<template>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 mb-6 p-4">
        <AppFormInputSearch
            placeholder="Search categories..."
            @on-search-query="onSearch"
            v-model="searchQuery"
        />
    </div>
</template>
<script setup lang="ts">
import { usePage, router } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import { index } from "@/wayfinder/routes/category";
import { type PageProps } from "@/types/inertia";

import AppFormInputSearch from "@/components/form/AppFormInputSearch.vue";

const searchQuery = ref("");

const onSearch = () => {
    router.get(
        index(),
        {
            // data
            search: searchQuery.value,
        },
        {
            // options
            replace: true,
        },
    );
};

onMounted(() => (searchQuery.value = usePage<PageProps>().props.filter.search));
</script>
