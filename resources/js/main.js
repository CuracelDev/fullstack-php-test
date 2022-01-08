import { createApp } from 'vue'
import router from './Router/index'
import axios from 'axios'

axios.defaults.baseURL = 'http://localhost:8000/api/';
axios.defaults.headers['Authorization'] = `Bearer ${localStorage.getItem('token')}`

createApp(App).use(store).use(router).mount('#app')