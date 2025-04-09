<script setup>
import NoDataFound from "@/Components/Admin/NoDataFound.vue"
import Overview from "@/Components/Admin/OverviewGrid.vue"
import Pagination from "@/Components/Admin/Paginate.vue"
import sharedComposable from "@/Composables/sharedComposable"
import trans from "@/Composables/transComposable"
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue"
import PageHeader from "@/Layouts/Admin/PageHeader.vue"

defineOptions({ layout: AdminLayout })
const props = defineProps(['posts', 'countTotal', 'countUnpublished', 'countPublished'])

const { deleteRow, uiAvatar } = sharedComposable()

const stats = [
  { value: props.countTotal, title: trans('Total'), iconClass: 'bx:bar-chart' },
  {
    value: props.countPublished,
    title: trans('Published'),
    iconClass: 'bx:bar-chart'
  },
  {
    value: props.countUnpublished,
    title: trans('Unpublished'),
    iconClass: 'bx:bar-chart'
  }
]
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader />
    <div class="space-y-6">
      <Overview :items="stats" grid="3" />

      <div class="table-responsive whitespace-nowrap rounded-primary">
        <table class="table">
          <thead>
            <tr>
              <th>{{ trans('Title') }}</th>
              <th>{{ trans('Brand Name') }}</th>
              <th>{{ trans('Brand User') }}</th>
              <th>{{ trans('Media Type') }}</th>
              <th>{{ trans('Status') }}</th>
              <th>
                <p class="text-right">{{ trans('Action') }}</p>
              </th>
            </tr>
          </thead>
          <tbody v-if="posts.total">
            <tr v-for="(post, key) in posts.data" :key="key">
              <td>{{ post.title }}</td>
              <td>{{ post.brand?.name }}</td>
              <td>
                <div class="flex items-center gap-3" v-if="post.user">
                  <img class="h-10 rounded-full" :src="uiAvatar(post.user?.name, post.user?.avatar)" />
                  <div>
                    <Link :href="route('admin.users.show', post.user.id)" class="font-bold">
                    {{ post.user?.name }}
                    </Link>
                    <p>
                      {{ post.user?.email }}
                    </p>
                  </div>
                </div>
              </td>
              <td>{{ post.media_type }}</td>
              <td>
                <span class="badge" :class="{
                  'badge-primary': post.status == 'draft',
                  'badge-info': post.status == 'publish',
                  'badge-danger': post.status == 'scheduled',
                  'badge-success': post.status == 'published'
                }">
                  {{ post.status }}
                </span>
                <div>
                  <span v-if="post.is_schedule" class="badge badge-secondary">
                    <p>{{ post.scheduled_at }}</p>
                  </span>
                </div>
              </td>
              <td>
                <div class="dropdown" data-placement="bottom-start">
                  <div class="dropdown-toggle">
                    <Icon class="text-2xl" icon="bx:dots-horizontal-rounded" />
                  </div>
                  <div class="dropdown-content w-40">
                    <ul class="dropdown-list">
                      <li class="dropdown-list-item">
                        <button @click="deleteRow(route('admin.user-logs.brand-posts.destroy', post))"
                          class="dropdown-link">
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
          <NoDataFound v-else :for-table="true" />
        </table>
        <Pagination :links="posts.links" />
      </div>
    </div>
  </main>
</template>
