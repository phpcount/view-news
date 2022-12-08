import * as api from '../../api/post'

export default {
  async loadLongPolling({ state, getters, commit, dispatch }) {
    if (false === state.longPollingState ) return;
    await new Promise(resolve => setTimeout(resolve, (1000 * getters.settings.longPollingTimeout)))
    if (false === state.longPollingState ) return;

    const { success, data } = await api.all({ lastPk: getters.lastPk, limit: getters.settings.limit })
    if (success) {
      commit('unshiftItems', data.items)
    }

    dispatch('loadLongPolling')
  },
  async loadByScroll({ getters, commit }, limit = null) {
    if (getters.isFullDataScroll) {
      return;
    }

    const firstPk = getters.firstPk

    const { success, data } = await api.all({ firstPk, limit: limit || getters.settings.limit })
    if (success) {
      if (0 === data.items.length) {
        commit('fulledDataScroll')
      }
      commit('pushItems', data.items)
    }
  },
  async load({ getters, commit }, limit = null) {
    const { success, data } = await api.all({limit: limit || getters.settings.limit})
    if (success) {
      commit('pushItems', data.items)
    }
  },
  async getById({ commit }, id) {
    const { data, success } = await api.one(id)

    if (success) {
      commit('setItem', data)
    }
  },
  reload({ getters, dispatch, commit }) {
    dispatch('longPollingOff')
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
    commit('updateSettings', { key, value });
  },
  longPollingOn({ commit },) {
    commit('setLongPollingState', true)
  },
  longPollingOff({ commit }) {
    commit('setLongPollingState', false)
  }
}
