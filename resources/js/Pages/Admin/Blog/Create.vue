<script setup>
import RichEditor from '@/Components/Admin/RichEditor.vue'
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import notify from '@/Composables/toastComposable'
import { useForm } from '@inertiajs/vue3'
import Multiselect from '@vueform/multiselect'

defineOptions({ layout: AdminLayout })

const form = useForm({
  title: '',
  short_description: '',
  main_description: '',
  categories: [],
  tags: [],
  language: '',
  featured: false,
  status: false,
  meta_title: '',
  meta_description: '',
  meta_tags: '',
  meta_image: '',
  preview: '',
  banner: ''
})

const props = defineProps(['categories', 'languages', 'tags'])

const submit = () => {
  form.post(route('admin.blog.store'), {
    onSuccess: () => {
      notify.success('Blog Post has been added successfully')
    }
  })
}
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader />
    <div class="space-y-6">
      <div class="flex">
        <div class="card mx-auto max-w-[800px]">
          <div class="card-body">
            <form @submit.prevent="submit">
              <div class="mb-2">
                <label>{{ trans('Blog Title') }}</label>
                <input v-model="form.title" type="text" name="title" required="" class="input" />
              </div>

              <div class="mb-2 mt-2">
                <label>{{ trans('Preview Image') }}</label>
                <input
                  @change="(e) => (form.preview = e.target.files[0])"
                  type="file"
                  class="input"
                  required
                  accept="image/*"
                />
              </div>

              <div class="mb-2 mt-2">
                <label>{{ trans('Banner Image') }}</label>
                <input
                  @change="(e) => (form.banner = e.target.files[0])"
                  type="file"
                  class="input"
                  required
                  accept="image/*"
                />
              </div>

              <div class="mb-2 mt-2">
                <label>{{ trans('Short Description') }}</label>
                <textarea
                  v-model="form.short_description"
                  name="short_description"
                  required
                  class="textarea"
                  maxlength="500"
                ></textarea>
              </div>

              <div class="mb-2 mt-3">
                <label>{{ trans('Main Description') }}</label>
                <RichEditor v-model="form.main_description" />
              </div>

              <div class="mb-2 mt-3">
                <label>{{ trans('Select Category') }}</label>
                <Multiselect
                  class="multiselect-dark"
                  :searchable="true"
                  v-model="form.categories"
                  mode="tags"
                  :options="categories"
                  placeholder="Select Main Category"
                />
              </div>

              <div class="mb-2 mt-2">
                <label>{{ trans('Select Tags') }}</label>
                <Multiselect
                  class="multiselect-dark"
                  v-model="form.tags"
                  mode="tags"
                  :options="tags"
                  :searchable="true"
                  placeholder="Select Tags"
                />
              </div>

              <div class="mb-2 mt-2">
                <label>{{ trans('Select Language') }}</label>
                <select v-model="form.language" name="language" class="select">
                  <option v-for="(language, key) in languages" :key="language" :value="key">
                    {{ language }}
                  </option>
                </select>
              </div>

              <hr />

              <div class="mb-2 mt-3">
                <label>{{ trans('SEO Meta Title') }}</label>
                <input
                  v-model="form.meta_title"
                  type="text"
                  name="meta_title"
                  required
                  class="input"
                />
              </div>
              <div class="mb-2 mt-2">
                <label>{{ trans('SEO Meta Image') }}</label>
                <input
                  @input="(event) => (form.meta_image = event.target.files[0])"
                  type="file"
                  class="input"
                  name="meta_image"
                  required
                  accept="image/*"
                />
              </div>
              <div class="mb-2 mt-2">
                <label>{{ trans('SEO Meta Description') }}</label>
                <textarea
                  v-model="form.meta_description"
                  name="meta_description"
                  required
                  class="input h-100"
                ></textarea>
              </div>
              <div class="mb-2 mt-2">
                <label>{{ trans('SEO Meta Tags') }}</label>
                <input
                  v-model="form.meta_tags"
                  type="text"
                  name="meta_tags"
                  required
                  class="input"
                />
              </div>

              <div class="mb-2 mt-3">
                <div>
                  <label for="toggle-status" class="toggle toggle-sm">
                    <input
                      v-model="form.status"
                      class="toggle-input peer sr-only"
                      id="toggle-status"
                      type="checkbox"
                    />
                    <div class="toggle-body"></div>
                    <span class="label label-md">{{ trans('Make it publish?') }}</span>
                  </label>
                </div>
              </div>

              <div class="mb-2 mt-3">
                <div>
                  <SpinnerBtn
                    classes="btn btn-primary"
                    :processing="form.processing"
                    :btn-text="trans('Create')"
                  />
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>
