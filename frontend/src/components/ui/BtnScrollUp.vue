<template>
  <transition name="fade">
    <svg
      v-if="isShow"
      @click="scrollUp"
      class="btn-scroll-up"
      xmlns="http://www.w3.org/2000/svg"
      width="53"
      height="53"
      viewBox="0 0 71 71"
    >
      <g transform="translate(-1119 -2776)">
        <g
          transform="translate(1119 2776)"
          fill="#fff"
          stroke="gray"
          stroke-width="3"
        >
          <circle cx="35.5" cy="35.5" r="35.5" stroke="none" />
          <circle cx="35.5" cy="35.5" r="34" fill="none" />
        </g>
        <path
          d="M10.186,30,23.811,16.4,37.437,30l4.186-4.186L23.811,8,6,25.811Z"
          transform="translate(1130.459 2790.814)"
          fill="gray"
        />
      </g>
    </svg>
  </transition>
</template>

<script setup>
import { scrollUp } from "@/lib/scroll";
import { onMounted, ref } from "vue";

const isShow = ref(false);

onMounted(() => {
  addEventListenerCheckScroll(450);
});

function addEventListenerCheckScroll(maxScrollPx = 300) {
  window.addEventListener("scroll", () => {
    const scrollY = window.scrollY || document.documentElement.scrollTop;
    isShow.value = scrollY > maxScrollPx;
  });
}
</script>


<style scoped>
.btn-scroll-up {
  cursor: pointer;
  position: fixed;
  bottom: 50px;
  right: 50px;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
