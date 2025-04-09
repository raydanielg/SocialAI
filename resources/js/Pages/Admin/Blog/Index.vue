<script setup>
import moment from 'moment'

import Alert from '@/Components/Admin/NoDataFound.vue'
import Filter from '@/Components/Admin/Filter.vue'
import NoDataFound from '@/Components/Admin/NoDataFound.vue'
import Overview from '@/Components/Admin/OverviewGrid.vue'
import Paginate from '@/Components/Admin/Paginate.vue'
import sharedComposable from '@/Composables/sharedComposable'
import trans from '@/Composables/transComposable'
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import { Link, useForm } from '@inertiajs/vue3'

defineOptions({ layout: AdminLayout })
const { textExcerpt, deleteRow } = sharedComposable()
const props = defineProps([
  'posts',
  'totalPosts',
  'totalActivePosts',
  'totalInActivePosts',
  'buttons',

  'type',
  'request'
])

const blogsStats = [
  {
    value: props.totalPosts,
    title: trans('Total Posts'),
    iconClass: 'bx:bar-chart'
  },
  {
    value: props.totalActivePosts,
    title: trans('Total Active Posts'),
    iconClass: 'bx:check-circle'
  },
  {
    value: props.totalInActivePosts,
    title: trans('Total Inactive Posts'),
    iconClass: 'bx:x-circle'
  }
]

const filterData = useForm({
  search: props.request.search
})
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader title="Create a blog post" :buttons="buttons" />
    <div class="space-y-6">
      <!-- Overview Section Start -->
      <Overview :items="blogsStats" grid="3" />
      <!-- Overview Section End -->

      <div class="flex items-center justify-end gap-x-2">
        <div class="dropdown" data-placement="bottom-end">
          <div class="dropdown-toggle">
            <button type="button" class="btn bg-white font-medium shadow-sm dark:bg-slate-800">
              <Icon icon="fe:filter" />
              <span>{{ trans('Filter') }}</span>
              <Icon icon="bx:chevron-down" />
            </button>
          </div>

          <div class="dropdown-content w-72 !overflow-visible">
            <form @submit.prevent="filterData.get(route('admin.blog.index'))">
              <ul class="dropdown-list space-y-4 p-4">
                <li class="dropdown-list-item">
                  <h2 class="my-1 text-sm font-medium">
                    {{ trans('Status') }}
                  </h2>
                  <div class="mb-2">
                    <input type="text" name="search" v-model="filterData.search" class="input"
                      placeholder="Search......" />
                  </div>
                </li>
                <li class="dropdown-list-item">
                  <button type="submit" class="btn btn-primary w-full">
                    {{ trans('Filter') }}
                  </button>
                </li>
              </ul>
            </form>
          </div>
        </div>
      </div>

      <!-- Customer Table Starts -->
      <div class="table-responsive whitespace-nowrap rounded-primary">
        <table class="table">
          <thead>
            <tr>
              <th class="col-3">{{ trans('Title') }}</th>

              <th class="col-1">{{ trans('Status') }}</th>
              <th class="col-2">{{ trans('Created At') }}</th>
              <th class="col-1">
                <div class="text-right">{{ trans('Action') }}</div>
              </th>
            </tr>
          </thead>
          <tbody v-if="posts.data != 0">
            <tr v-for="blog in posts.data" :key="blog.id">
              <td class="flex">
                <img :src="blog.preview.value" class="avatar rounded-square mr-3" />
                <p>{{ textExcerpt(blog.title, 80) }}</p>
              </td>

              <td class="text-left">
                <span class="badge" :class="blog.status == 1 ? 'badge-success' : 'badge-danger'">
                  {{ blog.status == 1 ? trans('Active') : trans('Draft') }}
                </span>
              </td>
              <td>
                {{ moment(blog.created_at).format('D-MMM-Y') }}
              </td>
              <td>
                <div class="flex justify-end">
                  <div class="dropdown" data-placement="bottom-start">
                    <div class="dropdown-toggle">
                      <Icon class="text-2xl" icon="bx:dots-horizontal-rounded" />
                    </div>
                    <div class="dropdown-content w-40">
                      <ul class="dropdown-list">
                        <li class="dropdown-list-item">
                          <Link :href="route('admin.blog.edit', blog.id)" class="dropdown-link">
                          <Icon icon="fe:edit" />
                          <span>{{ trans('Edit') }}</span>
                          </Link>
                        </li>

                        <li class="dropdown-list-item">
                          <button class="dropdown-link" @click="
                            deleteRow(
                              route('admin.blog.destroy', blog.slug),
                              trans('Blog has been deleted successfully')
                            )
                            ">
                            <Icon icon="fe:trash" />
                            <span>{{ trans('Delete') }}</span>
                          </button>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
          <NoDataFound v-else for-table="true" />
        </table>

        <Paginate v-if="posts.data.length != 0" :links="posts.links" />
      </div>
      <!-- Customer Table Ends -->
    </div>
  </main>
</template>
