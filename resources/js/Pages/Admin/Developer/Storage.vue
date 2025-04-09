<template>
  <main class="container p-4 sm:p-6">
    <Head title="Storage" />
    <PageHeader :title="trans('Storage Settings')" :buttons="buttons" />
    <div class="space-y-6">
      <div class="grid grid-cols-1 lg:grid-cols-12">
        <div class="lg:col-span-5">
          <strong>{{ trans('Application Storage Settings') }}</strong>
          <p>{{ trans('Edit you storage settings for store uploaded files') }}</p>
        </div>
        <div class="lg:col-span-7">
          <form @submit.prevent="update">
            <div class="card">
              <div class="card-body">
                <div class="mb-2">
                  <label class="label">{{ trans('Storage Upload Mode') }}</label>
                  <select
                    class="select"
                    v-model="form.FILESYSTEM_DISK"
                    name="FILESYSTEM_DISK"
                    id="disk-method"
                  >
                    <option value="public">{{ trans('Own server (Uploads folder)') }}</option>
                    <option value="wasabi">{{ trans('Wasabi') }}</option>
                  </select>
                </div>

                <div v-if="form.FILESYSTEM_DISK != 'public'">
                  <div class="mb-2">
                    <label class="label">{{ trans('Wasabi Access Key Id') }}</label>
                    <input
                      type="text"
                      name="WAS_ACCESS_KEY_ID"
                      class="input"
                      v-model="form.WAS_ACCESS_KEY_ID"
                    />
                  </div>
                  <div class="mb-2">
                    <label class="label">{{ trans('Wasabi Secret Access Key') }}</label>
                    <input
                      type="text"
                      name="SECRET_ACCESS_KEY"
                      class="input"
                      v-model="form.SECRET_ACCESS_KEY"
                    />
                  </div>
                  <div class="mb-2">
                    <label class="label">{{ trans('Wasabi Default Region') }}</label>
                    <input
                      type="text"
                      name="WAS_DEFAULT_REGION"
                      class="input"
                      v-model="form.WAS_DEFAULT_REGION"
                    />
                  </div>
                  <div class="mb-2">
                    <label class="label">{{ trans('Wasabi Bucket Name') }}</label>
                    <input type="text" name="WAS_BUCKET" class="input" v-model="form.WAS_BUCKET" />
                  </div>
                  <div class="mb-2">
                    <label class="label">{{ trans('Wasabi Endpoint') }}</label>
                    <input
                      type="text"
                      name="WAS_ENDPOINT"
                      class="input"
                      v-model="form.WAS_ENDPOINT"
                    />
                  </div>
                </div>

                <div class="mb-2">
                  <div class="">
                    <SpinnerBtn :processing="form.processing" :btn-text="trans('Save Changes')" />
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
import notify from '@/Composables/toastComposable'
export default {
  layout: AdminLayout
}
</script>

<script setup>
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import { Head, useForm } from '@inertiajs/vue3'

const props = defineProps([
  'id',
  'FILESYSTEM_DISK',
  'WAS_ACCESS_KEY_ID',
  'SECRET_ACCESS_KEY',
  'WAS_DEFAULT_REGION',
  'WAS_BUCKET',
  'WAS_ENDPOINT',
  'segments',
  'buttons'
])

const form = useForm({
  FILESYSTEM_DISK: props.FILESYSTEM_DISK,
  WAS_ACCESS_KEY_ID: props.WAS_ACCESS_KEY_ID,
  SECRET_ACCESS_KEY: props.SECRET_ACCESS_KEY,
  WAS_DEFAULT_REGION: props.WAS_DEFAULT_REGION,
  WAS_BUCKET: props.WAS_BUCKET,
  WAS_ENDPOINT: props.WAS_ENDPOINT
})

function update() {
  const url = route('admin.developer-settings.update', props.id)
  form.put(url, {
    onSuccess: () => {
      notify.success(trans('Settings has been updated successfully'))
    }
  })
}
</script>
