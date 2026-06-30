import eventBus from './eventBus'

/**
 * Event Bus Plugin for Vue.js 3
 * Makes eventBus available globally via app.config.globalProperties
 */

export const eventBusPlugin = {
  install(app) {
    // Make eventBus available globally in all components
    app.config.globalProperties.$eventBus = eventBus

    // Make event types available globally
    app.config.globalProperties.$eventTypes = null

    // Provide eventBus for composition API
    app.provide('eventBus', eventBus)
  },
}

export default eventBusPlugin

