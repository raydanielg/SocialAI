<script setup>
import CreatePostCard from '@/Components/User/CreatePostCard.vue'
import HollowDotsSpinner from '@/Components/HollowDotsSpinner.vue'
import IntersectionObserver from '@/Components/User/IntersectionObserver.vue'
import { usePublishStore } from '@/Store/publishStore'
import { usePublishAssetStore } from '@/Store/publishAssetStore'
import { storeToRefs } from 'pinia'
import { ref } from 'vue'

defineProps(['uploadedAssetImages', 'generatedAssetImages'])

const store = usePublishStore()
const assetStore = usePublishAssetStore()
const { getImagesTabState } = storeToRefs(store)
const assetImageInput = ref(null)

const uploadTargetView = ref(null)
const generatedTargetView = ref(null)

function removeLink(link) {
  const index = store.getActivePlatformContent('media').indexOf(link)
  if (index > -1) {
    store.getActivePlatformContent('media').splice(index, 1)
  }
}
</script>

<template>
  <div
    class="grid max-w-max grid-cols-1 rounded-xl bg-secondary-200/50 p-1 dark:bg-secondary-900 sm:grid-cols-3 lg:flex-row">
    <template v-for="tab in store.assetTabs" :key="tab">
      <button class="btn px-12 py-2 capitalize 2xl:px-14" :class="{ 'btn-primary': getImagesTabState(tab) }"
        @click="store.setImagesTab(tab)">
        {{ tab }}
      </button>
    </template>
  </div>
  <div class="mb-6 mt-2 flex flex-wrap gap-4 border-b pb-5 dark:border-gray-700"
    v-if="store.getActivePlatformContent('media_type') == 'image' && store.getActivePlatformContent('media')?.length > 0">
    <label class="label col-span-full w-full font-semibold">Selected Images</label>
    <div v-for="image in store.getActivePlatformContent('media') || []" :key="image"
      class="relative h-24 w-24 overflow-hidden rounded-lg">
      <img v-lazy="image" class="h-full w-full object-cover" alt="image" />
      <button @click="removeLink(image)" type="button"
        class="btn btn-sm btn-danger absolute right-1 top-1 z-50 h-6 w-6 rounded-full">
        <i class="bx bx-trash text-xs"></i>
      </button>
    </div>
  </div>
  <!-- uploads -->
  <template v-if="getImagesTabState('uploads')">
    <div class="mt-3 grid grid-cols-2 gap-4 overflow-y-auto md:grid-cols-3">
      <input ref="assetImageInput" @input="assetStore.submitAsset($event, 'image')" accept="image/*" type="file"
        hidden />
      <CreatePostCard @action="assetImageInput.click()" :percentage="assetStore.assetUploadProgress" classes="h-44"
        text="Upload New" />
      <template v-if="assetStore.assets.uploadedImages?.data.length > 0">
        <div @click="store.setPlatformMedia(image.path, 'uploads')"
          v-for="(image, i) in assetStore.assets.uploadedImages.data" :key="i" :class="{
            'border-2 border-primary-500 shadow shadow-primary-500': store
              .getActivePlatformContent('media')
              ?.includes(image.path)
          }" class="h-44 overflow-hidden rounded-lg">
          <img v-lazy="image.path" class="h-full w-full object-contain" alt="" />
        </div>
      </template>
    </div>
    <IntersectionObserver :target-view="uploadTargetView"
      :observer-condition="assetStore.assets.uploadedImages.loadMore"
      :after-intersection="() => assetStore.loadMoreAssets('uploaded', 'Images')" :loader="assetStore.assets.loading" />
  </template>
  <!-- stock -->
  <template v-if="getImagesTabState('stock')">
    <label class="label mb-1 mt-4">Search</label>
    <div class="mb-5 flex gap-x-2">
      <input type="text" v-model="assetStore.imageSearchQuery" class="input" placeholder="Search images.." />
      <button :disabled="assetStore.imageSearchQuery.length < 2" type="button" @click="assetStore.stockImageSearch"
        class="btn btn-soft-primary text-xl">
        <i class="bx bx-search-alt"></i>
      </button>
    </div>

    <div class="flex justify-center" v-if="assetStore.loading.stockImages">
      <HollowDotsSpinner />
    </div>
    <div v-if="!assetStore.loading.stockImages && assetStore.stockImages?.length > 0"
      class="grid grid-cols-3 gap-4 overflow-y-auto">
      <div v-for="image in assetStore.stockImages" :key="image.id"
        @click="store.setPlatformMedia(image.urls.full, 'stock')" :class="{
          'border-2 border-primary-500 shadow shadow-primary-500': store
            .getActivePlatformContent('media')
            ?.includes(image.urls.full)
        }" class="h-44 overflow-hidden rounded-lg">
        <img v-lazy="image.urls.small" class="h-full w-full object-cover" alt="" />
      </div>
    </div>
    <p v-if="
      assetStore.isStockImagesFetched &&
      !assetStore.loading.stockImages &&
      assetStore.stockImages?.length < 1
    " class="text-center">
      {{ trans('Nothing Found!') }}
    </p>
  </template>
  <!-- ai images -->
  <template v-if="getImagesTabState('ai')">
    <button :disabled="assetStore.loading.aiImages" type="button" @click="assetStore.generateImage"
      class="btn btn-primary my-3 w-full">
      <svg v-if="assetStore.loading.aiImages" class="my-1.5 mr-px h-5 w-5 animate-spin text-white"
        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor"
          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
        </path>
      </svg>
      <i class="bx bx-refresh mt-0.5 text-2xl" v-else></i>
      <span>Generate</span>
    </button>

    <div class="grid grid-cols-3 gap-4 overflow-y-auto">
      <template v-if="assetStore.assets.generatedImages?.data.length > 0">
        <div v-for="image in assetStore.assets.generatedImages.data" :key="image.path"
          @click="store.setPlatformMedia(image.path, 'ai')" class="h-44 overflow-hidden rounded-lg" :class="{
            'border-2 border-primary-500 shadow shadow-primary-500': store
              .getActivePlatformContent('media')
              ?.includes(image.path)
          }">
          <img v-lazy="image.path" class="h-full w-full object-cover" alt="" />
        </div>
      </template>
    </div>
    <IntersectionObserver :target-view="generatedTargetView"
      :observer-condition="assetStore.assets.generatedImages.loadMore"
      :after-intersection="() => assetStore.loadMoreAssets('generated', 'Images')"
      :loader="assetStore.assets.loading" />
    <p v-if="
      assetStore.isAiImageFetched &&
      !assetStore.loading.aiImages &&
      assetStore.aiImages.length < 1
    " class="text-center">
      Nothing Found!
    </p>
  </template>
</template>
