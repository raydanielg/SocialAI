<script setup>
import { useDesignStore } from '@/Store/Admin/designStore'
const store = useDesignStore()
</script>

<template>
  <h3 class="mb-4">Placeholders</h3>
  <div class="flex flex-col gap-y-3">
    <button
      :disabled="store.placeholders.slogan"
      class="disabled:cursor-not-allowed"
      type="button"
      @click="store.addPlaceholderSlogan"
    >
      <p class="text-left text-lg">Brand Name</p>
    </button>
  </div>
</template>
