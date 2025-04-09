<script setup>
import { useDesignStore } from '@/Store/Admin/designStore'
const store = useDesignStore()
</script>

<template>
  <h3 class="mb-4">Placeholders</h3>
  <div class="flex flex-col gap-y-4">
    <div>
      <label class="label mb-1 block">Post Image</label>
      <button
        :disabled="store.placeholders.image"
        type="button"
        class="w-2/3 disabled:cursor-not-allowed"
        @click="
          store.addPlaceholderFile(
            '/assets/images/placeholder-bg.jpeg',
            'placeholderImage',
            'image'
          )
        "
      >
        <img src="/assets/images/placeholder-bg.jpeg" alt="brand" />
      </button>
    </div>
    <div class="border-y py-5 dark:border-gray-700">
      <label class="label mb-1 block">Brand Logo</label>
      <button
        :disabled="store.placeholders.logo"
        class="w-2/3 disabled:cursor-not-allowed"
        type="button"
        @click="store.addPlaceholderFile('/assets/images/brand.png', 'placeholderLogo', 'logo')"
      >
        <img src="/assets/images/brand.png" alt="brand" />
      </button>
    </div>
    <div>
      <label class="label block">Brand Slogan</label>
      <button
        :disabled="store.placeholders.slogan"
        class="disabled:cursor-not-allowed"
        type="button"
        @click="store.addPlaceholderSlogan"
      >
        <p class="text-left text-lg">Your Slogan</p>
      </button>
    </div>
  </div>
</template>
