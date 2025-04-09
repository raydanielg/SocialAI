<script setup>
import { defineAsyncComponent, onMounted } from 'vue'

import { storeToRefs } from 'pinia'

import BlankLayout from '@/Layouts/BlankLayout.vue'
import PlatformCard from '@/Pages/User/Publish/Partials/PlatformCard.vue'
import { usePublishAssetStore } from '@/Store/publishAssetStore'
import { usePublishStore } from '@/Store/publishStore'
import { Head } from '@inertiajs/vue3'

import Sidebar from './Partials/Sidebar.vue'
import TopHeader from './Partials/TopHeader.vue'

defineOptions({ layout: BlankLayout })
const store = usePublishStore()
const assetStore = usePublishAssetStore()
const { getTabState } = storeToRefs(store)

const props = defineProps([
  'content',
  'uploadedAssetImages',
  'generatedAssetImages',
  'uploadedAssetVideos',
  'generatedAssetVideos',
  'designs',
  'userPlatforms',
  'platforms',
  'isVideoPromptActive'
])

onMounted(() => {
  store.$reset()
  store.$patch({
    userPlatforms: props.userPlatforms,
    platforms: props.platforms,
    platformTab: props.platforms[0] ?? 'facebook'
  })
  store.setOriginalContent(props.content)
  assetStore.setAssets(
    props.generatedAssetImages,
    props.uploadedAssetImages,
    props.generatedAssetVideos,
    props.uploadedAssetVideos
  )
})

const ConnectTab = defineAsyncComponent(() => import('./Partials/Tabs/ConnectTab.vue'))
const InputTab = defineAsyncComponent(() => import('./Partials/Tabs/InputTab.vue'))
const TextTab = defineAsyncComponent(() => import('./Partials/Tabs/TextTab.vue'))
const ImagesTab = defineAsyncComponent(() => import('./Partials/Tabs/ImagesTab.vue'))
const VideosTab = defineAsyncComponent(() => import('./Partials/Tabs/VideosTab.vue'))
const DesignTab = defineAsyncComponent(() => import('./Partials/Tabs/DesignTab.vue'))
</script>

<template>
  <Head :title="trans('Publish')" />
  <div class="flex min-h-screen">
    <Sidebar />

    <div class="h-screen w-full overflow-y-auto px-3 lg:px-6">
      <!-- header -->
      <TopHeader />
      <!-- content -->
      <div
        class="gra mt-2 grid grid-cols-1 gap-y-8 lg:h-[calc(100%-6rem)] lg:grid-cols-12 lg:gap-x-8"
      >
        <div class="card styled-scrollbar col-span-5 h-full overflow-y-auto rounded-2xl p-5">
          <DesignTab v-if="getTabState('designs')" :designs="designs" />
          <InputTab v-if="getTabState('input')" />

          <TextTab v-if="getTabState('text')" />

          <ImagesTab
            v-if="getTabState('images')"
            :uploaded-asset-images="uploadedAssetImages?.data"
            :generated-asset-images="generatedAssetImages?.data"
          />
          <!-- video -->
          <VideosTab
            v-if="getTabState('videos')"
            :generated-videos="generatedAssetVideos?.data"
            :uploaded-videos="uploadedAssetVideos?.data"
            :isVideoPromptActive="isVideoPromptActive"
          />

          <ConnectTab v-if="getTabState('connect')" />
        </div>
        <div
          class="styled-scrollbar h-100 col-span-7 overflow-y-auto rounded-2xl bg-secondary-100 py-10 shadow-lg dark:bg-secondary-800/30"
        >
          <PlatformCard />
        </div>
      </div>
    </div>
  </div>
</template>
