<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader :title="trans('How it works')" :buttons="buttons" />
    <div class="space-y-6">
      <div class="table-responsive whitespace-normal rounded-primary">
        <table class="table">
          <thead>
            <tr>
              <th class="">{{ trans('Title') }}</th>
              <th class="">{{ trans('Description') }}</th>
              <th class="text-right">{{ trans('Language') }}</th>
              <th class="text-right">{{ trans('Action') }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="post in posts.data" :key="post.id">
              <td class="flex">
                <img :src="post.preview.value" class="avatar rounded-circle mr-3" />
                <span> {{ textExcerpt(post.title, 30) }}</span>
              </td>
              <td class="text-left">
                {{ textExcerpt(post.excerpt.value, 50) }}
              </td>
              <td class="text-right">
                {{ post.lang }}
              </td>
              <td>
                <div class="dropdown" data-placement="bottom-start">
                  <div class="dropdown-toggle">
                    <Icon class="text-2xl" icon="bx:dots-horizontal-rounded" />
                  </div>
                  <div class="dropdown-content w-40">
                    <ul class="dropdown-list">
                      <li class="dropdown-list-item">
                        <Link :href="route('admin.features.edit', post.id)" class="dropdown-link">
                           <Icon icon="fe:edit" />
                          <span>{{ trans('Edit') }}</span>
                        </Link>
                      </li>

                      <li class="dropdown-list-item">
                        <Link
                          as="button"
                          class="dropdown-link"
                          @click="deleteRow('/admin/features/' + post.id)"
                        >
                          <Icon icon="fe:trash" />
                          <span>{{ trans('Delete') }}</span>
                        </Link>
                      </li>
                    </ul>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="card-footer py-4">
          <Paginate
            :links="posts.links"
            :currentPage="posts.current_page"
            :from="posts.from"
            :lastPage="posts.last_page"
            :lastPageUrl="posts.last_page_url"
            :nextpageurl="posts.next_page_url"
            :perPage="posts.per_page"
            :prevPageUrl="posts.prev_page_url"
            :to="posts.to"
            :total="posts.total"
          />
        </div>
      </div>
    </div>
  </main>
</template>

<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import { Head } from '@inertiajs/vue3'

import sharedComposable from '@/Composables/sharedComposable'
const props = defineProps(['posts', 'segments', 'buttons'])
const { textExcerpt, deleteRow } = sharedComposable()
defineOptions({ layout: AdminLayout })
</script>
@/Composables/sharedComposable
