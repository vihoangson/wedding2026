/**
 * Utils Index - Export all utility functions and classes
 */

export { default as eventBus } from './eventBus'
export { eventBusPlugin } from './eventBusPlugin'
export { useEventBus, useEventListener, useEventListeners } from './useEventBus'
export { WeddingEvents, EventPayloads } from './eventTypes'

// Export all as namespace
import * as EventBusUtils from './eventBus'
import * as EventBusPlugin from './eventBusPlugin'
import * as UseEventBus from './useEventBus'
import * as EventTypes from './eventTypes'

export { EventBusUtils, EventBusPlugin, UseEventBus, EventTypes }
