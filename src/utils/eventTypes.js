/**
 * Event Types & Constants
 * Centralized event name definitions
 */

export const WeddingEvents = {
  // Navigation Events
  SCROLL_TO_SECTION: 'navigation:scroll-to-section',
  NAVIGATE_TO_PAGE: 'navigation:navigate-to-page',

  // RSVP Events
  RSVP_SUBMIT: 'rsvp:submit',
  RSVP_SUCCESS: 'rsvp:success',
  RSVP_ERROR: 'rsvp:error',
  RSVP_LOADING: 'rsvp:loading',
  RSVP_UPDATE: 'rsvp:update',

  // Gallery Events
  GALLERY_OPEN: 'gallery:open',
  GALLERY_CLOSE: 'gallery:close',
  GALLERY_NEXT: 'gallery:next',
  GALLERY_PREV: 'gallery:prev',
  GALLERY_CLICK: 'gallery:click',

  // Modal Events
  MODAL_OPEN: 'modal:open',
  MODAL_CLOSE: 'modal:close',

  // Form Events
  FORM_VALIDATE: 'form:validate',
  FORM_SUBMIT: 'form:submit',
  FORM_RESET: 'form:reset',
  FORM_ERROR: 'form:error',

  // Notification Events
  NOTIFICATION_SHOW: 'notification:show',
  NOTIFICATION_HIDE: 'notification:hide',
  NOTIFICATION_SUCCESS: 'notification:success',
  NOTIFICATION_ERROR: 'notification:error',
  NOTIFICATION_WARNING: 'notification:warning',
  NOTIFICATION_INFO: 'notification:info',

  // Wedding Data Events
  WEDDING_DATA_LOAD: 'wedding:data:load',
  WEDDING_DATA_UPDATE: 'wedding:data:update',
  COUPLE_INFO_UPDATE: 'wedding:couple:update',
  VENUE_INFO_UPDATE: 'wedding:venue:update',

  // Carousel/Timeline Events
  CAROUSEL_NEXT: 'carousel:next',
  CAROUSEL_PREV: 'carousel:prev',
  CAROUSEL_GO_TO: 'carousel:go-to',

  // Search/Filter Events
  SEARCH_UPDATE: 'search:update',
  FILTER_UPDATE: 'filter:update',

  // User Interaction Events
  USER_CLICK: 'user:click',
  USER_HOVER: 'user:hover',
  USER_SCROLL: 'user:scroll',

  // Theme Events
  THEME_CHANGE: 'theme:change',
  THEME_TOGGLE_DARK: 'theme:toggle-dark',

  // Language Events
  LANGUAGE_CHANGE: 'language:change',
}

/**
 * Event Data Payloads
 * Define data structure for each event
 */
export const EventPayloads = {
  [WeddingEvents.RSVP_SUBMIT]: {
    name: String,
    email: String,
    phone: String,
    guests: Number,
    dietary: String,
    message: String,
    timestamp: Date,
  },

  [WeddingEvents.RSVP_SUCCESS]: {
    message: String,
    rsvpData: Object,
  },

  [WeddingEvents.GALLERY_CLICK]: {
    imageIndex: Number,
    imageSrc: String,
    imageAlt: String,
  },

  [WeddingEvents.NOTIFICATION_SHOW]: {
    message: String,
    type: String, // 'success', 'error', 'warning', 'info'
    duration: Number,
    position: String, // 'top', 'bottom', 'center'
  },

  [WeddingEvents.SCROLL_TO_SECTION]: {
    sectionId: String,
    smooth: Boolean,
  },

  [WeddingEvents.WEDDING_DATA_UPDATE]: {
    couple: Object,
    date: Date,
    venue: Object,
  },
}

export default WeddingEvents

