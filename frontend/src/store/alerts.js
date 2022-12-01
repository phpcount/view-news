export default {
  namespaced: true,
  state: {
    messages: [],
    lastAI: 0
  },
  getters: {
    all: state => state.messages,
  },
  mutations: {
    add(state, { text }) {
      state.messages.push({ id: ++state.lastAI, text });
    },
    remove(state, { id }) {
      state.messages = state.messages.filter(msg => msg.id !== id);
    }
  },
  actions: {
    add({ state, commit }, { text, timeout }) {
      commit('add', { text });

      setTimeout(() => {
        commit('remove', { id: state.lastAI });
      }, timeout);
    }
  }
}
