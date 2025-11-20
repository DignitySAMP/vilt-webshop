<template>
    <div ref="shoppingCartRef" class="relative">
        <AppFormIconButton
            name="btn_shopping_cart"
            :icon="IconShoppingCart"
            @click="showShoppingCart = !showShoppingCart"
        />
        <span
            v-if="cartItemCount > 0"
            class="absolute -top-1 -right-1 bg-blue-600 text-white text-xs size-5 rounded-full flex items-center justify-center font-medium"
        >
            {{ cartItemCount }}
        </span>

        <aside
            v-if="showShoppingCart"
            class="absolute right-1 w-96 top-8 space-y-6"
        >
            <div
                class="bg-white rounded-xl p-6 shadow-2xl border border-slate-200 lg:sticky top-24"
            >
                <h2 class="text-lg font-semibold text-slate-900 mb-4">
                    Shopping Cart
                </h2>

                <div
                    v-if="
                        !shopping_cart_store.shoppingBasket &&
                        (!shopping_cart_store.shoppingBasketItems ||
                            shopping_cart_store.shoppingBasketItems.length ===
                                0)
                    "
                    class="text-center py-8"
                >
                    <IconShoppingCart
                        class="size-16 text-slate-300 mx-auto mb-3"
                    />
                    <p class="text-slate-500 text-sm">Your cart is empty</p>
                </div>

                <div
                    v-if="
                        shopping_cart_store.shoppingBasket &&
                        shopping_cart_store.shoppingBasketItems &&
                        shopping_cart_store.shoppingBasketItems.length > 0
                    "
                    class="space-y-4 mb-6"
                >
                    <div
                        v-for="product in shopping_cart_store.shoppingBasketItems"
                        :key="product.id"
                        class="flex gap-3 w-full pb-4 border-b border-slate-100"
                    >
                        <img
                            :src="product?.item?.image_url"
                            class="size-16 bg-slate-100 rounded-lg flex items-center justify-center text-2xl shrink-0"
                        />
                        <div class="flex w-full flex-col gap-2">
                            <div
                                class="flex justify-between w-full gap-2 min-w-0"
                            >
                                <h4
                                    class="font-medium text-slate-900 max-w-40 text-sm truncate"
                                >
                                    {{ product?.item?.name }}
                                </h4>
                                <p class="text-slate-600 text-sm mb-2">
                                    ${{ product?.item?.price.toFixed(2) }}
                                </p>
                            </div>
                            <div>
                                <div
                                    class="flex justify-end items-center gap-2"
                                >
                                    <AppFormIconButton
                                        name="btn_shopping_cart_minus"
                                        :icon="IconMinus"
                                        :background="true"
                                        @click="
                                            shopping_cart_store.updateItemInBasket(
                                                product.id,
                                                product.item,
                                                product?.amount - 1,
                                            )
                                        "
                                    />
                                    <span
                                        class="text-sm font-medium text-slate-700 w-8 text-center"
                                        >{{ product?.amount }}</span
                                    >
                                    <AppFormIconButton
                                        name="btn_shopping_cart_plus"
                                        :icon="IconPlus"
                                        :background="true"
                                        @click="
                                            shopping_cart_store.updateItemInBasket(
                                                product.id,
                                                product.item,
                                                product?.amount + 1,
                                            )
                                        "
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    v-if="
                        shopping_cart_store.shoppingBasket &&
                        shopping_cart_store.shoppingBasket?.cart.items.length >
                            0
                    "
                    class="space-y-4"
                >
                    <div class="flex items-center gap-2 mb-4">
                        <AppFormInput
                            placeholder="Coupon code"
                            name="coupon"
                            type="text"
                        />

                        <div class="w-fit">
                            <AppFormButton
                                name="btn_apply"
                                text="Apply"
                                theme="secondary"
                            />
                        </div>
                    </div>

                    <div class="space-y-2 pt-4 border-t border-slate-200">
                        <div
                            class="flex justify-between text-sm text-slate-600"
                        >
                            <span>Subtotal</span>
                            <span>${{ cartTotal.toFixed(2) }}</span>
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
                            <span>${{ cartTotal.toFixed(2) }}</span>
                        </div>
                    </div>

                    <AppFormButton
                        name="btn_checkout"
                        theme="primary"
                        text="Checkout"
                    />
                </div>
            </div>
        </aside>
    </div>
</template>
<script setup lang="ts">
import IconShoppingCart from "@/icons/shop/IconShoppingCart.vue";
import { computed, onMounted, ref } from "vue";

const showShoppingCart = ref<boolean>(false);

import { useShoppingCartStore } from "@/stores/AppShoppingCart";
const shopping_cart_store = useShoppingCartStore();

import IconPlus from "@/icons/form/IconPlus.vue";
import IconMinus from "@/icons/form/IconMinus.vue";
import AppFormIconButton from "@/components/form/AppFormIconButton.vue";
import AppFormButton from "@/components/form/AppFormButton.vue";
import AppFormInput from "@/components/form/AppFormInput.vue";

const shoppingCartRef = ref<HTMLElement | null>(null);
onMounted(async () => {
    await shopping_cart_store.getShoppingBasket();
    document.addEventListener("click", handleClickOutside);
});

const handleClickOutside = (event: MouseEvent) => {
    if (
        shoppingCartRef.value &&
        !shoppingCartRef.value.contains(event.target as Node)
    ) {
        showShoppingCart.value = false;
    }
};

const cartItemCount = computed<number>(
    () => shopping_cart_store.shoppingBasketItems?.length ?? 0,
);
const cartTotal = computed<number>(() => {
    if (
        !shopping_cart_store.shoppingBasketItems ||
        shopping_cart_store.shoppingBasketItems?.length === 0
    )
        return 0;

    return shopping_cart_store.shoppingBasketItems?.reduce(
        (total, cartItem) => {
            return total + (cartItem.item?.price ?? 0) * (cartItem.amount ?? 1);
        },
        0,
    );
});
</script>
