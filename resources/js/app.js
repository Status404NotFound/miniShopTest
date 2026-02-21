import './bootstrap';

import Alpine from 'alpinejs';

import { createApp } from 'vue';
import { createPinia } from 'pinia';

window.Alpine = Alpine;

Alpine.start();

const app = createApp({});
const pinia = createPinia();

// Использовал pinia чтобы обеспечить связь между компонентами.
app.use(pinia);

app.mount('#app');
