<template>
  <div>
    <ErrorAlert/>
    <BtnScrollUp />
    <div class="nav-container">
      <h2>News</h2>
      <nav class="nav ms-3">
        <router-link class="nav__link" :to="{ name: 'home' }">Home</router-link>
        <router-link class="nav__link" :to="{ name: 'settings' }">Settings</router-link>
      </nav>
    </div>
    <section class="section">
      <div class="container">
        <router-view v-slot="{ Component }">
          <transition name="slide" mode="out-in">
            <component :is="Component" />
          </transition>
        </router-view>
      </div>
    </section>
  </div>
</template>

<script setup>
import { useStore } from "vuex";
import { useRouter } from "vue-router";
import BtnScrollUp from '@/components/ui/BtnScrollUp.vue'
import ErrorAlert from './components/ErrorAlert.vue';

const store = useStore()
const router = useRouter()

router.afterEach((to, from) => {
  if (from.name === 'settings' && to.name === 'home') {
    store.dispatch('post/reload')
  }
})
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

.nav-container {
  color: #fff;
  display: flex;
  z-index: 10;
  background: #2c3e50;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  padding: 10px 30px;
  align-items: center;
  border-bottom: 1px solid #2c3e50;
}
.nav-container h2 {
  margin-right: 15px;
}
.nav a {
  text-decoration: none;
  font-weight: bold;
  color: #ececec;
}

.nav a.router-link-exact-active {
  color: #eab22d;
}

.nav__link {
  margin-right: 15px;
}

.section {
  margin-top: 80px;
}
.slide-enter-active {
  animation: slideIn 0.3s;
}

.slide-leave-active {
  animation: slideOut 0.3s;
}

@keyframes slideIn {
  from {
    transform: rotateY(90deg);
  }
  to {
    transform: rotateY(0deg);
  }
}

@keyframes slideOut {
  from {
    transform: rotateY(0deg);
  }
  to {
    transform: rotateY(90deg);
  }
}


.post.post-rating-positive--border {
  border-color: #00ff00 !important;
}
.post.post-rating-negative--border {
  border-color: #ff0000 !important;
}

.post.post-rating-positive {
  animation: positive-rating 0.7s ease-in-out;
}
.post.post-rating-negative {
  animation: negative-rating 0.7s ease-in-out;
}

@keyframes positive-rating {
  0% {
    background-color: inherit;
  }
  50% {
    background-color: #00ff0025;
  }
  100% {
    background-color: inherit;
  }
}
@keyframes negative-rating {
  0% {
    background-color: inherit;
  }
  50% {
    background-color: #ff000025;
  }
  100% {
    background-color: inherit;
  }
}
</style>
