<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import Paginate from '@/Components/Admin/Paginate.vue'
import NoDataFound from '@/Components/Admin/NoDataFound.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import Overview from '@/Components/Admin/OverviewGrid.vue'
import sharedComposable from '@/Composables/sharedComposable'
import trans from '@/Composables/transComposable'
defineOptions({ layout: AdminLayout })
const props = defineProps(['assets'])

const { deleteRow, uiAvatar } = sharedComposable()
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader />
    <div class="space-y-6">
      <div class="table-responsive whitespace-nowrap rounded-primary">
        <table class="table">
          <thead>
            <tr>
              <th>{{ trans('Asset') }}</th>
              <th>{{ trans('User') }}</th>
              <th>{{ trans('Type') }}</th>
              <th>{{ trans('Media Type') }}</th>
              <th>{{ trans('Size') }}</th>
              <th>
                <p class="text-right">{{ trans('Action') }}</p>
              </th>
            </tr>
          </thead>
          <tbody v-if="assets.total">
            <tr v-for="(asset, key) in assets.data" :key="key">
              <td>
                <a v-if="asset.mime_type == 'image'" :href="asset.path" target="_blank">
                  <img :src="asset.path" class="h-14 rounded-lg" alt="" />
                </a>
                <a v-if="asset.mime_type == 'video'" :href="asset.path" target="_blank">
                  <video class="h-14 w-24">
                    <source :src="asset.path" type="video/mp4" />
                  </video>
                </a>
                <a v-if="asset.mime_type == 'audio'" :href="asset.path" target="_blank">
                  <audio class="w-full">
                    <source :src="asset.path" type="audio/wav" />
                    <source :src="asset.path" type="audio/mp3" />
                    Your browser does not support the audio element.
                  </audio>
                </a>
              </td>
              <td>
                <div class="flex items-center gap-3" v-if="asset.user">
                  <img class="h-10 rounded-full" :src="uiAvatar(asset.user?.name, asset.user?.avatar)" />
                  <div>
                    <Link :href="route('admin.users.show', asset.user.id)" class="font-bold">
                    {{ asset.user?.name }}
                    </Link>
                    <p>
                      {{ asset.user?.email }}
                    </p>
                  </div>
                </div>
              </td>
              <td>{{ asset.type }}</td>
              <td>{{ asset.mime_type }}</td>
              <td>{{ asset.file_size }} MB</td>
              <td>
                <div class="dropdown" data-placement="bottom-start">
                  <div class="dropdown-toggle">
                    <Icon class="text-2xl" icon="bx:dots-horizontal-rounded" />
                  </div>
                  <div class="dropdown-content w-40">
                    <ul class="dropdown-list">
                      <li class="dropdown-list-item">
                        <button @click="deleteRow(route('admin.user-logs.assets.destroy', asset))"
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
        <Paginate :links="assets.links" />
      </div>
    </div>
  </main>
</template>
