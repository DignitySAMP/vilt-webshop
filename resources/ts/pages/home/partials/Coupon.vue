<template>
    <div
        class="bg-linear-to-br from-blue-600 to-indigo-700 rounded-xl p-3 md:p-6 text-white"
    >
        <div class="flex items-center md:gap-3 md:mb-3">
            <IconCoupon class="size-6" />
            <h3 class="font-semibold">Special Offer</h3>
        </div>
        <p class="text-sm text-blue-100 md:mb-4">
            Get 20% off your first order with code WELCOME20
        </p>

        <AppFormButton
            name="btn_coupon"
            text="Copy Code"
            theme="light-blue"
            class="text-sm"
        />
    </div>
</template>
<script setup lang="ts">
import AppFormButton from "@/components/form/AppFormButton.vue";
import IconCoupon from "@/icons/shop/IconCoupon.vue";
</script>
