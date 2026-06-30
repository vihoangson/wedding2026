/**
 * Event Bus Usage Examples
 * Demonstrates different ways to use the Event Bus system
 */

import { useEventBus, useEventListener, useEventListeners } from '@/utils/useEventBus'
import { WeddingEvents } from '@/utils/eventTypes'

// ============================================================
// Example 1: Basic Usage - Simple Emit & Listen
// ============================================================

export function example1_BasicUsage() {
  const { emit, on, off } = useEventBus()

  // Emit an event
  emit(WeddingEvents.RSVP_SUBMIT, {
    name: 'John Doe',
    email: 'john@example.com',
    guests: 2
  })

  // Listen to event
  const handler = (data) => {
    console.log('RSVP received:', data)
  }

  on(WeddingEvents.RSVP_SUBMIT, handler)

  // Stop listening
  off(WeddingEvents.RSVP_SUBMIT, handler)
}

// ============================================================
// Example 2: Listen Once
// ============================================================

export function example2_ListenOnce() {
  const { once } = useEventBus()

  // This callback will only be called once
  once(WeddingEvents.GALLERY_OPEN, (data) => {
    console.log('Gallery opened first time:', data)
    // Auto unsubscribed after this
  })
}

// ============================================================
// Example 3: Vue Component - Using Composable (Recommended)
// ============================================================

export const example3_ComponentWithComposable = {
  setup() {
    const { emit, on } = useEventBus()

    const handleFormSubmit = (formData) => {
      // Emit success event
      emit(WeddingEvents.RSVP_SUCCESS, {
        message: 'RSVP submitted',
        rsvpData: formData
      })
    }

    const handleRsvpSuccess = (data) => {
      console.log('RSVP was successful:', data)
    }

    // Listen on mount
    on(WeddingEvents.RSVP_SUCCESS, handleRsvpSuccess)

    return {
      handleFormSubmit
    }
  }
}

// ============================================================
// Example 4: Auto Cleanup with useEventListener
// ============================================================

export const example4_AutoCleanup = {
  setup() {
    // This listener automatically unsubscribes on component unmount
    useEventListener(WeddingEvents.GALLERY_OPEN, (data) => {
      console.log('Gallery opened:', data.imageIndex)
    })

    return {}
  }
}

// ============================================================
// Example 5: Multiple Event Listeners
// ============================================================

export const example5_MultipleListeners = {
  setup() {
    // Listen to multiple events at once
    useEventListeners({
      [WeddingEvents.RSVP_SUCCESS]: (data) => {
        console.log('✓ RSVP Success:', data)
      },
      [WeddingEvents.RSVP_ERROR]: (data) => {
        console.error('✗ RSVP Error:', data)
      },
      [WeddingEvents.GALLERY_OPEN]: (data) => {
        console.log(' Gallery:', data)
      },
      [WeddingEvents.NOTIFICATION_SHOW]: (data) => {
        console.log(' Notification:', data.message)
      }
    })

    return {}
  }
}

// ============================================================
// Example 6: Creating a Notification Service
// ============================================================

export function createNotificationService() {
  const { emit, on } = useEventBus()

  return {
    // Methods to emit notifications
    success(message, duration = 3000) {
      emit(WeddingEvents.NOTIFICATION_SUCCESS, {
        message,
        duration,
        type: 'success'
      })
    },

    error(message, duration = 3000) {
      emit(WeddingEvents.NOTIFICATION_ERROR, {
        message,
        duration,
        type: 'error'
      })
    },

    warning(message, duration = 3000) {
      emit(WeddingEvents.NOTIFICATION_WARNING, {
        message,
        duration,
        type: 'warning'
      })
    },

    info(message, duration = 3000) {
      emit(WeddingEvents.NOTIFICATION_INFO, {
        message,
        duration,
        type: 'info'
      })
    },

    // Listen to all notifications
    onNotification(callback) {
      on(WeddingEvents.NOTIFICATION_SHOW, callback)
    }
  }
}

// Usage:
// const notifications = createNotificationService()
// notifications.success('Operation successful!')

// ============================================================
// Example 7: Creating an Event Logger
// ============================================================

export function createEventLogger() {
  const { on, eventNames, listenerCount } = useEventBus()

  // Log all events
  const logAllEvents = () => {
    console.log('=== Event Bus Activity ===')
    eventNames().forEach((eventName) => {
      console.log(`${eventName}: ${listenerCount(eventName)} listeners`)
    })
  }

  // Listen to specific event and log it
  const watchEvent = (eventName) => {
    on(eventName, (data) => {
      console.log(`Event: ${eventName}`, data)
    })
    console.log(`Watching: ${eventName}`)
  }

  return {
    logAllEvents,
    watchEvent
  }
}

// Usage:
// const logger = createEventLogger()
// logger.watchEvent(WeddingEvents.RSVP_SUBMIT)
// logger.logAllEvents()

// ============================================================
// Example 8: RSVP Form Integration
// ============================================================

export const example8_RSVPFormComponent = {
  data() {
    return {
      form: {
        name: '',
        email: '',
        phone: '',
        guests: 1,
        dietary: '',
        message: ''
      },
      isLoading: false,
      submitted: false
    }
  },

  methods: {
    async submitRSVP() {
      const { emit } = useEventBus()

      this.isLoading = true

      try {
        // Emit loading event
        emit(WeddingEvents.RSVP_LOADING, { loading: true })

        // Simulate API call
        await new Promise((resolve) => setTimeout(resolve, 1000))

        // Emit success
        emit(WeddingEvents.RSVP_SUCCESS, {
          message: 'RSVP submitted successfully',
          rsvpData: this.form
        })

        this.submitted = true
      } catch (error) {
        // Emit error
        emit(WeddingEvents.RSVP_ERROR, {
          error: error.message,
          rsvpData: this.form
        })
      } finally {
        this.isLoading = false
      }
    }
  }
}

// ============================================================
// Example 9: Global Notification Component
// ============================================================

export const example9_NotificationCenter = {
  setup() {
    const notifications = ref([])
    let notificationId = 0

    useEventListener(WeddingEvents.NOTIFICATION_SHOW, (data) => {
      const id = notificationId++

      notifications.value.push({
        id,
        message: data.message,
        type: data.type || 'info'
      })

      // Auto remove after duration
      setTimeout(() => {
        notifications.value = notifications.value.filter((n) => n.id !== id)
      }, data.duration || 3000)
    })

    return {
      notifications
    }
  },

  template: `
    <div class="notification-container">
      <transition-group name="slide">
        <div
          v-for="notification in notifications"
          :key="notification.id"
          :class="['notification', \`notification-\${notification.type}\`]"
        >
          {{ notification.message }}
        </div>
      </transition-group>
    </div>
  `
}

// ============================================================
// Example 10: Event Debouncing
// ============================================================

export function createDebouncedEventEmitter(eventName, delay = 300) {
  const { emit } = useEventBus()
  let timeoutId = null

  return {
    send(data) {
      clearTimeout(timeoutId)

      timeoutId = setTimeout(() => {
        emit(eventName, data)
      }, delay)
    },

    sendImmediate(data) {
      clearTimeout(timeoutId)
      emit(eventName, data)
    }
  }
}

// Usage:
// const search = createDebouncedEventEmitter(WeddingEvents.SEARCH_UPDATE, 500)
// search.send({ query: 'john' })  // Waits 500ms before emitting

// ============================================================
// Example 11: Event Chaining
// ============================================================

export const example11_EventChaining = {
  setup() {
    const { emit, on } = useEventBus()

    // Listen for RSVP success, then trigger notification
    on(WeddingEvents.RSVP_SUCCESS, (data) => {
      emit(WeddingEvents.NOTIFICATION_SHOW, {
        message: `✓ ${data.rsvpData.name} confirmed!`,
        type: 'success',
        duration: 5000
      })
    })

    // Listen for RSVP error, then trigger notification
    on(WeddingEvents.RSVP_ERROR, (data) => {
      emit(WeddingEvents.NOTIFICATION_SHOW, {
        message: '✗ Error processing RSVP',
        type: 'error',
        duration: 5000
      })
    })

    return {}
  }
}

// ============================================================
// Example 12: Debugging Event Bus
// ============================================================

export function debugEventBus() {
  const { eventNames, listenerCount, on, off } = useEventBus()

  const printEventStats = () => {
    console.group(' Event Bus Statistics')
    const events = eventNames()
    console.log(`Total Events: ${events.length}`)
    events.forEach((event) => {
      console.log(`  • ${event}: ${listenerCount(event)} listeners`)
    })
    console.groupEnd()
  }

  const monitorEvent = (eventName) => {
    console.log(`️ Monitoring: ${eventName}`)

    const handler = (data) => {
      console.group(` Event Fired: ${eventName}`)
      console.log('Data:', data)
      console.trace('Stack')
      console.groupEnd()
    }

    on(eventName, handler)

    return () => off(eventName, handler)
  }

  return {
    printEventStats,
    monitorEvent
  }
}

// Usage:
// const debug = debugEventBus()
// debug.printEventStats()
// const unmonitor = debug.monitorEvent(WeddingEvents.RSVP_SUBMIT)

// ============================================================
// Import helper
// ============================================================

import { ref } from 'vue'

export { ref } // Make ref available for examples
