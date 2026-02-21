import './bootstrap';

import Alpine from 'alpinejs';

import { createApp } from 'vue';
import { createPinia } from 'pinia';

import ProductList from './components/ProductList.vue';
import ProductFilters from './components/ProductFilters.vue';

window.Alpine = Alpine;

Alpine.start();

const app = createApp({});
const pinia = createPinia();

// Использовал pinia чтобы обеспечить связь между компонентами.
app.use(pinia);


app.component('product-list', ProductList);
app.component('product-filters', ProductFilters);

app.mount('#app');
