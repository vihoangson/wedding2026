import { createApp } from 'vue'
import App from './App.vue'
import router from './router/index.js'
import { createPinia } from 'pinia'
import { eventBusPlugin } from './utils/eventBusPlugin.js'
import { WeddingEvents } from './utils/eventTypes.js'

const pinia = createPinia()
const app = createApp(App)

// Register plugins
app.use(pinia)
app.use(router)
app.use(eventBusPlugin)

// Make event types available globally
app.config.globalProperties.$eventTypes = WeddingEvents

app.mount('#app')

