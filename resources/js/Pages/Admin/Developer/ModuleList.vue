<script setup>
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import NoDataFound from '@/Components/Admin/NoDataFound.vue'
import FloatingDropdown from '@/Components/Admin/FloatingDropdown.vue'
import sharedComposable from '@/Composables/sharedComposable'
import { useForm } from '@inertiajs/vue3'
defineOptions({ layout: AdminLayout })
const props = defineProps({
  modules_nodes: Array
})

const { badgeClass } = sharedComposable()
const statusForm = useForm({
  module: '',
  status: ''
})
const changeModuleStatus = (name, status) => {
  statusForm.module = name
  statusForm.status = status ? 'disable' : 'enable'
  statusForm.post(route('admin.module-settings-change-status'))
}
</script>
<template>
  <main class="container p-4 sm:p-6">
    <PageHeader />

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
      <div v-for="module in modules_nodes" :key="module.alias" class="card card-body">
        <div class="flex items-start justify-between">
          <div>
            <h5 class="text-lg font-medium text-gray-900">{{ module.name || '' }}</h5>
            <div class="mt-5 space-y-2 text-sm">
              <p v-if="module.description">Description : {{ module.description }}</p>
              <p>
                Type : <span class="capitalize">{{ module.module_type || '' }}</span>
              </p>
              <p>
                Status :
                <span :class="badgeClass(module.enabled)">
                  {{ module.enabled ? trans('Active') : trans('Inactive') }}
                </span>
              </p>
              <p class="text-sm">
                Version : <span class="text-red-600">v{{ module.version || '' }}</span>
              </p>
            </div>
          </div>

          <FloatingDropdown
            btnType="icon"
            btn-class="bg-dark-100 dark:bg-dark-900 rounded-full p-1"
          >
            <div class="flex flex-col">
              <button
                type="button"
                class="dropdown-link"
                @click="changeModuleStatus(module.name, module.enabled)"
              >
                <Icon :icon="module.enabled ? 'bx:x-circle' : 'bx:check-circle'" />
                <span class="text-xs">
                  {{ module.enabled ? trans('Disable') : trans('Enable') }}
                </span>
              </button>

              <Link
                v-if="module.module_key"
                class="dropdown-link"
                :href="
                  route(
                    'admin.module-settings-check-version',
                    module?.modules_core_name || module?.alias
                  )
                "
              >
                <Icon icon="mdi:download" />
                Check Update
              </Link>
            </div>
          </FloatingDropdown>
        </div>
      </div>
    </div>
    <NoDataFound v-if="!modules_nodes || modules_nodes?.length < 1" />
  </main>
</template>
