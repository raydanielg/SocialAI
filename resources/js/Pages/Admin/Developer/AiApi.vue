<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import { useForm } from '@inertiajs/vue3'
import toast from '@/Composables/toastComposable'
defineOptions({ layout: AdminLayout })
const props = defineProps([
  'id',
  'STABLE_DIFFUSION_API_MODE',
  'STABLE_DIFFUSION_API_KEY',
  'STABILITY_AI_API_KEY',
  'OPENAI_API_KEY',
  'AI_MOCK_DATA',
  'segments',
  'buttons'
])

const form = useForm({
  STABLE_DIFFUSION_API_MODE: props.STABLE_DIFFUSION_API_MODE,
  STABLE_DIFFUSION_API_KEY: props.STABLE_DIFFUSION_API_KEY,
  STABILITY_AI_API_KEY: props.STABILITY_AI_API_KEY,
  OPENAI_API_KEY: props.OPENAI_API_KEY,
  AI_MOCK_DATA: props.AI_MOCK_DATA
})

function update() {
  form.put(route('admin.developer-settings.update', props.id), {
    onSuccess: () => {
      toast.success(trans('Settings has been updated successfully'))
    }
  })
}
</script>

<template>
  <main class="container p-4 sm:p-6">
    <PageHeader :title="trans('Ai Api Settings')" :buttons="buttons" />
    <div class="space-y-6">
      <div class="grid grid-cols-1 lg:grid-cols-12">
        <div class="lg:col-span-5">
          <strong>{{ trans('Application Ai Api Settings') }}</strong>
          <p>{{ trans('Edit you Ai Api Settings') }}</p>
        </div>
        <div class="lg:col-span-7">
          <form @submit.prevent="update" class="space-y-4">
            <div class="card card-body space-y-4">
              <h6 class="-ml-1 text-lg">{{ trans('Ai Mock Settings') }}</h6>
              <div>
                <label class="label">{{ trans('Ai Mock Data') }}</label>
                <select class="select" v-model="form.AI_MOCK_DATA" name="AI_MOCK_DATA">
                  <option value="true">{{ trans('Enable') }}</option>
                  <option value="false">{{ trans('Disable') }}</option>
                </select>
              </div>
            </div>
            <div class="card card-body space-y-4">
              <h6 class="-ml-1 text-lg">{{ trans('Open AI Settings') }}</h6>
              <div>
                <label class="label">{{ trans('OpenAi Api Key') }}</label>
                <input
                  type="text"
                  v-model="form.OPENAI_API_KEY"
                  class="input"
                  placeholder="APi key"
                />
              </div>
            </div>
            <div class="card card-body space-y-4">
              <h6 class="-ml-1 text-lg">{{ trans('Stable Diffusion Settings') }}</h6>
              <div>
                <label class="label">{{ trans('Stable Diffusion Api Mode') }}</label>
                <select
                  class="select"
                  v-model="form.STABLE_DIFFUSION_API_MODE"
                  name="STABLE_DIFFUSION_API_MODE"
                >
                  <option value="stage">{{ trans('Stage') }}</option>
                  <option value="production">{{ trans('Production') }}</option>
                </select>
              </div>
              <div>
                <label class="label">{{ trans('Stable Diffusion Api Key') }}</label>
                <input
                  type="text"
                  v-model="form.STABLE_DIFFUSION_API_KEY"
                  class="input"
                  placeholder="APi key"
                />
              </div>
            </div>
            <div class="card card-body space-y-4">
              <h6 class="-ml-1 text-lg">{{ trans('Stability Ai Settings') }}</h6>

              <div>
                <label class="label">{{ trans('Stability Ai Api Key') }}</label>
                <input
                  type="text"
                  v-model="form.STABILITY_AI_API_KEY"
                  class="input"
                  placeholder="APi key"
                />
              </div>
              <div>
                <SpinnerBtn :processing="form.processing" :btn-text="trans('Save Changes')" />
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
</template>
