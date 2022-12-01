import { createStore } from 'vuex'
import post from './post';
import alerts from './alerts';

import postSettingsStorage from './post/local-storage-plugins';
import { addResponseHandler } from '@/api/http';

const store = createStore({
  modules: {
    post,
    alerts,
  },
  plugins: [postSettingsStorage]
})

addResponseHandler(
  (response) => {
    if (!response.data) {
      response.data = { success: true }
    }

    return response
  },
  (error) => {
    const config = error.config;

    if ('errorAlert' in config) {
      const { errorAlert } = config;

      store.dispatch('alerts/add', {
        text: 'Ошибка ответа от сервера ' + errorAlert,
        timeout: 3000
      });

      return { data: { error: true } }
    }

    return Promise.reject(error);
  }
);


export default store
