<script setup>
import { ref, onMounted, onUnmounted } from "vue"

defineProps({
  btnText: {
    type: String,
  },
  btnClass: {
    type: String,
  },
})

const dropdown = ref(false)
const dropdownBtn = ref(null)

const toggleDropdown = () => {
  dropdown.value = !dropdown.value
}

const outsideClick = (event) => {
  if (dropdown.value && dropdownBtn.value != event.target) {
    dropdown.value = false
  }
}
onMounted(() => {
  document.addEventListener("click", outsideClick)
})

onUnmounted(() => {
  document.removeEventListener("click", outsideClick)
})
</script>

<template>
  <div class="relative">
    <button ref="dropdownBtn" type="button" @click="toggleDropdown" :class="btnClass">
      <template v-if="btnText"> {{ btnText }}</template>
      <slot v-else name="btnContent">{{ btnText }}</slot>
    </button>
    <Transition name="slide-bottom">
      <div
        v-if="dropdown"
        class="absolute top-[100%] right-0 rounded-lg overflow-hidden shadow-lg max-w-60 min-h-12"
      >
        <slot> Dropdown Contents </slot>
      </div>
    </Transition>
  </div>
</template>
