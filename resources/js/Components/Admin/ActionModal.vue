<script setup>
import { modal } from '@root/Composables/actionModalComposable'
</script>

<template>
  <transition name="fade" appear mode="out-in">
    <div v-if="modal.state" @click.self="modal.reset" class="c-modal-container">
      <div class="c-modal-content rounded bg-white p-5 dark:bg-dark-800">
        <div class="exclamation"><span>!</span></div>
        <h6 class="mt-4 text-center">{{ modal.confirm_text }}</h6>
        <p class="mb-4 mt-4 text-center">{{ modal.message }}</p>
        <div class="c-model-btn-container">
          <button @click="modal.accept" class="btn btn-primary">
            {{ modal.accept_btn_text }}
          </button>
          <button @click="modal.reset" class="btn btn-danger">{{ modal.reject_btn_text }}</button>
        </div>
      </div>
    </div>
  </transition>
</template>