<template>
    <div class="bg-gray-50 p-4 rounded-md border mb-6">
        <h3 class="text-lg font-bold mb-4 border-b pb-2">Состав заказа</h3>

        <div v-if="cartStore.cartItemsArray.length === 0" class="text-gray-500 py-4">
            Ваша корзина пуста.
        </div>

        <div v-else class="space-y-4">
            <div v-for="item in cartStore.cartItemsArray" :key="item.id" class="flex justify-between items-center border-b pb-2">
                <div>
                    <p class="font-semibold text-gray-800">{{ item.name }}</p>
                    <p class="text-sm text-gray-500">{{ item.quantity }} шт. × {{ Number(item.price).toFixed(2) }} $</p>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="font-bold">{{ (item.quantity * item.price).toFixed(2) }} $</span>
                    <button type="button"
                        @click.prevent="cartStore.removeFromCart(item.id)"
                        class="text-red-500 text-sm hover:text-red-700 hover:underline"
                        title="Удалить из корзины"
                    >
                        Удалить
                    </button>
                </div>
            </div>

            <div class="pt-4 flex justify-between items-center">
                <span class="text-lg text-gray-700">Итого к оплате:</span>
                <span class="text-2xl font-bold text-gray-900">{{ Number(cartStore.totalPrice).toFixed(2) }} $</span>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useCartStore } from '../store/cart';

const cartStore = useCartStore();
</script>
