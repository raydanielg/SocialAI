<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
import notify from '@/Composables/toastComposable'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import { Head, useForm } from '@inertiajs/vue3'
const props = defineProps(['buttons', 'id', 'contents'])
defineOptions({ layout: AdminLayout })

const form = useForm({
  _method: 'patch',
  title: props.contents?.title ?? '',
  description: props.contents?.description ?? '',
  preview: null,
  tags: props.contents?.tags ?? ''
})

const update = () => {
  const url = route('admin.seo.update', props.id)
  form.post(url, {
    onSuccess: () => {
      notify.success('SEO data updated successfully')
    }
  })
}
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <Head title="Edit SEO Settings" />
    <PageHeader :title="trans('Edit SEO Settings')" :buttons="buttons" />
    <div class="space-y-6">
      <form @submit.prevent="update" enctype="multipart/form-data">
        <div class="grid grid-cols-12">
          <div class="lg:col-span-5">
            <strong>{{ trans('Edit page seo settings') }}</strong>
            <p>{{ trans('Edit page seo and necessary information from here') }}</p>
          </div>
          <div class="lg:col-span-7">
            <!-- Alerts -->
            <div class="card">
              <div class="card-header">
                <h3 class="mb-0">{{ trans('Edit Settings') }}</h3>
              </div>
              <div class="card-body">
                <div class="mb-2">
                  <label>{{ trans('Meta Title') }}</label>
                  <input type="text" v-model="form.title" required="" class="input" />
                </div>
                <div class="mb-2">
                  <label>{{ trans('Meta Description') }}</label>
                  <textarea v-model="form.description" class="summernote input h-200"></textarea>
                </div>

                <div class="mb-2">
                  <label>{{ trans('Meta Image') }}</label>
                  <input
                    @input="(e) => (form.preview = e.target.files[0])"
                    type="file"
                    accept="image/*"
                    class="input"
                  />
                </div>

                <div class="mb-2">
                  <label>{{ trans('Meta Tags') }}</label>
                  <input type="text" v-model="form.tags" class="input" />
                </div>

                <div class="from-group row mt-3">
                  <div class="col-lg-12">
                    <SpinnerBtn :processing="form.processing" :btn-text="trans('Save Changes')" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </main>
</template>
