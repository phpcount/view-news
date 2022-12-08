<template>
  <div class="container" @wheel.stop="loadPostsIfNotEnough">
    <PostListItem v-for="post of posts" :key="post.id" :post="post" />
    <div v-if="showSpinner" class="mt-5">
      <p>Waiting for news...</p>
      <AppSpinner />
      <div v-if="countPosts > 0" class="mt-2">
        <button type="button" class="btn btn-secondary" @click="loadByScroll">
          Scroll down or press
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, onUnmounted, computed } from "vue";
import { useStore } from "vuex";
import { isReachedBottomScroll, hasScroll } from "@/lib/scroll";
import { throttle } from "@/lib/helpers";
import PostListItem from "@/components/PostListItem.vue";
import AppSpinner from "@/components/AppSpinner.vue";

const throttleDelay = 300;
const store = useStore();

const posts = computed(() => store.state.post.items);
const countPosts = computed(() => posts.value.length);
const isFullDataScroll = computed(() => store.getters["post/isFullDataScroll"]);
const showSpinner = computed(() => !hasScroll() && !isFullDataScroll.value);

const longPollingOff = () => store.dispatch("post/longPollingOff")
const longPollingOn = () => store.dispatch("post/longPollingOn")
const loadByScroll = () => store.dispatch("post/loadByScroll")

const loadPostsIfNotEnough = throttle((event) => {
  if (showSpinner.value && countPosts.value < 3 && event.deltaY > 0) {
    loadByScroll();
  }
}, 300);

const loadWithScroll = () => {
  isReachedBottomScroll().then(async () => {
    longPollingOff();
    await loadByScroll();
    longPollingOn();
  });
};

const nextLoadListener = throttle(loadWithScroll, throttleDelay);

onMounted(() => {
  if (0 === posts.value.length) {
    store.dispatch("post/load");
  }
  window.addEventListener("scroll", nextLoadListener);
});

onUnmounted(() => {
  longPollingOff();
  window.removeEventListener("scroll", nextLoadListener);
});
</script>

<style scoped>
.container {
  margin: auto 0;
}
</style>
