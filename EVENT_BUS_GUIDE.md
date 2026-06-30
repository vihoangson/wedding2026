# 🎯 Event Bus System - Vue.js 3

Hệ thống Event Bus tập trung để quản lý tất cả events trong ứng dụng Wedding Page.

## 📁 File Structure

```
src/utils/
├── eventBus.js              # Event Bus class (core)
├── eventTypes.js            # Event names & constants
├── useEventBus.js           # Composables for easy usage
└── eventBusPlugin.js        # Vue plugin for global access

src/components/demo/
└── EventBusDemo.vue         # Demo component showing usage
```

## 🔧 Core Files Explained

### 1. **eventBus.js** - Event Bus Class

File core của toàn bộ hệ thống. Cung cấp các method:

```javascript
import eventBus from '@/utils/eventBus'

// Emit event
eventBus.emit('event-name', data)

// Listen to event
eventBus.on('event-name', callback)

// Listen once
eventBus.once('event-name', callback)

// Remove listener
eventBus.off('event-name', callback)

// Clear all listeners
eventBus.clear()

// Get listener count
eventBus.listenerCount('event-name')

// Get all event names
eventBus.eventNames()
```

### 2. **eventTypes.js** - Event Definitions

Tất cả event names được định nghĩa ở đây. Giúp tránh typo và quản lý tập trung.

```javascript
export const WeddingEvents = {
  // Navigation
  SCROLL_TO_SECTION: 'navigation:scroll-to-section',
  NAVIGATE_TO_PAGE: 'navigation:navigate-to-page',

  // RSVP
  RSVP_SUBMIT: 'rsvp:submit',
  RSVP_SUCCESS: 'rsvp:success',
  RSVP_ERROR: 'rsvp:error',
  RSVP_LOADING: 'rsvp:loading',

  // Gallery
  GALLERY_OPEN: 'gallery:open',
  GALLERY_CLOSE: 'gallery:close',
  GALLERY_NEXT: 'gallery:next',

  // Notification
  NOTIFICATION_SHOW: 'notification:show',
  NOTIFICATION_SUCCESS: 'notification:success',
  NOTIFICATION_ERROR: 'notification:error',

  // ... more events
}
```

### 3. **useEventBus.js** - Composables

Cung cấp các composables để sử dụng event bus dễ dàng trong components:

- `useEventBus()` - Cơ bản
- `useEventListener(eventName, callback)` - Tự động cleanup
- `useEventListeners(events)` - Nhiều listeners cùng lúc

### 4. **eventBusPlugin.js** - Vue Plugin

Đăng ký event bus toàn cục để truy cập từ bất kỳ component nào.

## 🚀 Usage Examples

### Method 1: Using Composable (Recommended)

```vue
<script setup>
import { useEventBus } from '@/utils/useEventBus'
import { WeddingEvents } from '@/utils/eventTypes'

const { emit, on, off } = useEventBus()

// Emit event
const handleClick = () => {
  emit(WeddingEvents.RSVP_SUBMIT, {
    name: 'John',
    email: 'john@example.com'
  })
}

// Listen to event
const handleRsvpSuccess = (data) => {
  console.log('RSVP success:', data)
}

onMounted(() => {
  on(WeddingEvents.RSVP_SUCCESS, handleRsvpSuccess)
})

onUnmounted(() => {
  off(WeddingEvents.RSVP_SUCCESS, handleRsvpSuccess)
})
</script>
```

### Method 2: Using useEventListener (Auto Cleanup)

```vue
<script setup>
import { useEventListener } from '@/utils/useEventBus'
import { WeddingEvents } from '@/utils/eventTypes'

// Auto cleans up on unmount
useEventListener(WeddingEvents.RSVP_SUCCESS, (data) => {
  console.log('RSVP Success:', data)
})
</script>
```

### Method 3: Using useEventListeners (Multiple Events)

```vue
<script setup>
import { useEventListeners } from '@/utils/useEventBus'
import { WeddingEvents } from '@/utils/eventTypes'

// All listeners auto cleanup on unmount
useEventListeners({
  [WeddingEvents.RSVP_SUCCESS]: (data) => {
    console.log('RSVP Success:', data)
  },
  [WeddingEvents.GALLERY_OPEN]: (data) => {
    console.log('Gallery opened:', data)
  },
  [WeddingEvents.NOTIFICATION_SHOW]: (data) => {
    console.log('Notification:', data)
  }
})
</script>
```

### Method 4: Global Access (via Plugin)

```vue
<script setup>
// Available in Options API as this.$eventBus
// or via app.config.globalProperties.$eventBus

// In Vue 3 Composition API, use useEventBus instead
</script>
```

## 📝 Event Types Reference

### RSVP Events

```javascript
// Emit when RSVP form submitted
emit(WeddingEvents.RSVP_SUBMIT, {
  name: String,
  email: String,
  phone: String,
  guests: Number,
  dietary: String,
  message: String,
  timestamp: Date
})

// Listen to success
on(WeddingEvents.RSVP_SUCCESS, (data) => {
  // data.message
  // data.rsvpData (full RSVP data)
})

// Listen to error
on(WeddingEvents.RSVP_ERROR, (data) => {
  // data.error
  // data.rsvpData
})

// Listen to loading
on(WeddingEvents.RSVP_LOADING, (data) => {
  // data.loading (true/false)
})
```

### Notification Events

```javascript
// Show notification
emit(WeddingEvents.NOTIFICATION_SHOW, {
  message: String,
  type: 'success' | 'error' | 'warning' | 'info',
  duration: Number (ms),
  position: 'top' | 'bottom' | 'center'
})

// Or specific types
emit(WeddingEvents.NOTIFICATION_SUCCESS, {
  message: 'Success!'
})

emit(WeddingEvents.NOTIFICATION_ERROR, {
  message: 'Error!'
})
```

### Gallery Events

```javascript
// Open gallery
emit(WeddingEvents.GALLERY_OPEN, {
  imageIndex: Number,
  imageSrc: String,
  imageAlt: String
})

// Close gallery
emit(WeddingEvents.GALLERY_CLOSE)

// Next image
emit(WeddingEvents.GALLERY_NEXT)

// Previous image
emit(WeddingEvents.GALLERY_PREV)
```

### Navigation Events

```javascript
// Scroll to section
emit(WeddingEvents.SCROLL_TO_SECTION, {
  sectionId: '#hero',
  smooth: true
})

// Navigate to page
emit(WeddingEvents.NAVIGATE_TO_PAGE, {
  page: 'gallery'
})
```

## 💡 Best Practices

### 1. Use Constants from eventTypes.js

❌ Bad:
```javascript
emit('rsvp_success', data)  // Typo possible
```

✅ Good:
```javascript
import { WeddingEvents } from '@/utils/eventTypes'
emit(WeddingEvents.RSVP_SUCCESS, data)  // No typo
```

### 2. Use Composables for Cleanup

❌ Bad:
```javascript
onMounted(() => {
  eventBus.on('event', handler)
})
// Listener not cleaned up!
```

✅ Good:
```javascript
useEventListener('event', handler)
// Auto cleaned up on unmount
```

### 3. Namespace Events

✅ Good:
```javascript
RSVP_SUBMIT: 'rsvp:submit',
GALLERY_OPEN: 'gallery:open',
NOTIFICATION_SHOW: 'notification:show'
```

Helps organize events and avoid conflicts.

### 4. Document Event Data

```javascript
// Good - document what data event carries
export const EventPayloads = {
  [WeddingEvents.RSVP_SUBMIT]: {
    name: String,
    email: String,
    // ...
  }
}
```

## 🔍 Debugging

### View Active Events

```javascript
const { eventNames } = useEventBus()

console.log('Active events:', eventNames())
// Output: ['rsvp:success', 'gallery:open', ...]
```

### Check Listener Count

```javascript
const { listenerCount } = useEventBus()

console.log('RSVP Success listeners:', listenerCount('rsvp:success'))
// Output: 2
```

### Clear Specific Event

```javascript
const { clear } = useEventBus()

clear('rsvp:submit')  // Clear specific event
clear()               // Clear all events
```

## 📊 Real-World Example: RSVP Flow

### Component 1: RSVPSection (Emitter)

```vue
<script setup>
import { useEventBus } from '@/utils/useEventBus'
import { WeddingEvents } from '@/utils/eventTypes'

const { emit } = useEventBus()

const submitRSVP = async (formData) => {
  emit(WeddingEvents.RSVP_LOADING, { loading: true })
  
  try {
    // ... submit logic ...
    
    emit(WeddingEvents.RSVP_SUCCESS, {
      message: 'RSVP received!',
      rsvpData: formData
    })
  } catch (error) {
    emit(WeddingEvents.RSVP_ERROR, {
      error: error.message,
      rsvpData: formData
    })
  }
}
</script>
```

### Component 2: NotificationCenter (Listener)

```vue
<script setup>
import { useEventListener, useEventListeners } from '@/utils/useEventBus'
import { WeddingEvents } from '@/utils/eventTypes'

// Option 1: Single listener
useEventListener(WeddingEvents.RSVP_SUCCESS, (data) => {
  showNotification('✓ ' + data.message, 'success')
})

// Option 2: Multiple listeners
useEventListeners({
  [WeddingEvents.RSVP_ERROR]: (data) => {
    showNotification('✗ RSVP Failed!', 'error')
  },
  [WeddingEvents.RSVP_LOADING]: (data) => {
    showLoading(data.loading)
  }
})
</script>
```

## 🎌 Migration Guide

### From Direct Props to Event Bus

Before:
```vue
<!-- Event drilling through multiple components -->
<Child 
  @rsvp-submit="handleRsvpSubmit"
  @notification="handleNotification"
/>
```

After:
```vue
<!-- Use event bus - no prop drilling -->
const { emit } = useEventBus()
emit(WeddingEvents.RSVP_SUBMIT, data)
```

## ✅ Checklist

- [x] Event Bus system created
- [x] Event types defined in one place
- [x] Composables for easy usage
- [x] Plugin for global access
- [x] Demo component included
- [x] Auto cleanup on unmount
- [x] Multiple listeners support
- [x] Debug utilities built-in

## 📞 Troubleshooting

### Issue: Event not triggering

Check if:
1. Event name matches exactly (use constants!)
2. Listener registered before emit
3. Component not unmounted before event fires

### Issue: Memory leak

Use composables that auto cleanup:
```javascript
useEventListener()  // ✅ Auto cleanup
useEventBus().on()  // ❌ Manual cleanup needed
```

### Issue: Too many listeners

Debug:
```javascript
const { eventNames, listenerCount } = useEventBus()
console.log(eventNames())  // See all events
eventNames().forEach(e => {
  console.log(e, listenerCount(e))
})
```

## 🎓 Learning Resources

- [Vue.js Event Handling](https://vuejs.org/guide/components/events.html)
- [Event Bus Pattern](https://www.npmjs.com/package/vue3-event-bus)
- [Composition API](https://vuejs.org/guide/extras/composition-api-faq.html)

## 📚 Related Files

- **src/main.js** - Plugin registration
- **src/components/demo/EventBusDemo.vue** - Usage example
- **src/components/sections/RSVPSection.vue** - Real implementation

---

**Happy eventing! 🎉**

