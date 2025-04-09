<script setup>
import Toastr from '@root/Components/Toastr.vue'
import { computed, watchEffect } from 'vue'
import { usePage } from '@inertiajs/vue3'
import toast from '@root/Composables/toastComposable'

const hasToast = computed(() => usePage().props.toast)
watchEffect(() => toast.setSessionToast(hasToast.value))
</script>

<template>
  <TransitionGroup tag="div" name="right" class="toastr-container" :class="toast.position">
    <Toastr v-for="(item, index) in toast.items" :key="item.key" :item="item" :index="index" />
  </TransitionGroup>
</template>
