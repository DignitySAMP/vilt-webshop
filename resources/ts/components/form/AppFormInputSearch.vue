<template>
    <div class="flex items-center relative w-full">
        <IconSearch
            class="size-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"
        />
        <input
            v-model="model"
            @change="emit('on-search-query')"
            type="text"
            :placeholder="props.placeholder"
            class="w-full pl-10 pr-4 py-2 rounded-lg outline-none focus:border-blue-600 transition duration-300"
            :class="props.borders ? 'border border-slate-200' : ''"
        />
        <span
            v-if="model"
            @click="resetSearchText"
            class="text-slate-400 absolute top-1 right-1 p-2 cursor-pointer hover:scale-115 transition duration-300"
        >
            <IconClose class="size-5" />
        </span>
    </div>
</template>
<script setup lang="ts">
import IconSearch from "@/icons/form/IconSearch.vue";
import IconClose from "@/icons/form/IconClose.vue";

const model = defineModel();
const emit = defineEmits(["on-search-query"]);

const props = withDefaults(
    defineProps<{
        placeholder?: string;
        borders?: boolean;
    }>(),
    {
        borders: true,
        placeholder: "Search...",
    },
);

const resetSearchText = () => {
    model.value = "";
    emit("on-search-query");
};
</script>
