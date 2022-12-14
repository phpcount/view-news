export const STORAGE_SETTINGS_KEY = 'news__post-settings'

function getSettings() {
  return window.localStorage.getItem(STORAGE_SETTINGS_KEY)
    ? JSON.parse(window.localStorage.getItem(STORAGE_SETTINGS_KEY))
    : {
      limit: 3,
      longPollingTimeout: 3,
    }
}

export default {
  items: [],
  item: {},
  isFullDataScroll: false,
  statusChangeRating: {
    id: null,
    status: 'no-touched',
  },
  statusRatingItems: {},
  settings: getSettings(),
  longPollingState: false,
}
