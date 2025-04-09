<script setup>
import { useModalStore } from '@root/Store/modalStore'
const modal = useModalStore()

const emit = defineEmits(['action'])
const props = defineProps({
  state: {
    type: Boolean,
    default: false
  },
  closeBtn: {
    type: Boolean,
    default: true
  },
  backdropClose: {
    type: Boolean,
    default: true
  },
  headerState: {
    type: Boolean,
    default: false
  },
  headerTitle: {
    type: String,
    default: 'Header Title'
  },
  actionBtnState: {
    type: Boolean,
    default: false
  },
  actionProcessing: {
    type: Boolean,
    default: false
  },
  bgBlur: {
    type: Boolean,
    default: false
  },
  bgColor: {
    type: String,
    default: 'bg-white dark:bg-dark-800'
  }
})

const handleBackdropClose = () => {
  if (props.backdropClose) {
    modal.close()
  }
  return
}
</script>

<template>
  <transition name="fade" appear mode="out-in">
    <div
      v-if="state"
      class="c-modal-container"
      :class="{ 'bg-blur': bgBlur }"
      @click.self="handleBackdropClose"
    >
      <div class="c-modal-content rounded-lg p-6" :class="bgColor">
        <h6 v-if="headerState" class="c-modal-header">{{ headerTitle }}</h6>
        <button v-if="closeBtn" class="c-modal-close" type="button" @click="modal.close">
          <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24">
            <path
              fill="currentColor"
              d="m12 13.4l-2.9 2.9q-.275.275-.7.275t-.7-.275q-.275-.275-.275-.7t.275-.7l2.9-2.9l-2.9-2.875q-.275-.275-.275-.7t.275-.7q.275-.275.7-.275t.7.275l2.9 2.9l2.875-2.9q.275-.275.7-.275t.7.275q.3.3.3.713t-.3.687L13.375 12l2.9 2.9q.275.275.275.7t-.275.7q-.3.3-.713.3t-.687-.3L12 13.4Z"
            />
          </svg>
        </button>
        <div class="c-main-content">
          <slot />
        </div>
        <div v-if="actionBtnState" class="c-model-btn-container-end">
          <button @click="emit('action')" type="button" class="btn btn-primary">
            <svg
              v-if="actionProcessing"
              xmlns="http://www.w3.org/2000/svg"
              width="1rem"
              height="1rem"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="feather feather-loader animate-spin"
            >
              <line x1="12" y1="2" x2="12" y2="6"></line>
              <line x1="12" y1="18" x2="12" y2="22"></line>
              <line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line>
              <line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line>
              <line x1="2" y1="12" x2="6" y2="12"></line>
              <line x1="18" y1="12" x2="22" y2="12"></line>
              <line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line>
              <line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line>
            </svg>
            <span>{{ trans('Submit') }}</span>
          </button>
        </div>
      </div>
    </div>
  </transition>
</template>