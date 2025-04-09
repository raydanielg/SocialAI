<script setup>
import { useDesignStore } from '@/Store/Admin/designStore'
import { ref } from 'vue'
defineProps(['shapes'])
const store = useDesignStore()
const openedFolders = ref([])
const toggleAccordion = (folder) => {
  const index = openedFolders.value.indexOf(folder)
  if (index >= 0) {
    openedFolders.value.splice(index, 1)
  } else {
    openedFolders.value.push(folder)
  }
}
</script>

<template>
  <h3 class="mb-4">Shapes</h3>
  <template v-for="(shape, key) in shapes" :key="key">
    <div class="mb-2">
      <button
        class="flex w-full items-center justify-between rounded-md bg-secondary-100 px-4 py-2 text-left capitalize dark:bg-secondary-900"
        @click="toggleAccordion(key)"
      >
        <span>{{ key.replace('_', ' ') }}</span>
        <i
          class="bx bx-chevron-right text-xl transition-transform"
          :class="{ 'rotate-90': openedFolders.includes(key) }"
        ></i>
      </button>
      <div class="grid grid-cols-3 gap-x-4 gap-y-5 p-3" v-if="openedFolders.includes(key)">
        <button v-for="s in shape" :key="s" @click="store.setShape(`/assets/shapes/${key}/${s}`)">
          <img v-lazy="`/assets/shapes/${key}/${s}`" alt="shape" />
        </button>
      </div>
    </div>
  </template>
</template>
