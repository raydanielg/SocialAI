<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import NoDataFound from '@/Components/Admin/NoDataFound.vue'
import trans from '@/Composables/transComposable'
import sharedComposable from '@/Composables/sharedComposable'
defineOptions({ layout: AdminLayout })

const { deleteRow } = sharedComposable()
const props = defineProps(['countTotal', 'platforms'])

const disconnectPlatform = (platform) => {
  deleteRow(route('admin.user-logs.platforms.destroy', platform.id))
}
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader />
    <div class="space-y-6">
      <div class="table-responsive whitespace-nowrap rounded-primary">
        <table class="table">
          <thead>
            <tr>
              <th>{{ trans('User') }}</th>
              <th>{{ trans('Platform') }}</th>
              <th>{{ trans('Account') }}</th>
              <th>{{ trans('Connected As') }}</th>
              <th class="!text-end">{{ trans('Action') }}</th>
            </tr>
          </thead>

          <tbody v-if="platforms.total">
            <tr v-for="platform in platforms.data" :key="platform">
              <td>
                <div class="flex items-center gap-3" v-if="platform.user">
                  <img class="h-10 rounded-full" :src="platform.user?.avatar == null
                    ? `https://ui-avatars.com/api/?name=${platform.user?.name}`
                    : `${platform.user?.avatar}`
                    " />
                  <div>
                    <a :href="`/admin/users/${platform.user.id}`" class="font-bold">
                      {{ platform.user?.name }}
                    </a>
                    <p>
                      {{ platform.user?.email }}
                    </p>
                  </div>
                </div>
              </td>
              <td>
                <div class="ml-3 text-left">
                  <i class="bx text-2xl" :class="`bxl-${platform.platform}`"></i>
                </div>
              </td>

              <td>
                <div class="flex items-center gap-2">
                  <img :src="platform.picture ?? '/assets/images/no-image.jpg'"
                    @error="(e) => (e.target.src = '/assets/images/no-image.jpg')" class="h-10" />
                  <span>
                    {{ platform.name }} <br />
                    <small v-if="platform.username">({{ platform.username }})</small>
                  </span>
                </div>
              </td>
              <td>{{ platform.type }}</td>
              <td class="!text-end">
                <button @click="disconnectPlatform(platform)" type="submit" class="btn btn-danger btn-xs">
                  Disconnect
                </button>
              </td>
            </tr>
          </tbody>
          <NoDataFound v-else for-table="true" />
        </table>
      </div>
    </div>
  </main>
</template>
