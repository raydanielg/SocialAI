<script setup>
import UserLayout from '@/Layouts/User/UserLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import NoDataFound from '@/Components/Admin/NoDataFound.vue'
import sharedComposable from '@/Composables/sharedComposable'
defineOptions({ layout: UserLayout })

const { deleteRow } = sharedComposable()
const props = defineProps(['buttons', 'platforms', 'activePlatforms'])
const disconnectPlatform = (platform) => {
  deleteRow(route('user.platforms.destroy', platform.id))
}
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader />
    <div
      class="mb-3 flex max-w-max items-center space-x-2 rounded-lg border bg-white p-1 dark:border-slate-600 dark:bg-slate-800"
    >
      <p class="ml-3">{{ trans('Connect') }}:</p>
      <template v-for="platform in activePlatforms" :key="platform">
        <Link
          :href="route(`connect.${platform}`)"
          class="btn py-3 hover:bg-gray-200 dark:hover:bg-gray-700 sm:px-8"
        >
          <img class="w-4" :src="`/assets/svg/${platform}.svg`" :alt="platform" />
        </Link>
      </template>
    </div>

    <div class="space-y-6">
      <div class="table-responsive whitespace-nowrap rounded-primary">
        <table class="table">
          <thead>
            <tr>
              <th>{{ trans('Platform') }}</th>
              <th>{{ trans('Details') }}</th>
              <th>{{ trans('Connected As') }}</th>
              <th class="!text-end">{{ trans('Action') }}</th>
            </tr>
          </thead>

          <tbody v-if="platforms.length">
            <tr v-for="platform in platforms" :key="platform">
              <td>
                <div class="flex items-center gap-2 text-left">
                  <i class="bx text-2xl" :class="`bxl-${platform.platform}`"></i>
                  <span class="text-xs capitalize">{{ platform.platform }}</span>
                </div>
              </td>
              <td>
                <div class="flex items-center gap-2">
                  <img
                    :src="platform.picture ?? '/assets/images/no-image.jpg'"
                    @error="(e) => (e.target.src = '/assets/images/no-image.jpg')"
                    class="h-10 w-10 rounded-full object-cover"
                  />
                  <span>
                    {{ platform.name }} <br />
                    <small v-if="platform.username">({{ platform.username }})</small>
                  </span>
                </div>
              </td>
              <td>
                <div
                  class="badge capitalize"
                  :class="{
                    'badge-primary': platform.type == 'user',
                    'badge-success': platform.type == 'page'
                  }"
                >
                  {{ platform.type }}
                </div>
              </td>
              <td>
                <div class="flex justify-end gap-1">
                  
                  <button
                    @click="disconnectPlatform(platform)"
                    type="submit"
                    class="btn btn-danger btn-xs"
                  >
                    <Icon icon="bx:bxs-x-circle" />
                    <span>{{ trans('Disconnect') }}</span>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
          <NoDataFound v-else for-table="true" />
        </table>
      </div>
    </div>
  </main>
</template>
