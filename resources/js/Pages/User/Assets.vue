<script setup>
import {
  computed,
  onMounted,
  ref,
} from "vue";

import FilterDropdown from "@/Components/Admin/FilterDropdown.vue";
import NoDataFound from "@/Components/Admin/NoDataFound.vue";
import Paginate from "@/Components/Admin/Paginate.vue";
import AssetCard from "@/Components/User/AssetCard.vue";
import CreatePostCard from "@/Components/User/CreatePostCard.vue";
import UserLayout from "@/Layouts/User/UserLayout.vue";
import {
  Head,
  useForm,
} from "@inertiajs/vue3";

defineOptions({ layout: UserLayout })
const props = defineProps(['request', 'assets', 'type'])
const activeTab = ref(props.request?.active_tab ?? '')
const assetUploadProgress = ref(0)
const assetInput = ref(null)

const form = useForm({
  image: '',
  video: ''
})
const filteredAssets = computed(() => {
  if (activeTab.value == 'uploads') {
    return props.assets.data.filter((asset) => asset.type === 'uploaded')
  }
  if (activeTab.value == 'ai') {
    return props.assets.data.filter((asset) => asset.type === 'generated')
  }
  return props.assets.data
})
const submit = (e) => {
  const file = e.target.files[0]
  const fileType = file.type

  if (fileType.startsWith('image/')) {
    form.image = file
  } else if (fileType.startsWith('video/')) {
    form.video = file
  } else {
    return
  }
  form.post(route('user.assets.store'), {
    onProgress: (progress) => {
      assetUploadProgress.value = progress.percentage
    },
    onFinish: () => {
      setTimeout(() => (assetUploadProgress.value = 0), 1000)
    }
  })
}
const filterOptions = [
  {
    label: 'File Size',
    value: 'file_size'
  },
  {
    label: 'Media Type',
    value: 'mime_type'
  }
]

</script>

<template>
  <Head :title="trans('Assets')" />
  <main class="container flex-grow p-4 sm:p-6">
    <div class="mt-4 flex items-start justify-between md:items-center">
      <div class="card max-w-max p-1">
        <button
          class="btn w-full px-14 py-2 md:w-auto"
          :class="{ 'btn-primary': activeTab === '' }"
          @click="activeTab = ''"
        >
          <span class="text-xs md:text-sm">All</span>
        </button>
        <button
          class="btn w-full px-14 py-2 md:w-auto"
          :class="{ 'btn-primary': activeTab === 'uploads' }"
          @click="activeTab = 'uploads'"
        >
          <span class="text-xs md:text-sm">Uploads</span>
        </button>
        <button
          class="btn w-full px-14 py-2 md:w-auto"
          :class="{ 'btn-primary': activeTab === 'ai' }"
          @click="activeTab = 'ai'"
        >
          <span class="text-xs md:text-sm">Ai Generated</span>
        </button>
      </div>
      <div class="w-80">
        <FilterDropdown :options="filterOptions" :appends="{ active_tab: activeTab }" :formOptions="{ preserveState: true }" />
      </div>
    </div>

    <div class="mt-8">
      <!-- card -->
      <div
        class="grid w-full grid-cols-1 gap-6 overflow-y-auto pb-8 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5"
      >
        <template v-if="activeTab === 'uploads'">
          <!-- cards -->
          <input ref="assetInput" @input="submit" accept="image/*,video/*" type="file" hidden />

          <CreatePostCard
            :percentage="assetUploadProgress"
            @action="assetInput.click()"
            classes="h-60"
            text="Upload New"
          />
          <AssetCard :assets="filteredAssets" />
        </template>
        <template v-if="activeTab === 'ai'">
          <AssetCard :assets="filteredAssets" />
        </template>
        <template v-if="activeTab === ''">
          <AssetCard :assets="filteredAssets" />
          <Paginate class="col-span-full" :links="assets.links" />
        </template>
      </div>
    </div>
    <NoDataFound v-if="filteredAssets.length < 1 && activeTab !== 'uploads'" />
  </main>
</template>
