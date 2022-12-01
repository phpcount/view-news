import { STORAGE_SETTINGS_KEY } from "./state";

const localStoragePlugin = store => {
  store.subscribe((mutation, { post }) => {
    if (
      !window.localStorage.getItem(STORAGE_SETTINGS_KEY)
      || mutation.type === "post/updateSettings"
    ) {
      window.localStorage.setItem(STORAGE_SETTINGS_KEY, JSON.stringify(post.settings))
    }
  })
}

export default localStoragePlugin
