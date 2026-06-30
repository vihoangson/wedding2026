import { onMounted, onUnmounted } from 'vue'
import eventBus from './eventBus'

/**
 * Composable for using Event Bus in Vue components
 * Provides easy access to emit and listen for events
 */

export function useEventBus() {
  /**
   * Emit an event
   * @param {string} eventName - Event name
   * @param {*} data - Event data
   */
  const emit = (eventName, data = null) => {
    eventBus.emit(eventName, data)
  }

  /**
   * Listen to an event
   * @param {string} eventName - Event name
   * @param {Function} callback - Callback function
   * @returns {Function} Unsubscribe function
   */
  const on = (eventName, callback) => {
    return eventBus.on(eventName, callback)
  }

  /**
   * Listen to an event once
   * @param {string} eventName - Event name
   * @param {Function} callback - Callback function
   */
  const once = (eventName, callback) => {
    eventBus.once(eventName, callback)
  }

  /**
   * Stop listening to an event
   * @param {string} eventName - Event name
   * @param {Function} callback - Callback function
   */
  const off = (eventName, callback) => {
    eventBus.off(eventName, callback)
  }

  /**
   * Clear all listeners
   * @param {string} eventName - Event name (optional)
   */
  const clear = (eventName) => {
    eventBus.clear(eventName)
  }

  /**
   * Get listener count
   * @param {string} eventName - Event name
   * @returns {number} Number of listeners
   */
  const listenerCount = (eventName) => {
    return eventBus.listenerCount(eventName)
  }

  /**
   * Get all event names
   * @returns {Array} List of event names
   */
  const eventNames = () => {
    return eventBus.eventNames()
  }

  return {
    emit,
    on,
    once,
    off,
    clear,
    listenerCount,
    eventNames,
  }
}

/**
 * Composable for easy event listening with cleanup
 * Automatically removes listeners on unmount
 */
export function useEventListener(eventName, callback) {
  const { on, off } = useEventBus()
  let unsubscribe

  onMounted(() => {
    unsubscribe = on(eventName, callback)
  })

  onUnmounted(() => {
    if (unsubscribe) {
      unsubscribe()
    }
  })
}

/**
 * Composable for multiple event listeners
 */
export function useEventListeners(events) {
  const { on, off } = useEventBus()
  const unsubscribers = []

  onMounted(() => {
    Object.entries(events).forEach(([eventName, callback]) => {
      const unsubscribe = on(eventName, callback)
      unsubscribers.push(unsubscribe)
    })
  })

  onUnmounted(() => {
    unsubscribers.forEach((unsubscribe) => {
      if (unsubscribe) {
        unsubscribe()
      }
    })
  })
}

export default useEventBus

