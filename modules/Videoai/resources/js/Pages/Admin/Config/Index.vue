<script setup>
import AdminLayout from '@root/Layouts/Admin/AdminLayout.vue'
import SpinnerBtn from '@root/Components/Admin/SpinnerBtn.vue'
import PageHeader from '@root/Layouts/Admin/PageHeader.vue'
import { useForm } from '@inertiajs/vue3'
import sharedComposable from '@root/Composables/sharedComposable'

defineOptions({ layout: AdminLayout })
const props = defineProps(['RUNWAYML_API_KEY', 'models', 'aiSetting'])
const { trim } = sharedComposable()
const form = useForm({
  API_KEY: props.RUNWAYML_API_KEY,
  model: props.aiSetting?.model || '',
  meta: {
    credit: props.aiSetting?.meta?.credit || 1
  }
})

const submit = () => {
  form.post(route('admin.videoai.config.store'))
}
</script>

<template>
  <main class="container p-4 sm:p-6">
    <PageHeader :title="trans('Video Ai Settings')" />
    <div class="space-y-6">
      <div class="grid grid-cols-1 lg:grid-cols-12">
        <div class="lg:col-span-5">
          <strong>{{ trans('Application Video Api Settings') }}</strong>
          <p>{{ trans('Edit Video Ai Api Settings') }}</p>
        </div>
        <div class="lg:col-span-7">
          <form @submit.prevent="submit" class="space-y-4">
            <div class="card card-body space-y-4">
              <h6 class="-ml-1 text-lg">{{ trans('Runway ML Settings') }}</h6>
              
              <div class="mb-2">
                <label class="label">{{ trans('Credit (per second)') }}</label>
                <input type="number" v-model="form.meta.credit" class="input" />
              </div>
              <div>
                <label class="label">{{ trans('Select Model') }}</label>
                <select class="select capitalize" v-model="form.model">
                  <option value="" disabled selected>{{ trans('Select Model') }}</option>
                  <option v-for="model in models" :value="model" :key="model">
                    {{ trim(model) }}
                  </option>
                </select>
              </div>
              <div>
                <label class="label">{{ trans('Runway ML Api Key') }}</label>
                <textarea v-model="form.API_KEY" class="textarea" placeholder="APi key" />
                <a href="https://app.runwayml.com/" target="_blank" class="text-sm"> <span class="text-primary-500 underline">{{ trans('Runway ML API') }}</span></a>
              </div>
            </div>
            <div class="flex justify-end">
              <SpinnerBtn :processing="form.processing" :btn-text="trans('Save Changes')" />
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
</template>
