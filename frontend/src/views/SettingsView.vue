<template>
  <div class="settings">
    <div  class="row text-start">
      <div class="col-md-6">
        <div class="settings-post">
          <h3 class="mb-4">Setting of posts</h3>
          <table>
            <tbody>
              <tr class="settings-post__tr">
                <td class="settings-post__td">Number of items per page:</td>
                <td>
                  <input
                    :value="settingsPost.limit"
                    class="settings-post__input settings-post__input--number"
                    type="number"
                    min="1"
                    @focusout="changeSettingsPost('limit', +$event.target.value)"
                  />
                </td>
                <td></td>
              </tr>
              <tr class="settings-post__tr">
                <td class="settings-post__td">
                  Long pooling update every N - seconds:
                </td>
                <td>
                  <input
                    :value="settingsPost.longPollingTimeout"
                    class="settings-post__input settings-post__input--number"
                    type="number"
                    @focusout="changeSettingsPost('longPollingTimeout', +$event.target.value)"
                  />
                </td>
                <td></td>
              </tr>
            </tbody>
          </table>
          <h3 class="text-warning mt-5">Experimental funtion</h3>
          <h4>News auto collector</h4>
          <p>Need to run command: <code>symfony console messenger:consume</code></p>
          <table>
            <tbody>
              <tr class="settings-post__tr">
                <td class="settings-post__td">
                  Data from news collector update every N - seconds:
                </td>
                <td>
                  <input
                    :value="settingsPost.newsCollectorTimeout"
                    class="settings-post__input settings-post__input--number"
                    type="number"
                    @focusout="changeSettingsPost('newsCollectorTimeout', +$event.target.value)"
                  />
                </td>
                <td>
                </td>
              </tr>
              <tr class="settings-post__tr">
                <td class="settings-post__td">
                  News Collector:
                </td>
                <td>
                  <BtnNewsCollectorRemote class="settings-post__btn" />
                </td>
                <td></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from "vue";
import { useStore } from "vuex";
import BtnNewsCollectorRemote from "@/components/BtnNewsCollectorRemote.vue";

const store = useStore();

const settingsPost = computed(() => store.getters['post/settings']);

const changeSettingsPost = (key, value) => store.dispatch('post/changeSettings', {key, value})
</script>

<style scoped>
table {
  width: 100%;
}

.settings-post__tr {
  display: flex;
  margin-bottom: 7px;
}

.settings-post__td {
  max-width: 360px;
  width: 100%;
  text-align: left;
  word-break: break-all;
}

.settings-post__btn {
  margin-left: 15px;
  width: 57px;
  text-align: center;
}

.settings-post__input {
  margin-left: 15px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

.settings-post__input--number {
  width: 57px;
}
</style>
