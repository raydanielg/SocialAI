<script setup>
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
defineOptions({ layout: AdminLayout })
import { computed, ref } from 'vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
  module_json: Object,
  updateData: Object
})

const form = useForm({})
const isLoading = ref(false)

const checkUpdate = () => {
  form.post(route('admin.module-settings-check-update', props.module_json.modules_core_name))
}

const confirmUpdate = () => {
  isLoading.value = true
  form.put(route('admin.module-developer-settings.update', props.module_json.modules_core_name), {
    preserveState: true,
    preserveScroll: true,
    onSuccess: () => {
      isLoading.value = false
    },
    onError: (errors) => {
      isLoading.value = false
    }
  })
}

const getUpdateData = computed(() => {
  return props.updateData[props.module_json.modules_core_name]
})
</script>

<template>
  <main class="container p-4 sm:p-6">
    <PageHeader />

    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
      <div class="px-4 py-6 sm:px-0">
        <div class="card card-body mb-6">
          <div class="mb-4 flex items-center justify-between">
            <h2 class="text-xl font-semibold">Modules Update - {{ module_json.name }}</h2>
            <p>Current Version: {{ module_json.version }}</p>
          </div>

          <div class="mb-4">
            <label class="label mb-1" for="purchase_key"> Purchase Key </label>
            <input
              id="purchase_key"
              type="text"
              :value="module_json.module_key"
              readonly
              class="input"
            />
          </div>

          <button @click="checkUpdate" :disabled="isLoading" class="btn btn-primary">
            <span v-if="!isLoading">Check New Update</span>
            <span v-else class="inline-flex items-center">
              <svg
                class="-ml-1 mr-3 h-5 w-5 animate-spin text-white"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
              >
                <circle
                  class="opacity-25"
                  cx="12"
                  cy="12"
                  r="10"
                  stroke="currentColor"
                  stroke-width="4"
                ></circle>
                <path
                  class="opacity-75"
                  fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                ></path>
              </svg>
              Please wait...
            </span>
          </button>
        </div>

        <div class="alert alert-info mb-6" role="alert">
          <p class="font-bold">Note</p>
          <p>
            If you have customized the script from codebase, do not use this option. You will lose
            your customization.
          </p>
        </div>

        <div v-if="updateData && getUpdateData" class="card card-body">
          <div class="mb-4 flex items-center justify-between text-lg font-semibold">
            <p>Version</p>
            <p>Update</p>
          </div>

          <div class="flex items-center justify-between">
            <p class="text-lg text-green-600">v{{ getUpdateData.version }}</p>
            <button @click="confirmUpdate" :disabled="isLoading" class="btn btn-primary">
              <span v-if="!isLoading">Update now</span>
              <span v-else class="inline-flex items-center">
                <svg
                  class="-ml-1 mr-3 h-5 w-5 animate-spin text-white"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                >
                  <circle
                    class="opacity-25"
                    cx="12"
                    cy="12"
                    r="10"
                    stroke="currentColor"
                    stroke-width="4"
                  ></circle>
                  <path
                    class="opacity-75"
                    fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                  ></path>
                </svg>
                Please wait...
              </span>
            </button>
          </div>

          <p v-if="getUpdateData.message" class="alert alert-info mt-4">
            Note: {{ getUpdateData.message }}
          </p>
        </div>
      </div>
    </div>
  </main>
</template>
