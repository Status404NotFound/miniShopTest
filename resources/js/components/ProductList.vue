<template>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div v-for="product in products" :key="product.id" class="border p-4 rounded shadow bg-white">
            <h3 class="font-bold text-lg leading-tight">
                <a :href="`/products/${product.id}`" class="hover:text-blue-600">{{ product.name }}</a>
            </h3>
            <p class="text-gray-600 text-sm mb-4 truncate">{{ product.description }}</p>
            <div class="flex justify-between items-center mt-auto">
                <span class="font-bold text-xl">{{ Number(product.full_price).toFixed(2) }}$</span>
            </div>
        </div>

        <div v-if="products.length === 0" class="col-span-3 text-center text-gray-500 py-8">
            Товары не найдены.
        </div>
    </div>
</template>

<script setup>

defineProps({
    products: {
        type: Array,
        required: true
    }
});
</script>
