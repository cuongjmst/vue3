import './assets/main.css'
import 'vue-toast-notification/dist/theme-bootstrap.css'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router/router.js'
import { store } from './store/store.js'
import ToastPlugin from 'vue-toast-notification'
import Markdown from 'vue3-markdown-it'

store.dispatch('initializeCartFromLocalStorage')

const app = createApp(App)
app.use(router)
app.use(store)
app.use(ToastPlugin)
app.use(Markdown)
app.mount('#app')