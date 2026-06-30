#  Event Bus System - Quick Summary

Hệ thống Event Bus tập trung để quản lý tất cả events trong Vue.js 3 Wedding App.

##  File Structure

```
src/utils/
├── eventBus.js              # Core - Event Bus class
├── eventTypes.js            # Event names constants
├── useEventBus.js           # Composables (Recommended)
├── eventBusPlugin.js        # Vue Plugin
├── index.js                 # Export all
└── examples.js              # 12 usage examples

src/components/demo/
└── EventBusDemo.vue         # Interactive demo

EVENT_BUS_GUIDE.md           # Full documentation
```

##  Quick Start (3 Steps)

### Step 1: Import in Component

```javascript
import { useEventBus } from '@/utils/useEventBus'
import { WeddingEvents } from '@/utils/eventTypes'

const { emit, on, off } = useEventBus()
```

### Step 2: Emit Event

```javascript
emit(WeddingEvents.RSVP_SUCCESS, {
  name: 'John',
  email: 'john@example.com'
})
```

### Step 3: Listen to Event

```javascript
import { useEventListener } from '@/utils/useEventBus'

useEventListener(WeddingEvents.RSVP_SUCCESS, (data) => {
  console.log('RSVP Success:', data)
})
// Auto cleanup on unmount!
```

##  Predefined Events

```javascript
// RSVP Events
WeddingEvents.RSVP_SUBMIT
WeddingEvents.RSVP_SUCCESS
WeddingEvents.RSVP_ERROR
WeddingEvents.RSVP_LOADING

// Gallery Events
WeddingEvents.GALLERY_OPEN
WeddingEvents.GALLERY_CLOSE
WeddingEvents.GALLERY_NEXT
WeddingEvents.GALLERY_PREV

// Notification Events
WeddingEvents.NOTIFICATION_SHOW
WeddingEvents.NOTIFICATION_SUCCESS
WeddingEvents.NOTIFICATION_ERROR
WeddingEvents.NOTIFICATION_WARNING
WeddingEvents.NOTIFICATION_INFO

// Navigation Events
WeddingEvents.SCROLL_TO_SECTION
WeddingEvents.NAVIGATE_TO_PAGE

// + 10 more event types...
```

##  3 Usage Patterns

### Pattern 1: Basic (Manual Cleanup)

```javascript
const { emit, on, off } = useEventBus()

on(WeddingEvents.RSVP_SUCCESS, handler)
off(WeddingEvents.RSVP_SUCCESS, handler)
```

### Pattern 2: Auto Cleanup (Recommended) ⭐

```javascript
useEventListener(WeddingEvents.RSVP_SUCCESS, (data) => {
  // Auto unsubscribe on component unmount
})
```

### Pattern 3: Multiple Listeners

```javascript
useEventListeners({
  [WeddingEvents.RSVP_SUCCESS]: handleRsvpSuccess,
  [WeddingEvents.GALLERY_OPEN]: handleGalleryOpen,
  [WeddingEvents.NOTIFICATION_SHOW]: handleNotification
})
```

##  Real-World Example

```vue
<template>
  <div>
    <form @submit.prevent="submitRSVP">
      <input v-model="form.name" placeholder="Name">
      <button type="submit">Submit</button>
    </form>
    
    <div v-if="success" class="alert-success">
      ✓ RSVP Received!
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useEventBus, useEventListener } from '@/utils/useEventBus'
import { WeddingEvents } from '@/utils/eventTypes'

const form = ref({ name: '', email: '', phone: '' })
const success = ref(false)

const { emit } = useEventBus()

const submitRSVP = async () => {
  // Emit success event
  emit(WeddingEvents.RSVP_SUCCESS, {
    message: 'RSVP received!',
    rsvpData: form.value
  })
  
  success.value = true
}

// Listen for RSVP success (auto cleanup)
useEventListener(WeddingEvents.RSVP_SUCCESS, (data) => {
  console.log('✓', data.message)
  
  // Can emit another event if needed
  emit(WeddingEvents.NOTIFICATION_SHOW, {
    message: `✓ ${data.rsvpData.name} confirmed!`,
    type: 'success'
  })
})
</script>
```

## ✅ Advantages

✅ **Centralized** - All events in one place
✅ **Type-safe** - Constants prevent typos
✅ **Auto cleanup** - Composables handle unmount
✅ **Reactive** - Vue 3 reactive listeners
✅ **Easy** - Simple API
✅ **Documented** - All events documented
✅ **Scalable** - Add more events as needed
✅ **Debuggable** - Helper functions for debugging

##  Anti-Patterns

❌ Don't:
```javascript
// DON'T use hard-coded strings
emit('rsvp_success', data)  // Typo risk!
eventBus.on('rsvp-success', handler)  // Wrong name!

// DON'T forget to cleanup (if using basic usage)
on('event', handler)  // Memory leak if not unsubscribed
```

✅ Do:
```javascript
// DO use constants
import { WeddingEvents } from '@/utils/eventTypes'
emit(WeddingEvents.RSVP_SUCCESS, data)

// DO use auto cleanup
useEventListener(WeddingEvents.RSVP_SUCCESS, handler)
```

##  Debugging

### View all active events

```javascript
const { eventNames } = useEventBus()
console.log(eventNames())
```

### Count listeners

```javascript
const { listenerCount } = useEventBus()
console.log(listenerCount(WeddingEvents.RSVP_SUCCESS))
```

### Clear events

```javascript
const { clear } = useEventBus()
clear()  // Clear all
clear(WeddingEvents.RSVP_SUCCESS)  // Clear specific
```

##  Files to Read

1. **EVENT_BUS_GUIDE.md** - Full documentation
2. **src/utils/eventTypes.js** - All event names
3. **src/utils/examples.js** - 12 usage examples
4. **src/components/demo/EventBusDemo.vue** - Interactive demo

##  Common Tasks

### Show Notification

```javascript
const { emit } = useEventBus()

emit(WeddingEvents.NOTIFICATION_SHOW, {
  message: 'Hello!',
  type: 'success',
  duration: 3000
})
```

### Handle RSVP Submission

```javascript
useEventListeners({
  [WeddingEvents.RSVP_SUCCESS]: (data) => {
    console.log('Confirmed:', data.rsvpData.name)
  },
  [WeddingEvents.RSVP_ERROR]: (data) => {
    console.error('Error:', data.error)
  }
})
```

### Create Service with Event Bus

```javascript
export function useNotificationService() {
  const { emit } = useEventBus()
  
  return {
    success: (msg) => emit(WeddingEvents.NOTIFICATION_SUCCESS, { message: msg }),
    error: (msg) => emit(WeddingEvents.NOTIFICATION_ERROR, { message: msg })
  }
}
```

##  Key Features

| Feature | Location |
|---------|----------|
| Core Event Bus | `src/utils/eventBus.js` |
| Event Types | `src/utils/eventTypes.js` |
| Composables | `src/utils/useEventBus.js` |
| Vue Plugin | `src/utils/eventBusPlugin.js` |
| Examples | `src/utils/examples.js` |
| Demo | `src/components/demo/EventBusDemo.vue` |
| Guide | `EVENT_BUS_GUIDE.md` |

##  Related

- **Pinia Store** - `src/stores/weddingStore.js` (for app state)
- **Vue Router** - `src/router/index.js` (for navigation)
- **RSVP Component** - `src/components/sections/RSVPSection.vue` (uses event bus)

## ❓ FAQ

### Q: When to use Event Bus vs Pinia Store?

**Event Bus:**
- Component communication (RSVP → Notification)
- Decoupled components
- Temporary states

**Pinia Store:**
- Global app state
- Persistent data
- Multiple components share state

### Q: How to avoid memory leaks?

Use composables that auto cleanup:

```javascript
useEventListener()      // ✅ Auto cleanup
useEventListeners()     // ✅ Auto cleanup
useEventBus().on()      // ❌ Manual cleanup needed
```

### Q: Can I have multiple listeners for one event?

Yes! Each listener independently:

```javascript
useEventListener(event, handler1)
useEventListener(event, handler2)

// Both will be called when event fires
```

### Q: How to debug event flow?

```javascript
import { debugEventBus } from '@/utils/examples'

const debug = debugEventBus()
debug.printEventStats()
debug.monitorEvent(WeddingEvents.RSVP_SUBMIT)
```

##  Next Steps

1. Read **EVENT_BUS_GUIDE.md** for detailed documentation
2. Check **src/utils/examples.js** for usage patterns
3. Try **EventBusDemo.vue** component
4. Integrate into your components
5. Add more events as needed

##  You're Ready!

Event Bus system is ready to use. Start using `useEventListener` in your components!

```javascript
import { useEventListener } from '@/utils/useEventBus'
import { WeddingEvents } from '@/utils/eventTypes'

useEventListener(WeddingEvents.RSVP_SUCCESS, (data) => {
  // Your code here
})
```

---

**Questions? Check EVENT_BUS_GUIDE.md! **
