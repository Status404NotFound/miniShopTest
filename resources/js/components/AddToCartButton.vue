<template>
    <button
        @click="addToCart"
        :disabled="isLoading || isLimitReached"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 disabled:opacity-50 transition"
    >
        <span v-if="isLoading">Добавление...</span>
        <span v-else-if="props.stock <= 0">Нет в наличии</span>
        <span v-else-if="isLimitReached">Добавлен максимум</span>
        <span v-else>В корзину</span>
    </button>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useCartStore } from '../store/cart';

const props = defineProps({
    productId: {
        type: Number,
        required: true
    },
    stock: {
        type: Number,
        default: 0
    }
});

const cartStore = useCartStore();
const isLoading = ref(false);

// Ищем, сколько штук этого товара уже лежит в корзине
const quantityInCart = computed(() => {
    const item = cartStore.cartItemsArray.find(i => i.id === props.productId);
    return item ? item.quantity : 0;
});

// Блокируем кнопку, если товара нет на складе ИЛИ в корзине уже максимум
const isLimitReached = computed(() => {
    return props.stock <= 0 || quantityInCart.value >= props.stock;
});

const addToCart = async () => {
    if (isLimitReached.value) return; // Двойная защита от клика

    isLoading.value = true;
    await cartStore.addToCart(props.productId, 1);
    isLoading.value = false;
};
</script>
