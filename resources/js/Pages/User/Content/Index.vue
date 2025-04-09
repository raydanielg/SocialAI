<script setup>
import { onMounted, ref } from 'vue'

import moment from 'moment'

import FilterDropdown from '@/Components/Admin/FilterDropdown.vue'
import Paginate from '@/Components/Admin/Paginate.vue'
import ContentCreateModal from '@/Components/User/ContentCreateModal.vue'
import CreatePostCard from '@/Components/User/CreatePostCard.vue'
import PostCard from '@/Components/User/PostCard.vue'
import sharedComposable from '@/Composables/sharedComposable'
import UserLayout from '@/Layouts/User/UserLayout.vue'
import { useModalStore } from '@/Store/modalStore'
import { Head, router } from '@inertiajs/vue3'

const { textExcerpt, getQueryParams, deleteRow } = sharedComposable()
const modal = useModalStore()

defineOptions({ layout: UserLayout })

const props = defineProps([
  'request',
  'hasBrand',
  'contents',
  'type',
  'items',
  'weekStartDate',
  'weekEndDate',
  'totalBrandPost',
  'brands'
])
const params = ref(getQueryParams()?.brand)
onMounted(() =>
  setTimeout(() => {
    if (params.value) modal.open('createContent')
  }, 500)
)

const activeTab = ref(getQueryParams()?.active_tab ?? 'calendar')

const startFromDate = (d) => {
  router.get(
    window.location.href,
    {
      start_at: d
    },
    {
      preserveState: true
    }
  )
}

const filterOptions = [
  {
    label: 'Title',
    value: 'title'
  },
  {
    label: 'Status',
    value: 'status',
    options: [
      {
        label: 'Draft',
        value: 'draft'
      },
      {
        label: 'Published',
        value: 'published'
      }
    ]
  }
]
</script>

<template>
  <ContentCreateModal :totalBrandPost="totalBrandPost" :brand_uuid="params" :brands="brands" />

  <Head :title="trans('Content')" />
  <main class="container flex-grow p-4 sm:p-6">
    <div class="mt-4 flex items-center justify-between">
      <div class="card max-w-max p-1">
        <button
          class="btn w-full px-12 py-2 md:w-auto"
          :class="{ 'btn-primary': activeTab === 'calendar' }"
          @click="activeTab = 'calendar'"
        >
          <Icon icon="fe:calendar" height="1rem" width="1rem"></Icon>
          <span>{{ trans('Calender') }}</span>
        </button>
        <button
          class="btn w-full px-12 py-2 md:w-auto"
          :class="{ 'btn-primary': activeTab === 'card' }"
          @click="activeTab = 'card'"
        >
          <Icon icon="fe:grid" height="1rem" width="1rem"></Icon>
          <span>{{ trans('Cards') }}</span>
        </button>
      </div>
      <div class="w-80">
        <FilterDropdown :options="filterOptions" :appends="{ active_tab: 'card' }" />
      </div>
    </div>

    <div class="mt-8">
      <!-- card -->
      <div v-if="activeTab === 'card'" class="bg-transparent">
        <!-- cards -->
        <div v-if="!hasBrand" class="alert alert-info flex justify-center gap-3">
          <span class="dark:text-white">{{ trans('You need to create a brand first') }}</span>
          <Link :href="route('user.brand.create')" class="btn btn-primary"> Create New Brand </Link>
        </div>
        <div v-else class="grid grid-cols-1 gap-12 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
          <CreatePostCard @action="modal.open('createContent')" />
          <PostCard v-for="content in contents.data" :content="content" :key="content.id" />
        </div>
        <Paginate :preserveState="true" :links="contents.links" />
      </div>
      <div class="card" v-if="activeTab === 'calendar'">
        <div v-if="!hasBrand" class="alert alert-info flex justify-center gap-3">
          <span class="dark:text-white">{{ trans('You need to create a brand first') }}</span>
          <Link :href="route('user.brand.create')" class="btn btn-primary"> Create New Brand </Link>
        </div>
        <div v-else class="card-body">
          <h5>{{ trans('Calendar') }}</h5>

          <div class="mt-5 flex gap-3">
            <button
              @click="startFromDate(moment(weekStartDate).days(-7).format('Y-M-D'))"
              class="btn rounded-lg border-dashed bg-slate-100 px-2 py-1 hover:bg-slate-200 dark:bg-slate-900 dark:hover:bg-gray-700"
            >
              <i class="bx bx-chevron-left text-2xl"></i>
            </button>
            <button
              @click="startFromDate(moment(weekEndDate).days(1).format('Y-M-D'))"
              class="btn rounded-lg border-dashed bg-slate-100 px-2 py-1 hover:bg-slate-200 dark:bg-slate-900 dark:hover:bg-gray-700"
            >
              <i class="bx bx-chevron-right text-2xl"></i>
            </button>
          </div>

          <div class="mt-5 flex flex-wrap items-start justify-evenly gap-2">
            <div
              class="w-48 flex-1 rounded-md border border-dashed border-green-500 bg-slate-50 p-1 text-center dark:bg-slate-900"
              v-for="date in items"
              :key="date.date"
            >
              <p class="mb-3">{{ date.date }}</p>
              <button
                @click="modal.open('createContent')"
                class="btn mb-1 whitespace-nowrap border border-dashed border-green-500 text-green-900 hover:bg-gray-700 dark:text-white"
              >
                {{ trans('Create New') }}
              </button>
              <div
                v-if="date.contents?.length"
                class="mt-1 rounded-lg bg-white p-1 text-sm dark:bg-slate-800"
              >
                <div
                  v-for="post in date.contents"
                  :key="post.id"
                  class="flex flex-col items-center justify-center rounded-lg border p-2 text-center dark:border-slate-600"
                >
                  <Link
                    :href="
                      post?.brandpost?.uuid ? route('user.publish', post?.brandpost?.uuid) : '#'
                    "
                  >
                    <img
                      v-lazy="post?.media?.[0] ?? '/assets/images/no-photo-available.png'"
                      @error="(e) => (e.target.src = '/assets/images/no-photo-available.png')"
                      class="h-full w-full rounded border"
                    />
                    <span>{{ textExcerpt(post.content, 15) }}</span>
                    <p>
                      Time:
                      {{ moment(post.scheduled_at).format('h:mm A') }}
                    </p>
                  </Link>
                  <!-- remove button -->
                  <button
                    @click="deleteRow(route('user.brand-post-platforms.removeSchedule', post))"
                    class="btn btn-soft-danger mt-2 w-full"
                  >
                    <i class="bx bx-trash"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>
