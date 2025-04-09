<script setup>
import { onMounted } from 'vue'
import toast from '@root/Composables/toastComposable'
const props = defineProps({
  item: [Object],
  index: [String, Number],
  duration: {
    type: Number,
    default: 5000
  }
})

onMounted(() => setTimeout(() => toast.remove(props.index), props.duration))
</script>

<template>
  <div class="toastr" :class="`toastr-${item.type}`">
    <div class="toast-message-container">
      <svg
        class="icon"
        aria-hidden="true"
        xmlns="http://www.w3.org/2000/svg"
        fill="currentColor"
        viewBox="0 0 20 20"
      >
        <path
          d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"
        />
      </svg>
      <span class="toast-message">{{ item.message }}</span>
    </div>
    <button @click="toast.remove(index)" type="button" class="close">
      <svg
        width="16"
        height="16"
        aria-hidden="true"
        fill="currentColor"
        viewBox="0 0 20 20"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          fill-rule="evenodd"
          d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
          clip-rule="evenodd"
        ></path>
      </svg>
    </button>
  </div>
</template>