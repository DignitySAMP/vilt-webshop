import { defineStore } from "pinia";

import { ref } from "vue";

import { Item } from "@/types";
import axios from "axios";

export const useShoppingCartStore = defineStore("shopping_cart", () => {
    interface ShoppingCartResponse {
        cart: ShoppingCart;
    }

    interface ShoppingCart {
        id: number;
        user_id: number;
        created_at: string;
        updated_at: string;
        items: ShoppingCartItem[];
    }

    interface ShoppingCartItem {
        id: number;
        user_cart_id: number;
        item_id: number;
        amount: number;
        created_at: string;
        updated_at: string;
        item: Item;
    }

    interface AxiosResponse {
        status: number;
        message: string;
        data: any[] | null;
    }

    const shoppingBasket = ref<ShoppingCartResponse | null>(null);
    const shoppingBasketItems = ref<ShoppingCartItem[] | null>(null);

    const getShoppingBasket = async (): Promise<AxiosResponse> => {
        try {
            const response = await axios.get(route("cart.index"));

            // init shopping basket if data is found
            if (response.data) {
                shoppingBasket.value = response.data;
                shoppingBasketItems.value =
                    shoppingBasket.value?.cart.items ?? null;
            } else {
                shoppingBasket.value = null;
                shoppingBasketItems.value = null;
            }

            return {
                status: response.status,
                message: "OK",
                data: response.data, // { shopping_cart: {...} }
            };
        } catch (error: any) {
            // cart not found, reset vars to make 'cart is empty' show
            if (error.response?.status === 404) {
                shoppingBasket.value = null;
                shoppingBasketItems.value = null;
            }

            return {
                status: error.response?.status ?? 500,
                message: error.response?.data?.message ?? error.message,
                data: null,
            };
        }
    };

    const storeItemToBasket = async (item: Item): Promise<AxiosResponse> => {
        try {
            const response = await axios.post(
                route("cart.store", {
                    item: item.id,
                }),
            );

            await getShoppingBasket(); // refresh basket
            return {
                status: response.status,
                message: "OK",
                data: response.data,
            };
        } catch (error: any) {
            return {
                status: error.response?.status ?? 500,
                message: error.response?.data?.message ?? error.message,
                data: null,
            };
        }
    };

    const updateItemInBasket = async (
        cart: number,
        item: Item,
        amount: number,
    ): Promise<AxiosResponse> => {
        try {
            const response = await axios.patch(
                route("cart.update", {
                    cart: cart,
                    item_id: item.id,
                    amount: amount,
                }),
            );

            await getShoppingBasket(); // refresh basket

            return {
                status: response.status,
                message: "OK",
                data: response.data,
            };
        } catch (error: any) {
            return {
                status: error.response?.status ?? 500,
                message: error.response?.data?.message ?? error.message,
                data: null,
            };
        }
    };

    return {
        shoppingBasket,
        shoppingBasketItems,

        getShoppingBasket,
        storeItemToBasket,
        updateItemInBasket, // also handles deletes (see controller)
    };
});
