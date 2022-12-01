<template>
  <div class="container">
    <AppSpinner v-if="!post.id" class="m-5"/>
    <div v-else class="full-post-container">
      <div class="post full-post" :class="{ ...classAnimationStatusChangeRating(post.id), ...classBorderStatusRatingItem(post.id) }">
        <div class="full-post__top">
          <div class="post__date">
            {{ createdAt }}
          </div>
          <a :href="post.link" target="_blank">original source</a>
        </div>
        <h2 class="full-post__h2">{{ post.title }}</h2>
        <h5 v-if="post.textOverview">
          <em>{{ post.textOverview }}</em>
        </h5>
        <img
          v-if="post.image"
          :src="post.image"
          :alt="post.title"
          class="full-post__img-main"
        />
        <PostRating
          class="full-post__rating"
          :value="post.rating"
          :post-id="post.id"
          :max="10"
        />
        <div class="full-post__text paragraph">
          {{ post.content }}
        </div>
      </div>
    </div>
    <div class="full-post__bottom">
      <router-link :to="{ name: 'home' }"> Back to Home </router-link>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted } from "vue";
import { useRoute } from "vue-router";
import { useStore } from "vuex";
import { formatDateTime } from "@/lib/helpers";
import PostRating from "@/components/PostRating.vue";
import AppSpinner from "@/components/AppSpinner.vue";

const route = useRoute();
const store = useStore();

const getPost = (id) => store.dispatch("post/getById", id);

onMounted(() => getPost(route.params.id));

const classAnimationStatusChangeRating = computed(() => store.getters["post/classAnimationStatusChangeRating"]);
const classBorderStatusRatingItem = computed(() => store.getters["post/classBorderStatusRatingItem"]);

const post = computed(() => store.state.post.item);

const createdAt = computed(() => formatDateTime(post.value.createdAt));
</script>

<style scoped>
.container {
  margin: auto 0;
}

.full-post-container {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
.full-post {
  max-width: 1051px;
  border: 1px solid #fdfdfd;
  border-radius: 3px;
  padding: 7px;
  margin: 50px 30px;
}

.full-post__h2 {
  font-weight: bold;
}

.full-post__top {
  font-size: 14px;
  display: grid;
  place-items: start;
  grid-template-columns: 250px 200px;
  margin-bottom: 10px;
}

.full-post__img-main {
  width: 100%;
}

.full-post__rating {
  text-align: left;
}
.full-post__text {
  margin-top: 15px;
}

.paragraph {
  width: 100%;
  white-space: pre-line;
  text-align: justify;
  line-height: 1.6;
}

.full-post__bottom {
  margin: 0 0 30px;
}
</style>
