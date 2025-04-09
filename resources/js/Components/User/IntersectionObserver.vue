<script setup>
import { ref, onMounted } from 'vue'
import HollowDotsSpinner from '../HollowDotsSpinner.vue'

const props = defineProps({
  targetView: {
    default: null,
    required: true
  },
  observerCondition: {
    type: Boolean,
    default: true
  },
  loader: {
    type: Boolean,
    default: false
  },
  afterIntersection: {
    type: Function,
    default: () => {}
  }
})

const intersectionTargetView = ref(null)
let observer = null

const onIntersection = (entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting && props.observerCondition) {
      props.afterIntersection()
    }
  })
}

onMounted(() => {
  if (props.observerCondition) {
    observer = new IntersectionObserver(onIntersection, {
      root: null,
      rootMargin: '10px',
      threshold: 0.5
    })
    observer.observe(intersectionTargetView.value)
  }
})
</script>

<template>
  <div ref="intersectionTargetView"></div>
  <div class="mt-5 flex justify-center" v-if="loader">
    <HollowDotsSpinner />
  </div>
</template>
