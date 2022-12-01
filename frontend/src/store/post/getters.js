export default {
  isFullDataLoaded: (state) => 'self' in state.linksItems && state.linksItems.self === state.linksItems.last,

  nextPage: (state) => state.linksItems.next,

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
