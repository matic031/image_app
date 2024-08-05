// @ts-nocheck

import { createApp } from 'vue';
import App from './App.vue';
import PrimeVue from 'primevue/config';
import 'primeicons/primeicons.css';
import Aura from '@primevue/themes/aura';
import FileUpload from 'primevue/fileupload';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import Card from 'primevue/card';
import './assets/styles/tailwind.css';
import router from './router';

const app = createApp(App);
app.use(PrimeVue, {
    theme: {
        preset: Aura,
        options: {
            darkModeSelector: 'system',
        }
    }
});

app.component('FileUpload', FileUpload);
app.component('InputText', InputText);
app.component('Button', Button);

app.use(router);

app.mount('#app');
