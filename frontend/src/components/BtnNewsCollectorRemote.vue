<template>
  <button
    type="button"
    class="btn btn-sm"
    :class="[btnClass]"
    @click="toggleCollect"
  >{{btnText}}</button>
</template>


<script setup>
import { computed, ref } from "vue";
import { useStore } from "vuex";
import { start, stop, state } from '@/api/news-collector';

const store = useStore()

const isCollect = ref(false)
state().then(state => isCollect.value = state)

const settingsPost = computed(() => store.getters['post/settings']);
const btnText = computed(() => isCollect.value ? 'Stop' : 'Start');
const btnClass = computed(() => isCollect.value ? 'btn-danger' : 'btn-success');

function toggleCollect() {
  if (isCollect.value) {
    stop().then(isCollect.value = false)
  } else {
    start(settingsPost.value.newsCollectorTimeout).then(isCollect.value = true)
  }
}

</script>
