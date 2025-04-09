<script setup>
import { useDesignStore } from '@/Store/Admin/designStore'

const store = useDesignStore()
</script>
<template>
  <div class="mb-6 flex flex-col gap-y-3">
    Image
    <div class="flex items-center justify-between gap-3">
      <label class="label">Radius</label>
      <input
        step="5"
        v-model="store.imageStyles.cornerRadius"
        class="w-full cursor-pointer accent-primary-600"
        type="range"
        min="0"
        max="100"
      />
      <span
        class="label w-14 whitespace-nowrap rounded-md bg-secondary-200 px-2 py-1 text-center dark:bg-secondary-900"
      >
        {{ store.imageStyles.cornerRadius }} px
      </span>
    </div>
  </div>
  <button class="btn btn-soft-primary w-full" type="button" @click="store.changeImageStyle()">
    Update Changes
  </button>
</template>
