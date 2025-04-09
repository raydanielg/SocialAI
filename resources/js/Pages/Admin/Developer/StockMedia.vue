<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import SpinnerBtn from '@/Components/SpinnerBtn.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import { useForm } from '@inertiajs/vue3'
import trans from '@/Composables/transComposable'
defineOptions({ layout: AdminLayout })
const props = defineProps(['segments', 'buttons', 'id', 'UNSPLASH_API_KEY', 'PEXELS_API_KEY'])

const form = useForm({
  UNSPLASH_API_KEY: props.UNSPLASH_API_KEY,
  PEXELS_API_KEY: props.PEXELS_API_KEY
})

function update() {
  const url = route('admin.developer-settings.update', props.id)
  form.put(url)
}
</script>

<template>
  <main class="container p-4 sm:p-6">
    <PageHeader
      :title="trans('Social Login Developer Settings')"
      :segments="segments"
      :buttons="buttons"
    />
    <div class="space-y-6">
      <div class="grid grid-cols-1 lg:grid-cols-12">
        <div class="lg:col-span-5">
          <strong>{{ trans('Stock Media Developer Settings') }}</strong>
          <p>{{ trans('Edit you application Stock Media Api settings') }}</p>
        </div>
        <div class="lg:col-span-7">
          <form @submit.prevent="update">
            <div class="card">
              <div class="card-body">
                <h6>{{ trans('Stock Media Api Keys') }}</h6>
                <div class="mb-2">
                  <label class="label">{{ trans('Unsplash Api') }}</label>
                  <input type="text" v-model="form.UNSPLASH_API_KEY" class="input" />
                </div>
                <div class="mb-2">
                  <label class="label">{{ trans('Pexels Api') }}</label>
                  <input type="text" v-model="form.PEXELS_API_KEY" class="input" />
                </div>

                <div class="mt-3">
                  <SpinnerBtn :processing="form.processing" :btn-text="trans('Save Changes')" />
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
</template>
