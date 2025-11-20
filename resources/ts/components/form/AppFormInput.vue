<template>
    <div class="w-full">
        <div class="flex gap-2">
            <label
                v-if="props.label"
                :for="props.name"
                v-html="props.label"
                class="block text-sm font-medium"
                :class="props.error ? 'text-red-600': 'text-slate-700'"
            />
            <span v-if="props.required" class="text-sm text-slate-500" v-html="'*'"/>
        </div>
        <div class="relative">
            <input
                :id="getElementId"
                :name="props.name"
                :type="
                    props.type === 'password'
                        ? togglePassword
                            ? 'text'
                            : 'password'
                        : props.type
                "
                :placeholder="props.placeholder"
                :disabled="props.disabled"
                :autocomplete="props.autocomplete"
                :required="props.required"
                v-model="model"
                class="w-full px-4 py-2 border rounded-lg outline-none transition duration-300"
                :class="
                    props.error
                        ? 'border-red-200 focus:border-red-600'
                        : 'border-slate-200 focus:border-blue-600'
                "
            />

            <div
                class="absolute top-2 right-2"
                :class="props.error ? 'text-red-300' : 'text-slate-300'"
            >
                <IconEmail v-if="props.type === 'email'" />
                <IconPassword
                    v-if="props.type === 'password'"
                    @click="togglePassword = !togglePassword"
                    :toggle="togglePassword"
                    class="hover:text-slate-500 cursor-pointer"
                />
            </div>
        </div>
        <span
            v-if="props.error"
            v-html="props.error"
            class="text-red-500 text-sm"
        />
    </div>
</template>
<script setup lang="ts">
import IconEmail from "@/icons/form/IconEmail.vue";
import IconPassword from "@/icons/form/IconPassword.vue";

import { computed, ref } from "vue";

const model = defineModel();
interface Props {
    id?: string;
    name: string;
    label?: string;
    type?: "text" | "email" | "password" | "number";
    placeholder?: string;
    autocomplete?: string;
    disabled?: boolean;
    error?: string;
    required?: boolean,
}

const props = withDefaults(defineProps<Props>(), {
    type: "text",
    placeholder: "...",
    disabled: false,
    required: false,
});

const togglePassword = ref<boolean>(false);

const getElementId = computed((): string => props.id ?? props.name);
</script>
