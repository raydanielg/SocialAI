<script setup>
import moment from 'moment'

import sharedComposable from '@/Composables/sharedComposable'

defineProps({
  content: {
    type: Object,
    default: {}
  }
})
const { textExcerpt } = sharedComposable()
</script>
<template>
  <Link
    :href="route('user.publish', content.uuid)"
    class="flex h-96 min-w-[18rem] flex-col rounded-2xl border border-gray-50 shadow-md dark:border-gray-600 dark:bg-[#0f172a7e]"
  >
    <div class="flex h-[17rem] w-full items-center justify-center overflow-hidden rounded">
      <img
        v-if="content.media.type === 'image' && content.media.url"
        v-lazy="content.media.url"
        class="h-full w-full object-cover"
        alt="media"
      />
      <i
        v-else-if="content.media.type === 'image' && content.media.url === null"
        class="bx bx-image text-9xl text-secondary-700"
      ></i>
      <i
        v-else-if="content.media.type === 'video'"
        class="bx bx-video text-9xl text-secondary-700"
      ></i>
      <i v-else class="bx bx-file text-9xl text-secondary-700"></i>
    </div>
    <div class="border-y border-gray-200 px-4 py-2 dark:border-gray-700">
      <div class="-mb-2 flex items-center justify-between">
        <p class="mb-0.5 font-semibold">{{ textExcerpt(content.title, 24) }}</p>
        <p class="text-xs text-gray-500">{{ content.created_at_diff }}</p>
      </div>
      <small class="text-gray-400">{{ content.brand?.name }}</small>
    </div>
    <div class="flex items-center justify-between px-4 pt-3">
      <div class="flex h-full items-center gap-1">
        <template v-for="brandPlatform in content.platforms ?? []" :key="brandPlatform.platform">
          <img
            v-if="['published', 'failed'].includes(brandPlatform.status)"
            class="w-6 rounded-md border p-1"
            :class="{
              'border-red-600 bg-red-50 ': brandPlatform.published_at == null,
              'border-green-600 bg-green-50': brandPlatform.published_at != null
            }"
            :src="`/assets/svg/${brandPlatform.platform}.svg`"
            :title="
              brandPlatform.published_at
                ? 'published ' + moment(brandPlatform.published_at).fromNow()
                : brandPlatform.data?.message?.message ?? brandPlatform.data?.message
            "
          />
        </template>
      </div>
      <div
        class="badge scale-90 border dark:bg-secondary-800"
        :class="{
          'border-gray-300 bg-red-50  text-gray-600 ': content.status == 'draft',
          'border-orange-300 bg-orange-50  text-orange-600': content.status == 'scheduled',
          'border-green-300 bg-green-50  text-green-600': content.status == 'published'
        }"
      >
        <i v-if="content.status == 'draft'" class="bx bx-file-blank mr-px text-base"></i>
        <i v-if="content.status == 'published'" class="bx bx-check-circle mr-px text-base"></i>
        <i v-if="content.status == 'scheduled'" class="bx bx-calendar mr-px text-base"></i>
        <span class="text-xs font-bold capitalize">{{ content.status }}</span>
      </div>
    </div>
  </Link>
</template>
