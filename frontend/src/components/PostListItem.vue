<template>
  <div class="post-container">
    <div class="post" :class="{ ...classAnimationStatusChangeRating(post.id), ...classBorderStatusRatingItem(post.id) }">
      <div class="post__top">
        <div class="post__date">
          {{ createdAt }}
        </div>
      </div>
      <router-link
        class="post__header"
        :to="{ name: 'post', params: { id: post.id } }"
        exact-active-class="text-danger"
      >
        <h2 class="post__h2">{{ post.title }}</h2>
      </router-link>
      <div class="post__content">
        <p class="paragraph">{{ post.content }}</p>
        <router-link
          :to="{ name: 'post', params: { id: post.id } }"
          exact-active-class="text-danger"
          class="post__btn-more"
          >More...</router-link
        >
      </div>

      <PostRating
        :value="post.rating"
        :post-id="post.id"
        :max="10"
        class="post__rating"
      />
      <hr />
      <div class="post__controlls">
        <button
          type="button"
          class="btn btn-sm btn-danger post__btn-delete"
          @click="removePost(post.id)"
        >
          Delete
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps, computed } from "vue";
import { useStore } from "vuex";
import { formatDateTime } from "@/lib/helpers";
import PostRating from "@/components/PostRating.vue";

const props = defineProps({
  post: {
    type: Object,
    default: () => {},
  },
});

const store = useStore();

const classAnimationStatusChangeRating = computed(() => store.getters["post/classAnimationStatusChangeRating"]);
const classBorderStatusRatingItem = computed(() => store.getters["post/classBorderStatusRatingItem"]);

const createdAt = computed(() => formatDateTime(props.post.createdAt));

const removePost = (id) => {
  store.dispatch('post/remove', id)
};

</script>

<style scoped>

.post-container {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
.post {
  border: 1px solid #ccc;
  border-radius: 3px;
  padding: 20px;
  margin: 50px 30px;
  width: 730px;
  text-align: left;
}

.post__date {
  text-align: left;
  margin-bottom: 5px;
}

.post__top {
  font-size: 13px;
  display: grid;
  place-items: start;
  grid-template-columns: 250px 150px;
  margin-bottom: 10px;
}

.post__header {
  color: #2c3e50;
  text-decoration: none;
  text-align: center;
}

.post__h2:hover {
  color: #2c3e50c9;
}

.paragraph {
  width: 100%;
  text-align: justify;
}

.post__btn-more {
  font-weight: 700;
}

.post__controlls {
  text-align: right;
}

</style>
