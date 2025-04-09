<script setup>
import { useDesignStore } from '@/Store/Admin/designStore'

const store = useDesignStore()
</script>

<template>
  <h3>Text</h3>
  <div class="flex flex-col items-start gap-y-3">
    <button
      v-for="(size, i) in store.textSizes"
      :key="size"
      :style="{ fontSize: `${size}px` }"
      @click="store.setText(size)"
    >
      Text <template v-if="i > 0">{{ i }}</template>
    </button>
  </div>
</template>
