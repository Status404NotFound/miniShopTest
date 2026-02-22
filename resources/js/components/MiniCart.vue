<template>
    <div class="relative z-50" @mouseenter="openCart" @mouseleave="closeCart">

        <a href="/checkout" class="flex items-center space-x-2 text-gray-700 hover:text-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span class="font-bold">{{ cartStore.totalItems }} шт.</span>
            <span v-if="cartStore.totalItems > 0">({{ Number(cartStore.totalPrice).toFixed(2) }} руб.)</span>
        </a>

        <transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 translate-y-1"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 translate-y-1"
        >
            <div v-show="isOpen && cartStore.cartItemsArray.length > 0"
                 class="absolute right-0 mt-2 w-72 bg-white border rounded shadow-lg">
                <div class="p-4 space-y-3">
                    <div v-for="item in cartStore.cartItemsArray" :key="item.id" class="flex justify-between items-center border-b pb-2">
                        <div>
                            <p class="text-sm font-semibold">{{ item.name }}</p>
                            <p class="text-xs text-gray-500">{{ item.quantity }} x {{ Number(item.price).toFixed(2) }} руб.</p>
                        </div>
                        <button @click="cartStore.removeFromCart(item.id)" class="text-red-500 text-sm hover:underline" title="Удалить">
                            ✕
                        </button>
                    </div>
                    <div class="pt-2 text-center">
                        <a href="/checkout" class="text-blue-600 text-sm font-bold hover:underline">Оформить заказ</a>
                    </div>
                </div>
            </div>
        </transition>

    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useCartStore } from '../store/cart';

const cartStore = useCartStore();

onMounted(() => {
    cartStore.fetchCart();
});

// задержка корзины
const isOpen = ref(false);
let closeTimeout = null;

// показываем корзину и отменяем таймер закрытия
const openCart = () => {
    if (closeTimeout) {
        clearTimeout(closeTimeout);
        closeTimeout = null;
    }
    isOpen.value = true;
};

// закрытия через 3 сек
const closeCart = () => {
    closeTimeout = setTimeout(() => {
        isOpen.value = false;
    }, 3000);
};
</script>
