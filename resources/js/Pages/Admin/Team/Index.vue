<template>
  <main class="flex-grow p-4 sm:p-6">
    <PageHeader title="Team" :buttons="buttons" />
    <div class="space-y-6">
      <OverviewGrid :items="teamStats" grid="3" />

      <div class="table-responsive whitespace-nowrap rounded-primary">
        <table class="table">
          <thead>
            <tr>
              <th>{{ trans('Name') }}</th>
              <th>{{ trans('Position') }}</th>

              <th class="text-right">{{ trans('Status') }}</th>
              <th class="flex justify-end">{{ trans('Action') }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="post in posts.data" :key="post.id">
              <td class="flex items-center gap-2">
                <img :src="post.preview.value" class="avatar rounded-square mr-3" />
                {{ textExcerpt(post.title, 50) }}
              </td>
              <td class="text-left">
                {{ textExcerpt(post.slug, 50) }}
              </td>

              <td class="text-right">
                <span class="badge" :class="post.status == 1 ? 'badge-success' : 'badge-danger'">
                  {{ post.status == 1 ? trans('Active') : trans('Draft') }}
                </span>
              </td>

              <td>
                <div class="dropdown" data-placement="bottom-start">
                  <div class="dropdown-toggle">
                    <Icon class="text-2xl" icon="bx:dots-horizontal-rounded" />
                  </div>
                  <div class="dropdown-content w-40">
                    <ul class="dropdown-list">
                      <li class="dropdown-list-item">
                        <Link :href="route('admin.team.edit', post.id)" class="dropdown-link">
                        <Icon icon="fe:edit" />
                        <span>{{ trans('Edit') }}</span>
                        </Link>
                      </li>

                      <li class="dropdown-list-item">
                        <button type="button" class="dropdown-link"
                          @click="deleteRow(route('admin.team.destroy', post.id))">
                          <Icon icon="fe:trash" />
                          <span>{{ trans('Delete') }}</span>
                        </button>
                      </li>
                    </ul>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
        <Alert v-if="posts.data.length == 0" type="info" :text="trans('Opps you have not created any plan....')" />
      </div>

      <Pagination v-if="posts.data.length != 0" :links="posts.links" />
    </div>
  </main>
</template>

<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import sharedComposable from '@/Composables/sharedComposable'
import OverviewGrid from '@/Components/Admin/OverviewGrid.vue'
import Alert from '@/Components/Admin/NoDataFound.vue'
import Pagination from '@/Components/Admin/Paginate.vue'
import { Link } from '@inertiajs/vue3'
import trans from '@/Composables/transComposable'
defineOptions({ layout: AdminLayout })
const { textExcerpt, deleteRow } = sharedComposable()

const props = defineProps([
  'posts',
  'buttons',
  'totalMembers',
  'totalActiveMembers',
  'totalInActiveMembers'
])

const teamStats = [
  { value: props.totalMembers, title: trans('Total Members'), iconClass: 'bx:user-pin' },
  {
    value: props.totalActiveMembers,
    title: trans('Active Members'),
    iconClass: 'bx:check-circle'
  },
  {
    value: props.totalInActiveMembers,
    title: trans('Expired Members'),
    iconClass: 'bx:x-circle'
  }
]
</script>
