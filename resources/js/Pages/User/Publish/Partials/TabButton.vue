<script setup>
import { usePublishStore } from '@/Store/publishStore'
import { storeToRefs } from 'pinia'
const store = usePublishStore()
const { getTabState } = storeToRefs(store)
const props = defineProps({
  title: {
    type: String,
    required: true
  },
  text: {
    type: String,
    default: null
  },
  icon: String,
  isMobile: {
    type: Boolean,
    default: false
  }
})
</script>
<template>
  <button
    @click="store.setTab(title)"
    type="button"
    class="publish-tab flex w-full items-center justify-center rounded-xl p-2.5 shadow-md transition-colors lg:justify-start"
    :class="{ active: getTabState(title) }"
  >
    <div
      class="publish-tab-icon flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full lg:mr-4 lg:h-10 lg:w-10"
      :class="{ 'active-icon': getTabState(title) }"
    >
      <i class="bx text-base lg:text-xl" :class="icon"></i>
    </div>
    <span class="mb-1 hidden capitalize lg:inline">{{ text ? text : title }}</span>
  </button>
</template>
