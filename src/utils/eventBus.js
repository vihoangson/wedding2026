import { reactive } from 'vue'

/**
 * Event Bus System for Vue.js 3
 * Centralized event management
 */

class EventBus {
  constructor() {
    // Store all listeners
    this.listeners = reactive({})
  }

  /**
   * Subscribe to an event
   * @param {string} eventName - Event name
   * @param {Function} callback - Callback function
   * @returns {Function} Unsubscribe function
   */
  on(eventName, callback) {
    if (!this.listeners[eventName]) {
      this.listeners[eventName] = []
    }

    this.listeners[eventName].push(callback)

    // Return unsubscribe function
    return () => {
      this.off(eventName, callback)
    }
  }

  /**
   * Subscribe to an event once
   * @param {string} eventName - Event name
   * @param {Function} callback - Callback function
   */
  once(eventName, callback) {
    const wrapper = (data) => {
      callback(data)
      this.off(eventName, wrapper)
    }

    this.on(eventName, wrapper)
  }

  /**
   * Emit an event
   * @param {string} eventName - Event name
   * @param {*} data - Data to pass
   */
  emit(eventName, data = null) {
    if (!this.listeners[eventName]) {
      console.warn(`Event "${eventName}" has no listeners`)
      return
    }

    this.listeners[eventName].forEach((callback) => {
      try {
        callback(data)
      } catch (error) {
        console.error(`Error in event listener for "${eventName}":`, error)
      }
    })
  }

  /**
   * Unsubscribe from an event
   * @param {string} eventName - Event name
   * @param {Function} callback - Callback function
   */
  off(eventName, callback) {
    if (!this.listeners[eventName]) {
      return
    }

    this.listeners[eventName] = this.listeners[eventName].filter(
      (cb) => cb !== callback
    )

    // Clean up empty event arrays
    if (this.listeners[eventName].length === 0) {
      delete this.listeners[eventName]
    }
  }

  /**
   * Remove all listeners for an event
   * @param {string} eventName - Event name (optional, removes all if not provided)
   */
  clear(eventName) {
    if (eventName) {
      delete this.listeners[eventName]
    } else {
      this.listeners = reactive({})
    }
  }

  /**
   * Get listener count for an event
   * @param {string} eventName - Event name
   * @returns {number} Number of listeners
   */
  listenerCount(eventName) {
    return this.listeners[eventName]?.length || 0
  }

  /**
   * Get all event names
   * @returns {Array} List of event names
   */
  eventNames() {
    return Object.keys(this.listeners)
  }
}

// Create singleton instance
const eventBus = new EventBus()

export default eventBus

