<template>
  <div class="ratings">
    <i
      v-for="num in max"
      :key="num"
      :class="{ 'rating-color': num <= value }"
      @click="changeRating(+num)"
      >&#9734;</i>
  </div>
</template>

<script setup>
import { defineProps, defineEmits } from "vue"
import { useStore } from "vuex";

const props = defineProps({
  value: Number,
  postId: String,
  max: {
    type: Number,
    default: 5,
  },
})

const emit = defineEmits(['update'])


const store = useStore();

function changeRating(rating) {
  if (props.value === rating) {
    return;
  }

  emit('update', rating);
  store.dispatch("post/changeRating", { postId: props.postId, rating });
}
</script>

<style scoped>
.ratings {
  margin-right: 10px;
}

.ratings i {
  cursor: pointer;
  color: #cecece;
  font-size: 32px;
  font-style: normal;
  margin: 0 3px;
}

.rating-color {
  color: #fbc634 !important;
  transition: color 0.5s;
}

</style>
