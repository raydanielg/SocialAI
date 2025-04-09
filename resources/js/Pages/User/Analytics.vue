<script setup>
import { computed } from "vue";

import moment from "moment";

import FilterDropdown from "@/Components/Admin/FilterDropdown.vue";
import NoDataFound from "@/Components/Admin/NoDataFound.vue";
import Paginate from "@/Components/Admin/Paginate.vue";
import sharedComposable from "@/Composables/sharedComposable";
import PageHeader from "@/Layouts/Admin/PageHeader.vue";
import UserLayout from "@/Layouts/User/UserLayout.vue";

const { textExcerpt } = sharedComposable()

defineOptions({ layout: UserLayout })

const props = defineProps([
  'buttons',
  'request',
  'posts',
  'type',
  'totalPost',
  'totalReactions',
  'totalComments'
])

const filterOptions = [
  {
    label: 'Content',
    value: 'content'
  },
  {
    label: 'Platform',
    value: 'platform',
    options: [
      {
        label: 'Facebook',
        value: 'facebook'
      },
      {
        label: 'Twitter',
        value: 'twitter'
      },
      {
        label: 'Instagram',
        value: 'instagram'
      },
      {
        label: 'Linkedin',
        value: 'linkedin'
      },
      {
        label: 'tiktok',
        value: 'tiktok'
      }
    ]
  }
]

const primaryOverview = computed(() => {
  return [
    {
      title: 'Total Posts',
      value: props.totalPost,
      icon: 'bx bx-bar-chart-alt-2',
      classes: 'bg-primary-500 text-primary-500'
    },
    {
      title: 'Total Reactions',
      value: props.totalReactions,
      icon: 'bx bx-like',
      classes: 'text-success-500 bg-success-500'
    },
    {
      title: 'Total Comments',
      value: props.totalComments,
      icon: 'bx bx-comment-detail',
      classes: 'text-warning-500 bg-warning-500'
    }
  ]
})
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader title="Analytics" :buttons="buttons" />
    <div class="space-y-6">
      <section class="grid grid-cols-1 gap-8 sm:grid-cols-2 xl:grid-cols-3">
        <template v-for="(item, index) in primaryOverview" :key="index">
          <div class="card rounded-2xl">
            <div class="flex items-center gap-3 p-5">
              <div
                class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-opacity-10"
                :class="item.classes"
              >
                <i class="text-2xl" :class="item.icon"></i>
              </div>
              <div class="flex flex-1 flex-col">
                <p class="text-sm tracking-wide text-slate-500">
                  {{ item.title }}
                </p>
                <h5>{{ item.value }}</h5>
              </div>
            </div>
          </div>
        </template>
      </section>

      <div class="flex items-center justify-between gap-2">
        <Link
          class="btn btn-sm btn-primary text-center"
          :href="route('user.analytics.index', { refresh: true })"
        >
          <Icon icon="bx:refresh" class="text-lg" />
          <span>{{ trans('Refresh Analytics') }}</span>
        </Link>

        <div class="ml-auto w-80">
          <FilterDropdown :options="filterOptions" />
        </div>
      </div>

      <div class="table-responsive whitespace-nowrap rounded-primary">
        <table class="table">
          <thead>
            <tr>
              <th>{{ trans('Platform') }}</th>
              <th>{{ trans('Content') }}</th>
              <th>{{ trans('Publish Date') }}</th>
              <th>
                {{ trans('Reactions') }}
              </th>
              <th>{{ trans('Comments') }}</th>
            </tr>
          </thead>

          <tbody v-if="posts.total">
            <tr v-for="post in posts.data" :key="post.id">
              <td>
                <img :src="`/assets/svg/${post.platform}.svg`" class="h-6" />
              </td>
              <td>
                <div class="flex items-center gap-2">
                 
                  <img
                    :src="post.brand_post?.media?.[0] ?? '/assets/images/no-photo-available.png'"
                    @error="(e) => (e.target.src = '/assets/images/no-photo-available.png')"
                    class="h-8 rounded border"
                  />
                  {{ textExcerpt(post.content, 50) }}
                </div>
              </td>
              <td>
                {{ moment(post.published_at).format('DD MMM, YYYY h:mm A') }}
              </td>
              <td>
                <div v-if="post.platform == 'linkedin'" class="badge badge-info">{{ trans('not supported') }}</div>
                <span
                  v-else
                  class="text-md rounded-full border bg-gray-100 px-3 py-1 dark:border-gray-400 dark:bg-gray-700 dark:text-white"
                >
                  <i class="bx bx-like"></i>
                  {{ post.reactions }}
                </span>
              </td>
              <td>
                <div v-if="post.platform == 'linkedin'" class="badge badge-info">{{ trans('not supported') }}</div>
                <span
                  v-else
                  class="text-md rounded-full border bg-gray-100 px-3 py-1 dark:border-gray-400 dark:bg-gray-700 dark:text-white"
                >
                  <i class="bx bx-comment"></i>
                  {{ post.comments }}
                </span>
              </td>
            </tr>
          </tbody>
          <NoDataFound v-else for-table="true" />
        </table>

        <Paginate :links="posts.links" />
      </div>
    </div>
  </main>
</template>
