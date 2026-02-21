<template>
    <div class="bg-white p-4 border rounded shadow">
        <h3 class="font-bold mb-4 text-gray-800">Категории</h3>
        <ul class="mb-6 space-y-2">
            <li v-for="cat in categories" :key="cat.id">
                <a :href="`/category/${cat.id}`"
                   :class="cat.id == categoryId ? 'font-bold text-blue-600' : 'text-gray-600 hover:text-blue-500'">
                    {{ cat.name }}
                </a>
            </li>
        </ul>

        <h3 class="font-bold mb-4 pt-4 border-t text-gray-800">Цена</h3>
        <form method="GET" :action="actionUrl">
            <div class="mb-4">
                <label class="block text-sm mb-1 text-gray-600">От ($)</label>
                <input type="number" step="0.01" min="0" name="min_price" :value="minPrice" class="w-full border rounded px-2 py-1">
            </div>

            <div class="mb-4">
                <label class="block text-sm mb-1 text-gray-600">До ($)</label>
                <input type="number" step="0.01" min="0" name="max_price" :value="maxPrice" class="w-full border rounded px-2 py-1">
            </div>

            <button type="submit" class="w-full bg-gray-800 text-white py-2 rounded hover:bg-gray-900 transition">
                Применить
            </button>
            <a :href="actionUrl" class="block text-center mt-3 text-sm text-blue-600 hover:underline">
                Сбросить фильтр
            </a>
        </form>
    </div>
</template>

<script setup>
defineProps({
    categories: {
        type: Array,
        required: true
    },
    actionUrl: {
        type: String,
        required: true
    },
    categoryId: {
        type: [String, Number],
        required: true
    },
    minPrice: {
        type: String,
        default: ''
    },
    maxPrice: {
        type: String,
        default: ''
    }
});
</script>
