<script setup>
import IntersectionObserver from '@/Components/User/IntersectionObserver.vue'
import CreatePostCard from '@/Components/User/CreatePostCard.vue'
import HollowDotsSpinner from '@/Components/HollowDotsSpinner.vue'
import { usePublishStore } from '@/Store/publishStore'
import { usePublishAssetStore } from '@/Store/publishAssetStore'
import { storeToRefs } from 'pinia'
import { ref } from 'vue'

defineProps(['generatedVideos', 'uploadedVideos', 'isVideoPromptActive'])

const store = usePublishStore()
const assetStore = usePublishAssetStore()
const { getVideosTabState } = storeToRefs(store)
const assetVideoInput = ref(null)
const uploadTargetView = ref(null)
const generatedTargetView = ref(null)
</script>

<template>
  <div
    class="grid max-w-max grid-cols-1 rounded-xl bg-secondary-200/50 p-1 dark:bg-secondary-900 lg:flex-row"
    :class="{ 'sm:grid-cols-3': isVideoPromptActive, 'sm:grid-cols-2': !isVideoPromptActive }"
  >
    <template v-for="tab in store.assetTabs" :key="tab">
      <button
        v-if="(tab === 'ai' && isVideoPromptActive) || tab !== 'ai'"
        class="btn px-12 py-2 capitalize 2xl:px-14"
        :class="{ 'btn-primary': getVideosTabState(tab) }"
        @click="store.setVideosTab(tab)"
      >
        {{ tab }}
      </button>
    </template>
  </div>
  <!-- uploads -->
  <template v-if="getVideosTabState('uploads')">
    <div class="mt-3 grid grid-cols-1 gap-4 overflow-y-auto sm:grid-cols-2">
      <input
        ref="assetVideoInput"
        @input="assetStore.submitAsset($event, 'video')"
        accept="video/*"
        type="file"
        hidden
      />
      <CreatePostCard
        @action="assetVideoInput.click()"
        :percentage="assetStore.assetUploadProgress"
        classes="h-44"
        text="Upload New"
      />
      <template v-if="assetStore.assets.uploadedVideos?.data.length > 0">
        <div
          v-for="video in assetStore.assets.uploadedVideos.data"
          :key="video.path"
          class="group relative h-44 overflow-hidden rounded-lg"
          :class="{
            'border-2 border-primary-500 shadow shadow-primary-500':
              store.getActivePlatformContent('media')?.includes(video.path)
          }"
        >
          <button
            @click="store.setPlatformMedia(video.path, 'uploads', 'video')"
            class="btn btn-sm btn-primary absolute right-1 top-2 z-50 h-8 w-8 rounded-full opacity-0 group-hover:opacity-100"
          >
            <i
              class="bx"
              :class="store.getActivePlatformContent('media')?.includes(video.path) ? 'bx-minus' : 'bx-plus'"
            ></i>
          </button>
          <video controls class="h-full w-full">
            <source :src="video.path" type="video/mp4" />
          </video>
        </div>
      </template>
    </div>
    <IntersectionObserver
      :target-view="uploadTargetView"
      :observer-condition="assetStore.assets.uploadedVideos.loadMore"
      :after-intersection="() => assetStore.loadMoreAssets('uploaded', 'Videos')"
      :loader="assetStore.assets.loading"
    />
  </template>

  <!-- ai -->
  <template v-if="getVideosTabState('ai') && isVideoPromptActive">
    <button
      :disabled="assetStore.loading.aiVideo"
      type="button"
      @click="assetStore.generateVideo"
      class="btn btn-soft-primary my-3 w-full"
    >
      <svg
        v-if="assetStore.loading.aiVideo"
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
      <i class="bx bx-refresh mt-0.5 text-2xl" v-else></i>
      <span>Generate</span>
    </button>

    <div class="grid grid-cols-2 gap-4 overflow-y-auto">
      <template v-if="assetStore.assets.generatedVideos.data?.length > 0">
        <div
          v-for="(video, i) in assetStore.assets.generatedVideos.data"
          :key="i"
          class="group relative h-44 overflow-hidden rounded-lg"
          :class="{
            'border border-primary-500 shadow shadow-primary-500':
              store.getActivePlatformContent('media')?.includes(video.path)
          }"
        >
          <button
            type="button"
            @click="store.setPlatformMedia(video.path, 'ai', 'video')"
            class="btn btn-sm btn-primary absolute right-1 top-2 z-50 h-8 w-8 rounded-full opacity-0 group-hover:opacity-100"
          >
            <i
              class="bx"
              :class="store.getActivePlatformContent('media')?.includes(video.path) ? 'bx-minus' : 'bx-plus'"
            ></i>
          </button>
          <video class="h-full w-full" controls>
            <source :src="video.path" type="video/mp4" />
          </video>
        </div>
      </template>
      <template v-if="assetStore.aiVideos?.length > 0">
        <div
          class="group relative h-44 overflow-hidden rounded-lg"
          :class="{
            'border border-primary-500 shadow shadow-primary-500':
              store.getActivePlatformContent('media')?.includes(store.aiVideos)
          }"
        >
          <button
            @click="store.setPlatformMedia(store.aiVideos, 'ai', 'video')"
            class="btn btn-sm btn-primary absolute right-1 top-2 z-50 h-8 w-8 rounded-full opacity-0 group-hover:opacity-100"
          >
            <i
              class="bx"
              :class="store.getActivePlatformContent('media')?.includes(store.aiVideos) ? 'bx-minus' : 'bx-plus'"
            ></i>
          </button>
          <video
            class="h-full w-full"
            controls
            @click="store.setPlatformMedia(store.aiVideos, 'ai', 'video')"
          >
            <source :src="assetStore.aiVideos" type="video/mp4" />
          </video>
        </div>
      </template>
      <IntersectionObserver
        :target-view="generatedTargetView"
        :observer-condition="assetStore.assets.generatedVideos.loadMore"
        :after-intersection="() => assetStore.loadMoreAssets('generated', 'Videos')"
        :loader="assetStore.assets.loading"
      />
    </div>
    <p
      v-if="
        assetStore.isStockVideosFetched &&
        !assetStore.loading.aiVideo &&
        assetStore.aiVideos.length < 1
      "
      class="text-center"
    >
      {{ trans('Nothing Found!') }}
    </p>
  </template>
  <!-- stock -->
  <template v-if="getVideosTabState('stock')">
    <label class="label mb-1 mt-4">Search</label>
    <div class="mb-5 flex gap-x-2">
      <input
        type="text"
        v-model="assetStore.videoSearchQuery"
        class="input"
        placeholder="Search videos.."
      />
      <button
        :disabled="assetStore.videoSearchQuery.length < 2"
        type="button"
        @click="assetStore.stockVideoSearch"
        class="btn btn-soft-primary text-xl"
      >
        <i class="bx bx-search-alt"></i>
      </button>
    </div>
    <div class="flex justify-center" v-if="assetStore.loading.stockVideos">
      <HollowDotsSpinner />
    </div>
    <div
      v-if="!assetStore.loading.stockVideos && assetStore.stockVideos?.length > 0"
      class="grid grid-cols-2 gap-4 overflow-y-auto"
    >
      <div
        v-for="video in assetStore.stockVideos"
        :key="video.id"
        class="group relative h-44 overflow-hidden rounded-lg"
        :class="{
          'border border-primary-500 shadow shadow-primary-500':
            store.getActivePlatformContent('media')?.includes(video.link)
        }"
      >
        <button
          @click="store.setPlatformMedia(video.link, 'stock', 'video')"
          class="btn btn-sm btn-primary absolute right-1 top-2 z-50 h-8 w-8 rounded-full opacity-0 group-hover:opacity-100"
        >
          <i
            class="bx"
            :class="store.getActivePlatformContent('media')?.includes(video.link) ? 'bx-minus' : 'bx-plus'"
          ></i>
        </button>
        <video class="h-full w-full" controls>
          <source :src="video.link" type="video/mp4" />
        </video>
      </div>
    </div>
    <p
      v-if="
        assetStore.isStockVideosFetched &&
        !assetStore.loading.stockVideos &&
        assetStore.stockVideos.length < 1
      "
      class="text-center"
    >
      Nothing Found!
    </p>
  </template>
</template>
