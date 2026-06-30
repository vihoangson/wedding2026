<template>
  <div class="event-bus-demo">
    <h2>Event Bus Notification System</h2>

    <div class="notification-container">
      <transition-group name="fade">
        <div
          v-for="notification in notifications"
          :key="notification.id"
          :class="['notification', `notification-${notification.type}`]"
        >
          <i :class="`fas fa-${getIcon(notification.type)}`"></i>
          <span>{{ notification.message }}</span>
          <button @click="removeNotification(notification.id)" class="close-btn">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </transition-group>
    </div>

    <div class="demo-buttons">
      <button @click="showSuccessNotification" class="btn btn-success">
        <i class="fas fa-check"></i> Success
      </button>
      <button @click="showErrorNotification" class="btn btn-danger">
        <i class="fas fa-exclamation-circle"></i> Error
      </button>
      <button @click="showWarningNotification" class="btn btn-warning">
        <i class="fas fa-exclamation-triangle"></i> Warning
      </button>
      <button @click="showInfoNotification" class="btn btn-info">
        <i class="fas fa-info-circle"></i> Info
      </button>
    </div>

    <div class="event-stats">
      <h3>Event Statistics</h3>
      <p>Active Listeners: {{ activeListeners }}</p>
      <p>Active Events: {{ activeEvents.join(', ') || 'None' }}</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { useEventBus } from '@/utils/useEventBus'
import { WeddingEvents } from '@/utils/eventTypes'

const { emit, on, off, listenerCount, eventNames } = useEventBus()

const notifications = ref([])
const activeListeners = ref(0)
const activeEvents = ref([])
let notificationId = 0

// Listen for RSVP success event
const handleRsvpSuccess = (data) => {
  showNotification(`RSVP received from ${data.rsvpData?.name}!`, 'success')
}

// Listen for RSVP errors
const handleRsvpError = (data) => {
  showNotification(`Error: ${data.error || 'RSVP failed'}`, 'error')
}

// Listen for gallery events
const handleGalleryOpen = (data) => {
  showNotification(`Image ${data.imageIndex + 1} opened`, 'info')
}

// Listen for notification events
const handleNotificationShow = (data) => {
  showNotification(data.message, data.type || 'info')
}

const showNotification = (message, type = 'info') => {
  const id = notificationId++
  notifications.value.push({
    id,
    message,
    type,
  })

  // Auto remove after 3 seconds
  setTimeout(() => {
    removeNotification(id)
  }, 3000)
}

const removeNotification = (id) => {
  notifications.value = notifications.value.filter((n) => n.id !== id)
}

const showSuccessNotification = () => {
  emit(WeddingEvents.NOTIFICATION_SHOW, {
    message: '✓ Success! Everything is working perfectly.',
    type: 'success',
    duration: 3000,
  })
}

const showErrorNotification = () => {
  emit(WeddingEvents.NOTIFICATION_SHOW, {
    message: '✗ Error! Something went wrong.',
    type: 'error',
    duration: 3000,
  })
}

const showWarningNotification = () => {
  emit(WeddingEvents.NOTIFICATION_SHOW, {
    message: '⚠ Warning! Please check this.',
    type: 'warning',
    duration: 3000,
  })
}

const showInfoNotification = () => {
  emit(WeddingEvents.NOTIFICATION_SHOW, {
    message: 'ℹ Info! This is some information.',
    type: 'info',
    duration: 3000,
  })
}

const getIcon = (type) => {
  const icons = {
    success: 'check-circle',
    error: 'exclamation-circle',
    warning: 'exclamation-triangle',
    info: 'info-circle',
  }
  return icons[type] || 'bell'
}

const updateStats = () => {
  activeListeners.value = eventNames().length
  activeEvents.value = eventNames()
}

onMounted(() => {
  // Subscribe to events
  on(WeddingEvents.RSVP_SUCCESS, handleRsvpSuccess)
  on(WeddingEvents.RSVP_ERROR, handleRsvpError)
  on(WeddingEvents.GALLERY_OPEN, handleGalleryOpen)
  on(WeddingEvents.NOTIFICATION_SHOW, handleNotificationShow)

  updateStats()
})

onUnmounted(() => {
  // Cleanup listeners
  off(WeddingEvents.RSVP_SUCCESS, handleRsvpSuccess)
  off(WeddingEvents.RSVP_ERROR, handleRsvpError)
  off(WeddingEvents.GALLERY_OPEN, handleGalleryOpen)
  off(WeddingEvents.NOTIFICATION_SHOW, handleNotificationShow)
})
</script>

<style scoped>
.event-bus-demo {
  padding: 20px;
  max-width: 600px;
  margin: 0 auto;
}

.notification-container {
  position: fixed;
  top: 20px;
  right: 20px;
  z-index: 10000;
  width: 100%;
  max-width: 400px;
}

.notification {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 15px 20px;
  margin-bottom: 10px;
  border-radius: 8px;
  background: white;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  animation: slideIn 0.3s ease;
}

.notification-success {
  border-left: 4px solid #28a745;
  color: #28a745;
}

.notification-error {
  border-left: 4px solid #dc3545;
  color: #dc3545;
}

.notification-warning {
  border-left: 4px solid #ffc107;
  color: #856404;
}

.notification-info {
  border-left: 4px solid #17a2b8;
  color: #17a2b8;
}

.close-btn {
  background: none;
  border: none;
  cursor: pointer;
  font-size: 18px;
  margin-left: auto;
  opacity: 0.7;
  transition: opacity 0.3s;
}

.close-btn:hover {
  opacity: 1;
}

.demo-buttons {
  display: flex;
  gap: 10px;
  margin: 20px 0;
  flex-wrap: wrap;
}

.btn {
  padding: 10px 20px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 500;
  transition: all 0.3s;
  display: flex;
  align-items: center;
  gap: 8px;
}

.btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.btn-success {
  background: #28a745;
  color: white;
}

.btn-danger {
  background: #dc3545;
  color: white;
}

.btn-warning {
  background: #ffc107;
  color: #333;
}

.btn-info {
  background: #17a2b8;
  color: white;
}

.event-stats {
  background: #f8f9fa;
  padding: 15px;
  border-radius: 8px;
  margin-top: 20px;
}

.event-stats h3 {
  margin-top: 0;
  color: #333;
}

.event-stats p {
  margin: 8px 0;
  color: #666;
  font-family: monospace;
}

.fade-enter-active,
.fade-leave-active {
  transition: all 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: translateX(20px);
}

@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateX(20px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}

@media (max-width: 576px) {
  .notification-container {
    max-width: calc(100% - 20px);
  }

  .demo-buttons {
    flex-direction: column;
  }

  .btn {
    justify-content: center;
  }
}
</style>

