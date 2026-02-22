import './bootstrap';

import Alpine from 'alpinejs';

import { createApp } from 'vue';
import { createPinia } from 'pinia';

import AddToCartButton from './components/AddToCartButton.vue';
import MiniCart from './components/MiniCart.vue';
import ProductList from './components/ProductList.vue';
import ProductFilters from './components/ProductFilters.vue';

window.Alpine = Alpine;

Alpine.start();

const app = createApp({});
const pinia = createPinia();

// Использовал pinia чтобы обеспечить связь между компонентами.
app.use(pinia);

app.component('add-to-cart-button', AddToCartButton);
app.component('mini-cart', MiniCart);
app.component('product-list', ProductList);
app.component('product-filters', ProductFilters);

app.mount('#app');
