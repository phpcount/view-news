<template>
  <div class="container" @mousewheel.stop="loadPostsIfNotEnough">
    <PostListItem
      v-for="post of posts"
      :key="post.id"
      :post="post"
    />
    <div v-if="loadWithBtn" class="mt-5">
      <p>Waiting for news...</p>
      <AppSpinner/>
      <div v-if="(countPosts < 3)" class="mt-2">
        <button
        type="button"
        class="btn btn-secondary"
        @click="loadPostsIfNotEnough">Load more...</button>
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

const loadPostsLongPolling = () => store.dispatch("post/longPollingRetriev")
const loadPosts = () => store.dispatch("post/load")
const longPollingOff = () => store.dispatch("post/longPollingOff")
const loadByScroll = () => {
  isReachedBottomScroll().then(loadPosts);
};
const loadPostsIfNotEnough = () => {
  if (countPosts.value < 3) {
    loadPosts()
  }
}

const isFullDataLoaded = computed(() => store.getters['post/isFullDataLoaded'])
const loadWithBtn = computed(() => !hasScroll() && !isFullDataLoaded.value)

const nextLoadListener = throttle(loadByScroll, throttleDelay);

onMounted(() => {
  loadPostsLongPolling()
  window.addEventListener("scroll", nextLoadListener);
});

onUnmounted(() => {
  longPollingOff()
  window.removeEventListener("scroll", nextLoadListener);
});

</script>

<style scoped>

.container {
  margin: auto 0;
}

</style>
