import { defineStore } from 'pinia';
import axios from 'axios';

export const useCartStore = defineStore('cart', {
    state: () => ({
        items: {},
        isLoading: false,
    }),
    getters: {
        totalItems: (state) => {
            return Object.values(state.items).reduce((sum, item) => sum + item.quantity, 0);
        },

        totalPrice: (state) => {
            return Object.values(state.items).reduce((sum, item) => sum + (item.price * item.quantity), 0);
        },

        cartItemsArray: (state) => {
            return Object.values(state.items);
        }
    },
    actions: {
        // получаем актуальное состояние корзины с бека(сесия).
        async fetchCart() {
            this.isLoading = true;
            try {
                const response = await axios.get('/cart');
                this.items = response.data.data;
            } catch (error) {
                console.error('Ошибка при загрузке корзины:', error);
            } finally {
                this.isLoading = false;
            }
        },
        // запрос на добавление товара.
        // При успешном ответе бек возвращает новый масив товаров
        async addToCart(productId, quantity = 1) {
            this.isLoading = true;
            try {
                const response = await axios.post('/cart/add', { product_id: productId, quantity: quantity });
                this.items = response.data.data;
            } catch (error) {
                console.error('Ошибка при добавлении товара:', error);
            } finally {
                this.isLoading = false;
            }
        },
        // Удаление товара из корзины
        async removeFromCart(productId) {
            this.isLoading = true;
            try {
                const response = await axios.post('/cart/remove', { product_id: productId });
                this.items = response.data.data;
            } catch (error) {
                console.error('Ошибка при удалении товара:', error);
            } finally {
                this.isLoading = false;
            }
        }
    }
});
