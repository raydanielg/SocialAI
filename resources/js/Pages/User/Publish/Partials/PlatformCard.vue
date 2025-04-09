<script setup>
import { computed, ref } from 'vue'

import HollowDotsSpinner from '@/Components/HollowDotsSpinner.vue'
import { usePublishStore } from '@/Store/publishStore'

const store = usePublishStore()

const dynamicMediaItemClasses = (index) => {
  let totalMedia = store.getActivePlatformContent('media').length
  if (totalMedia == 1 && index == 0) return ['col-span-2']
  if (totalMedia == 3 && index == 2) return ['col-span-2']
}

const isImageModified = computed(() => {
  return (
    store.mainTab == 'designs' &&
    store.selectedDesigns?.find((d) => d.platform === store.platformTab) &&
    store.getActivePlatformContent('media').length < 2
  )
})

const getTiktokUserOptions = computed(() => {
  return store.tiktokUserOptions?.privacy_level_options ?? []
})

const optionsAreaState = ref(false)
</script>

<template>
  <div class="m-auto max-w-md" :class="{ group: !optionsAreaState }">
    <div class="card flex items-center rounded-none rounded-t-xl px-5 py-3">
      <img
        :src="store.form?.brand?.logo ? store.form.brand.logo : '/assets/images/brand.png'"
        class="h-12 w-12 rounded-full object-cover shadow"
        alt="logo"
      />
      <div class="ml-4">
        <p class="-mb-2 text-sm font-semibold">{{ store.form.brand?.name ?? '-' }}</p>
        <span class="text-xs">10h Ago</span>
      </div>
    </div>
    <p
      @click="store.setTab('text')"
      class="card cursor-pointer rounded-none border border-primary-50 px-5 py-3 text-sm hover:rounded hover:border-primary-300 group-hover:my-6 dark:border-secondary-900 dark:hover:border-primary-900"
    >
      {{ store.brandPostContentPlatform?.content }}
    </p>

    <div
      class="card w-full rounded-none object-contain"
      :class="{
        'h-[28rem]': store.getActivePlatformContent('media_type') !== 'video',
        'h-[15.5rem]': store.getActivePlatformContent('media_type') === 'video'
      }"
    >
      <div
        class="flex h-full w-full flex-col items-center justify-center gap-5"
        v-if="store.isDesignProcessing"
      >
        <p class="text-lg font-semibold">Rendering...</p>
        <HollowDotsSpinner class="ml-9 scale-150" />
      </div>
      <div
        v-else-if="
          store.getActivePlatformContent('media_type') == 'image' &&
          store.getActivePlatformContent('media').length > 0
        "
        :class="{ 'grid-rows-2': store.getActivePlatformContent('media').length > 2 }"
        class="relative grid h-full cursor-pointer grid-cols-2 overflow-hidden"
      >
        <button
          v-if="isImageModified"
          @click="store.$patch({ designEditor: true })"
          class="btn absolute right-2 top-2 z-40 flex items-center bg-gray-100 hover:bg-opacity-50 dark:bg-secondary-900"
        >
          <i class="bx bxs-magic-wand mt-1"></i>
          <span>Modify</span>
        </button>

        <template
          :key="index"
          v-for="(media, index) in store.getActivePlatformContent('media').slice(0, 4)"
        >
          <img
            @click="store.setTab('images')"
            :class="dynamicMediaItemClasses(index)"
            class="h-[28rem] w-full object-cover object-center"
            :src="media"
            alt="image"
          />
          <div
            @click="store.setTab('images')"
            v-if="index == 3 && store.getActivePlatformContent('media').length > 4"
            class="absolute bottom-0 right-0 flex h-[14rem] w-1/2 items-center justify-center bg-black/40"
          >
            <p class="text-4xl text-white">
              +{{ store.getActivePlatformContent('media').length - 4 }}
            </p>
          </div>
        </template>
      </div>

      <div
        class="flex h-full justify-center"
        v-else-if="
          store.getActivePlatformContent('media_type') == 'video' &&
          store.getActivePlatformContent('media')?.length > 0
        "
      >
        <template :key="media" v-for="media in store.getActivePlatformContent('media')">
          <video @click="store.setTab('videos')" controls class="h-full">
            <source :src="media" type="video/mp4" />
            Your browser does not support the video tag.
          </video>
        </template>
      </div>

      <img v-else src="/assets/images/about-bg-shape.png" alt="default" />
    </div>
    <div
      class="card flex items-center justify-between rounded-none rounded-b-xl px-5 py-3 group-hover:mt-6"
    >
      <div class="space-x-4">
        <i class="bx bx-share-alt"></i>
        <i class="bx bx-home-alt"></i>
      </div>
      <small>12 comments 2 shares</small>
    </div>
    <div
      class="card mt-4 border border-primary-600/50 p-5 pb-8 shadow-md"
      @mouseenter="optionsAreaState = true"
      @mouseleave="optionsAreaState = false"
      v-if="
        store.getPlatformTabState('tiktok') && store.getActivePlatformContent('media')?.length > 0
      "
    >
      <label class="label mb-2 font-semibold"
        >Who can view this video <span class="text-red-600">(required)</span>
      </label>
      <select class="select" v-model="store.tiktokOptions.privacy_level">
        <option value="" disabled>Select Privacy</option>
        <option v-for="option in getTiktokUserOptions" :value="option" :key="option">
          {{ option.replace(/_/g, ' ') }}
        </option>
      </select>

      <div class="mt-3">
        <label class="label mb-2 font-semibold">Disable (optional)</label>
        <div class="flex">
          <div class="flex flex-1 items-center gap-2">
            <input
              type="checkbox"
              class="checkbox"
              id="comment"
              v-model="store.tiktokOptions.disable_comment"
            />
            <label class="label" for="comment"> Comment </label>
          </div>
          <template v-if="store.getActivePlatformContent('media_type') == 'video'">
            <div class="flex flex-1 items-center gap-2">
              <input
                type="checkbox"
                class="checkbox"
                id="duet"
                v-model="store.tiktokOptions.disable_duet"
              />
              <label class="label" for="duet"> Duet </label>
            </div>
            <div class="flex flex-1 items-center gap-2">
              <input
                type="checkbox"
                class="checkbox"
                id="stitch"
                v-model="store.tiktokOptions.disable_stitch"
              />
              <label class="label" for="stitch"> Stitch </label>
            </div>
          </template>
        </div>
      </div>
    </div>
  </div>
</template>
