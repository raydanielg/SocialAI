<script setup>
import { ref, onMounted, computed, onUnmounted } from 'vue'

const props = defineProps({
  target: {
    type: [Number, String],
    required: true
  },
  duration: {
    type: Number,
    default: 2000
  }
})

const currentNumber = ref(0)
let timer = null
let observer = null
let counterRef = ref(null)

const formattedNumber = computed(() => {
  // Round the number to one decimal place
  if (currentNumber.value > 99) {
    return Math.floor(currentNumber.value).toString()
  }

  // Round the number to two decimal places
  if (currentNumber.value < 1) {
    return currentNumber.value.toFixed(1)
  } else {
    return currentNumber.value.toFixed(1).toString()
  }
})

const startCounter = () => {
  const steps = Math.ceil(props.duration / 50)
  const increment = props.target / steps

  timer = setInterval(() => {
    currentNumber.value += increment
    if (currentNumber.value >= props.target) {
      clearInterval(timer)
      currentNumber.value = props.target
    }
  }, 50)
}

onMounted(() => {
  // Intersection Observer setup
  const options = {
    root: null, // Use the viewport as the root
    rootMargin: '0px',
    threshold: 0.5 // Trigger when 50% of the element is visible
  }

  observer = new IntersectionObserver((entries) => {
    if (entries[0].isIntersecting) {
      startCounter()
      observer.unobserve(entries[0].target) // Stop observing after triggering once
    }
  }, options)

  observer.observe(counterRef.value) // Observe the span element
})

onUnmounted(() => {
  if (timer) {
    clearInterval(timer) // Clear interval when component is unmounted
  }
  if (observer) {
    observer.disconnect() // Disconnect observer when component is unmounted
  }
})
</script>

<template>
  <span ref="counterRef">{{ formattedNumber }}</span>
</template>