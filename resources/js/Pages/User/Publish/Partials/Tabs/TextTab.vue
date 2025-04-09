<script setup>
import sharedComposable from '@/Composables/sharedComposable'
import { usePublishStore } from '@/Store/publishStore'
const { countWordsAndChars } = sharedComposable()

const store = usePublishStore()
</script>

<template>
  <label class="label my-3 text-lg">Text </label>
  <textarea
    v-model="store.brandPostContentPlatform.content"
    class="textarea min-h-[20rem]"
    placeholder="Text"
  ></textarea>
  <p class="text-end text-xs">
    Characters: {{ countWordsAndChars(store.brandPostContentPlatform.content).characters }} / Words:
    {{ countWordsAndChars(store.brandPostContentPlatform.content).words }}
  </p>
  <div class="mt-4 flex items-center gap-3">
    <button
      :disabled="store.loading.content"
      type="button"
      @click="store.generateContent('content')"
      class="btn btn-soft-primary w-full"
    >
      <svg
        v-if="store.loading.content"
        class="my-1.5 mr-px h-5 w-5 animate-spin text-white"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
      >
        <circle
          class="opacity-25"
          cx="12"
          cy="12"
          r="10"
          stroke="currentColor"
          stroke-width="4"
        ></circle>
        <path
          class="opacity-75"
          fill="currentColor"
          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
        ></path>
      </svg>
      <i class="bx bx-refresh text-2xl" v-else></i>
      <span>Regenerate</span>
    </button>
  </div>
</template>
