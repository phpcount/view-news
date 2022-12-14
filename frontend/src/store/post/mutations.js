export default {
  pushItems(state, data) {
    state.items.push(...data)
  },
  unshiftItems(state, data) {
    state.items.unshift(...data)
  },
  setItem(state, data) {
    state.item = data
  },
  clearItems(state) {
    state.items = []
    state.item = {}
    state.statusRatingItems = {}
  },
  fulledDataScroll(state) {
    state.isFullDataScroll = true
  },
  updatePostRating(state, {postId, rating, timeoutLeave = 800}) {
    const post = state.items.find(item => item.id === postId)
    if (!post) {
      return
    }

    const oldRating = post.rating
    state.statusChangeRating.id = postId
    if (oldRating < rating) {
      state.statusChangeRating.status = 'positive'
    } else if (oldRating > rating) {
      state.statusChangeRating.status = 'negative'
    }

    state.statusRatingItems[postId] = state.statusChangeRating.status

    setTimeout(() => state.statusChangeRating.status = 'touched', timeoutLeave)

    post.rating = rating

    if ('id' in state.item && state.item.id === postId) {
      state.item.rating = rating
    }
  },
  updateSettings(state, {key, value}) {
    state.settings[key] = value;
  },
  setLongPollingState(state, value) {
    state.longPollingState = value;
  },
  removeById(state, postId) {
    const index = state.items.findIndex(item => item.id === postId)

    if (index !== -1) {
      state.items.splice(index, 1)
    }
  }

}
