<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import sharedComposable from '@/Composables/sharedComposable'
import Paginate from '@/Components/Admin/Paginate.vue'
import Overview from '@/Components/Admin/OverviewGrid.vue'
import trans from '@/Composables/transComposable'
defineOptions({ layout: AdminLayout })
const { textExcerpt, deleteRow } = sharedComposable()
const props = defineProps(['pages', 'totalActivePosts', 'totalInActivePosts', 'totalPosts'])
const pageStats = [
  {
    value: props.totalPosts,
    title: trans('Total Page'),
    iconClass: 'bx:bar-chart'
  },
  {
    value: props.totalActivePosts,
    title: trans('Active Page'),
    iconClass: 'bx:check-circle'
  },
  {
    value: props.totalInActivePosts,
    title: trans('Inactive Page'),
    iconClass: 'bx:x-circle'
  }
]
</script>

<template>
  <main class="container p-4 sm:p-6">
    <PageHeader />
    <div class="space-y-6">
      <Overview :items="pageStats" grid="3" />

      <div class="table-responsive whitespace-nowrap rounded-primary">
        <table class="table">
          <thead>
            <tr>
              <th>{{ trans('Title') }}</th>
              <th>{{ trans('Url') }}</th>
              <th>{{ trans('Status') }}</th>
              <th>{{ trans('Created At') }}</th>
              <th class="!text-right">{{ trans('Action') }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="page in pages.data" :key="page.id">
              <td class="text-left">
                {{ textExcerpt(page.title, 50) }}
              </td>
              <td class="text-left">
                <a :href="sanitizeHtml(page.posturl)" target="_blank" class="hover:text-primary-400 hover:underline">
                  {{ textExcerpt(page.posturl, 100) }}
                </a>
              </td>

              <td class="text-left">
                <span class="badge" :class="page.status == 1 ? 'badge-success' : 'badge-danger'">
                  {{ page.status == 1 ? trans('Active') : trans('Draft') }}
                </span>
              </td>
              <td>
                {{ page.created_at_diff }}
              </td>

              <td>
                <div class="dropdown" data-placement="bottom-start">
                  <div class="dropdown-toggle">
                    <Icon class="text-2xl" icon="bx:dots-horizontal-rounded" />
                  </div>
                  <div class="dropdown-content w-40">
                    <ul class="dropdown-list">
                      <li class="dropdown-list-item">
                        <Link :href="route('admin.page.edit', page.id)" class="dropdown-link">
                        <Icon icon="fe:edit" />
                        <span>{{ trans('Edit') }}</span>
                        </Link>
                      </li>

                      <li class="dropdown-list-item">
                        <button as="button" class="dropdown-link"
                          @click="deleteRow(route('admin.page.destroy', page.id))">
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

        <Paginate :links="pages.links" />
      </div>
    </div>
  </main>
</template>
