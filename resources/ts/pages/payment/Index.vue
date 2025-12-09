<template>
    <AppLayout>
        <div class="max-w-[1400px] mx-auto p-3 md:p-6">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-slate-900">Checkout</h1>
                <p class="text-slate-600 mt-1">
                    Review your items and choose a payment method.
                </p>
            </div>

            <div class="grid lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    <div
                        class="bg-white rounded-xl p-6 shadow-sm border border-slate-200"
                    >
                        <h2 class="text-xl font-semibold text-slate-900 mb-4">
                            Shipping Information
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <AppFormInput
                                name="first_name"
                                placeholder="First Name"
                            />
                            <AppFormInput
                                name="last_name"
                                placeholder="Last Name"
                            />
                            <AppFormInput
                                name="email"
                                placeholder="Email"
                                type="email"
                            />
                            <AppFormInput
                                name="phone"
                                placeholder="Phone Number"
                            />
                            <AppFormInput
                                name="address"
                                placeholder="Address"
                                class="md:col-span-2"
                            />
                            <AppFormInput name="city" placeholder="City" />
                            <AppFormInput
                                name="postal_code"
                                placeholder="Postal Code"
                            />
                            <AppFormSelectCountry
                                name="country"
                                placeholder="Country"
                            />
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-xl p-6 shadow-sm border border-slate-200"
                    >
                        <h2 class="text-xl font-semibold text-slate-900 mb-4">
                            Payment Method
                        </h2>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div
                                v-for="method in paymentMethods"
                                :key="method.id"
                                @click="selectedPayment = method.id"
                                :class="[
                                    'flex flex-col items-center p-4 rounded-lg border cursor-pointer transition-all hover:shadow-lg',
                                    selectedPayment === method.id
                                        ? 'border-blue-500 ring-2 ring-blue-200'
                                        : 'border-slate-200',
                                ]"
                            >
                                <component
                                    :is="method.icon"
                                    :alt="method.name"
                                    class="h-12 object-contain mb-2"
                                />
                                <span
                                    class="text-sm font-medium text-slate-700"
                                    >{{ method.name }}</span
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div
                        class="bg-white rounded-xl p-6 shadow-sm border border-slate-200"
                    >
                        <h2 class="text-xl font-semibold text-slate-900 mb-4">
                            Order Summary
                        </h2>

                        <div
                            v-for="product in cartItems"
                            :key="product.id"
                            class="flex justify-between items-center mb-4"
                        >
                            <div class="flex gap-3 items-center">
                                <img
                                    :src="product.image_url"
                                    class="w-16 h-16 object-cover rounded-lg"
                                />
                                <div>
                                    <p
                                        class="font-medium text-slate-900 text-sm truncate"
                                    >
                                        {{ product.name }}
                                    </p>
                                    <p class="text-slate-500 text-xs">
                                        Qty: {{ product.quantity }}
                                    </p>
                                </div>
                            </div>
                            <p class="text-slate-900 font-semibold text-sm">
                                ${{
                                    (product.price * product.quantity).toFixed(
                                        2,
                                    )
                                }}
                            </p>
                        </div>

                        <div class="border-t border-slate-200 pt-4 space-y-2">
                            <div
                                class="flex justify-between text-sm text-slate-600"
                            >
                                <span>Subtotal</span>
                                <span>${{ subtotal.toFixed(2) }}</span>
                            </div>
                            <div
                                class="flex justify-between text-sm text-slate-600"
                            >
                                <span>Shipping</span>
                                <span class="text-green-600">Free</span>
                            </div>
                            <div
                                class="flex justify-between text-lg font-bold text-slate-900 pt-2 border-t border-slate-200"
                            >
                                <span>Total</span>
                                <span>${{ total.toFixed(2) }}</span>
                            </div>
                        </div>

                        <div class="mt-6">
                            <AppFormButton
                                name="btn_pay_now"
                                text="Pay Now"
                                theme="primary"
                                class="w-full"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { markRaw, ref } from "vue";

import AppLayout from "@/layout/AppLayout.vue";
import AppFormInput from "@/components/form/AppFormInput.vue";
import AppFormButton from "@/components/form/AppFormButton.vue";
import AppFormSelectCountry from "@/components/form/AppFormSelectCountry.vue";

import IconVISA from "@/icons/logo/IconVISA.vue";
import IconMasterCard from "@/icons/logo/IconMasterCard.vue";
import IconAmericanExpress from "@/icons/logo/IconAmericanExpress.vue";
import IconPaypal from "@/icons/logo/IconPaypal.vue";

// tmp
const cartItems = ref([
    {
        id: 1,
        name: "Product A",
        price: 29.99,
        quantity: 2,
        image_url: "/images/product-a.jpg",
    },
    {
        id: 2,
        name: "Product B",
        price: 15.5,
        quantity: 1,
        image_url: "/images/product-b.jpg",
    },
    {
        id: 3,
        name: "Product C",
        price: 42.0,
        quantity: 3,
        image_url: "/images/product-c.jpg",
    },
]);

// tmp
const subtotal = ref(
    cartItems.value.reduce((sum, item) => sum + item.price * item.quantity, 0),
);
// tmp
const total = ref(subtotal.value); // shipping is free, make it so there is a dropdown with icons and locations.
// TODO: base shipping fee on distance OR is there some sort of API to use? investigate!

// tmp - must be made dynamic
const paymentMethods = ref([
    { id: "paypal", name: "PayPal", icon: markRaw(IconPaypal), link: "#" },
    { id: "visa", name: "Visa", icon: markRaw(IconVISA), link: "#" },
    { id: "mastercard", name: "Mastercard", icon: markRaw(IconMasterCard), link: "#" },
    {
        id: "amex",
        name: "American Express",
        icon: markRaw(IconAmericanExpress),
        link: "#",
    },
]);

const selectedPayment = ref("paypal");
</script>
