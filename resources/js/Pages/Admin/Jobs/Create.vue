<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import { useForm } from '@inertiajs/vue3'
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
import RichEditor from '@/Components/Admin/RichEditor.vue'
import notify from '@/Composables/toastComposable'
import InputFieldError from '@/Components/InputFieldError.vue'

defineOptions({ layout: AdminLayout })

const props = defineProps(['buttons', 'segments'])

const form = useForm({
  title: '',
  location: '',
  type: '',
  expert_level: '',
  description: '',
  is_active: true,

  // seo
  seo: {
    title: '',
    image: '',
    description: '',
    tags: ''
  }
})

const submit = () => {
  form.post(route('admin.jobs.store'), {
    onSuccess: () => {
      notify.success(trans('Added Successfully'))
      form.reset()
    }
  })
}
</script>

<template>
  <main class="container p-4 sm:p-6">
    <PageHeader title="Create Integration" :buttons="buttons" />
    <div class="card mx-auto w-[800px]">
      <div class="card-body">
        <form @submit.prevent="submit">
          <div class="mb-2">
            <label class="label mb-2">{{ trans('Title') }}</label>
            <input type="text" v-model="form.title" class="input" placeholder="Software Engineer" />
            <InputFieldError :message="form.errors.title" />
          </div>

          <div class="mb-2">
            <label class="label mb-2">{{ trans('Location') }}</label>
            <input type="text" v-model="form.location" class="input" placeholder="California, US" />
            <InputFieldError :message="form.errors.location" />
          </div>

          <div class="mb-2">
            <label class="label mb-2">{{ trans('Type') }}</label>
            <input
              type="text"
              v-model="form.type"
              class="input"
              placeholder="Fulltime, Part-time"
            />
            <InputFieldError :message="form.errors.type" />
          </div>

          <div class="mb-2">
            <label class="label mb-2">{{ trans('Expert Level') }}</label>
            <input
              type="text"
              v-model="form.expert_level"
              class="input"
              placeholder="Senior, Mid"
            />
            <InputFieldError :message="form.errors.expert_level" />
          </div>

          <div class="mb-2 mt-3">
            <label>{{ trans('Description') }}</label>
            <RichEditor v-model="form.description" />
            <InputFieldError :message="form.errors.description" />
          </div>

          <h6 class="mb-2 mt-10">{{ trans('SEO Settings') }}</h6>
          <div class="mb-2">
            <label>{{ trans('SEO Meta Title') }}</label>
            <input v-model="form.seo.title" type="text" class="input" />
            <InputFieldError :message="form.errors['seo.title']" />
          </div>

          <div class="mb-2">
            <label>{{ trans('SEO Meta Image') }}</label>
            <input
              @change="($event) => (form.seo.image = $event.target.files[0])"
              type="file"
              class="input"
              accept="image/*"
            />
            <InputFieldError :message="form.errors['seo.image']" />
          </div>
          <div class="mb-2 mt-2">
            <label>{{ trans('SEO Meta Description') }}</label>
            <textarea v-model="form.seo.description" class="input h-100"></textarea>
            <InputFieldError :message="form.errors['seo.description']" />
          </div>
          <div class="mb-2 mt-2">
            <label>{{ trans('SEO Meta Tags') }}</label>
            <input v-model="form.seo.tags" type="text" class="input" />
            <InputFieldError :message="form.errors['seo.tags']" />
          </div>

          <div class="mb-2 mt-3">
            <div>
              <label for="toggle-status" class="toggle toggle-sm">
                <input
                  v-model="form.is_active"
                  class="toggle-input peer sr-only"
                  id="toggle-status"
                  type="checkbox"
                />
                <div class="toggle-body"></div>
                <span class="label label-md">{{ trans('Is Active?') }}</span>
              </label>
            </div>
          </div>

          <div class="mb-2">
            <SpinnerBtn
              classes="btn btn-primary"
              :processing="form.processing"
              :btn-text="trans('Create')"
            />
          </div>
        </form>
      </div>
    </div>
  </main>
</template>
