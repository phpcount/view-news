export default {
  firstPk: (state) => {
    const length = state.items.length
    if (0 === length) {
      return null
    }

    return Math.min(...state.items.map(p => p.pk))
  },

  lastPk: (state) => {
    const length = state.items.length
    if (0 === length) {
      return null
    }

    return Math.max(...state.items.map(p => p.pk))
  },

  isFullDataScroll: (state) => state.isFullDataScroll,

  classAnimationStatusChangeRating: (state) => (postId) => {
    return {
      [`post-rating-${state.statusChangeRating.status}`]:
        state.statusChangeRating.id === postId
    }
  },

  classBorderStatusRatingItem: (state) => (postId) => {
    if (state.statusRatingItems[postId]) {
      return {
        [`post-rating-${state.statusRatingItems[postId]}--border`]: true
      }
    }

    return {};
  },

  settings: (state) => state.settings,
}
