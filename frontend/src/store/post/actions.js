import * as api from '../../api/post'
import * as apiNewsCollector from '../../api/news-collector'

export default {
  async longPollingRetriev({ state, getters, dispatch }) {
    if (false === state.longPollingState) {
      return;
    }

    dispatch('load')
    if (0 === state.items.length) {
      await new Promise(resolve => setTimeout(resolve, (1000 * getters.settings.longPollingTimeout)))
      if (0 === state.items.length) {
        dispatch('longPollingRetriev')
        return
      }
    }

    dispatch('longPollingOff')
  },
  async load({ getters, commit }, limit = null) {
    if (getters.isFullDataLoaded) {
      return;
    }

    const { success, data, links } = await api.all(getters.nextPage, limit || getters.settings.limit)
    if (success) {
      commit('addItems', data.items)
      commit('setLinksItems', links)
    }
  },
  async getById({ commit }, id) {
    const { data, success } = await api.one(id)

    if (success) {
      commit('setItem', data)
    }
  },
  reload({ getters, dispatch, commit }) {
    commit('clearItems');
    dispatch('load', getters.settings.limit)
  },
  async remove({ commit }, postId) {
    const { success } = await api.remove(postId)

    if (success) {
      commit('removeById', postId)
    }
  },
  async changeRating({ commit }, { postId, rating }) {
    const { success } = await api.updateRating(postId, rating)
    if (success) {
      commit('updatePostRating', { postId, rating });
    }
  },

  async changeSettings({ commit }, { key, value }) {
    if (key === 'newsCollectorTimeout') {
      const { success } = await apiNewsCollector.changeDelay(value)
      if (success) {
        commit('updateSettings', { key, value })
        return
      }
    }

    commit('updateSettings', { key, value });
  },
  longPollingOff({ commit }) {
    commit('setLongPollingState', false)
  }
}
