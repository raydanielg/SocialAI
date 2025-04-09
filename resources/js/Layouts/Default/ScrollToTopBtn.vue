<script setup>
import { onMounted, onUnmounted, ref } from "vue"

const isSticky = ref(false)

const handleSticky = () => {
  if (window.scrollY > 200) {
    isSticky.value = true
  } else {
    isSticky.value = false
  }
}

onMounted(() => {
  window.addEventListener("scroll", handleSticky)
})

onUnmounted(() => {
  window.removeEventListener("scroll", handleSticky)
})

const scrollTop = () => {
  window.scrollTo({ top: 0, behavior: "smooth" })
}

const props = defineProps({
  style_2: Boolean,
})
</script>

<template>
  <!-- back to top start -->
  <button
    :class="`scroll-top scroll-to-target ${isSticky ? 'open' : ''}`"
    @click="scrollTop"
  >
    <i class="far fa-angle-double-up"></i>
  </button>
  <!-- back to top end -->
</template>
