<script setup>
import RichEditor from '@/Components/Admin/RichEditor.vue'
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
import InputFieldError from '@/Components/InputFieldError.vue'
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import { useForm } from '@inertiajs/vue3'

defineOptions({ layout: AdminLayout })

const props = defineProps(['buttons', 'segments'])

const form = useForm({
  title: '',
  preview: '',
  preview_2: '',
  bg_color: '#ffffff',
  short_description: '',
  long_description: '',
  is_featured: false,
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
  form.post(route('admin.integrations.store'), {
    onSuccess: () => {
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
            <input type="text" v-model="form.title" class="input" />
            <InputFieldError :message="form.errors.title" />
          </div>

          <div class="mb-2 mt-2">
            <label>{{ trans('Short Description') }}</label>
            <textarea
              v-model="form.short_description"
              name="short_description"
              class="textarea"
              maxlength="500"
            ></textarea>
            <InputFieldError :message="form.errors.short_description" />
          </div>

          <div class="flex gap-2">
            <div class="mb-2">
              <label class="label mb-2">{{ trans('Preview Image') }}</label>
              <input
                type="file"
                @change="(e) => (form.preview = e.target.files[0])"
                class="input"
              />
              <InputFieldError :message="form.errors.preview" />
            </div>
            <div class="mb-2">
              <label class="label mb-2">{{ trans('Banner Image') }}</label>
              <input
                type="file"
                @change="(e) => (form.preview_2 = e.target.files[0])"
                class="input"
              />
              <InputFieldError :message="form.errors.preview_2" />
            </div>

            <div class="w-30 mb-2 text-nowrap">
              <label class="label mb-2">{{ trans('Icon BG Color') }}</label>
              <br />
              <input type="color" v-model="form.bg_color" class="h-8 w-16" />
              <InputFieldError :message="form.errors.bg_color" />
            </div>
          </div>

          <div class="mb-2 mt-3">
            <label>{{ trans('Long Description') }}</label>
            <RichEditor v-model="form.long_description" />
            <InputFieldError :message="form.errors.long_description" />
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

          <div class="mb-2 mt-3">
            <div>
              <label for="toggle-featured-status" class="toggle toggle-sm">
                <input
                  v-model="form.is_featured"
                  class="toggle-input peer sr-only"
                  id="toggle-featured-status"
                  type="checkbox"
                />
                <div class="toggle-body"></div>
                <span class="label label-md">{{ trans('Is Featured?') }}</span>
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
