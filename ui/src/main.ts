import { createApp } from 'vue/dist/vue.esm-bundler';
import router from './router';
import './styles/main.scss';

const app = createApp({})

app.use(router)

app.mount('#app')
