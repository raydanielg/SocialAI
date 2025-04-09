<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader :title="trans('Edit Feature')" :buttons="buttons" />
    <div class="space-y-6">
      <form @submit.prevent="update" class="ajaxform_instant_reload" enctype="multipart/form-data">
        <div class="grid lg:grid-cols-5">
          <div class="lg:col-span-2">
            <strong>{{ trans('Edit a features post') }}</strong>
            <p>{{ trans('Add your features details and necessary information from here') }}</p>
          </div>

          <div class="lg:col-span-3">
            <div class="card">
              <div class="card-body">
                <div class="mb-2">
                  <label class="">{{ trans('Features Title') }}</label>
                  <div class="">
                    <input
                      type="text"
                      v-model="form.title"
                      name="title"
                      required=""
                      class="input"
                    />
                    <div class="invalid-feedback text-danger d-block" v-if="form.errors.title">
                      {{ form.errors.title }}
                    </div>
                  </div>
                </div>
                <div class="mb-2 mt-2">
                  <label class="">{{ trans('Preview Image') }}</label>
                  <div class="">
                    <input
                      @input="(e) => (form.preview_image = e.target.files[0])"
                      type="file"
                      class="input"
                      name="preview_image"
                      accept="image/*"
                    />
                    <div
                      class="invalid-feedback text-danger d-block"
                      v-if="form.errors.preview_image"
                    >
                      {{ form.errors.preview_image }}
                    </div>
                  </div>
                </div>
                <div class="mb-2 mt-2">
                  <label class="">{{ trans('Banner Image') }}</label>
                  <div class="">
                    <input
                      @input="(e) => (form.banner_image = e.target.files[0])"
                      type="file"
                      class="input"
                      name="banner_image"
                      accept="image/*"
                    />
                    <div
                      class="invalid-feedback text-danger d-block"
                      v-if="form.errors.banner_image"
                    >
                      {{ form.errors.banner_image }}
                    </div>
                  </div>
                </div>
                <div class="mb-2 mt-2">
                  <label class="">{{ trans('Short Description') }}</label>
                  <div class="">
                    <textarea
                      v-model="form.description"
                      name="description"
                      required=""
                      class="textarea h-100"
                      maxlength="500"
                    ></textarea>
                    <div
                      class="invalid-feedback text-danger d-block"
                      v-if="form.errors.description"
                    >
                      {{ form.errors.description }}
                    </div>
                  </div>
                </div>
                <div class="mb-2 mt-3">
                  <label class="">{{ trans('Main Description') }}</label>
                  <div class="">
                    <textarea
                      v-model="form.main_description"
                      name="main_description"
                      required=""
                      class="h-200 textarea"
                    ></textarea>
                    <div
                      class="invalid-feedback text-danger d-block"
                      v-if="form.errors.main_description"
                    >
                      {{ form.errors.main_description }}
                    </div>
                  </div>
                </div>
                <div class="mb-2 mt-2">
                  <label class="">{{ trans('Select Langauge') }}</label>
                  <div class="">
                    <select v-model="form.language" name="language" class="select">
                      <option v-for="(language, key) in languages" :key="key" :value="key">
                        {{ language }}
                      </option>
                    </select>
                    <div class="invalid-feedback text-danger d-block" v-if="form.errors.language">
                      {{ form.errors.language }}
                    </div>
                  </div>
                </div>
                <div class="mb-2 mt-2">
                  <div>
                    <label for="toggle-featured" class="toggle toggle-sm">
                      <input
                        v-model="form.featured"
                        class="toggle-input peer sr-only"
                        id="toggle-featured"
                        type="checkbox"
                      />
                      <div class="toggle-body"></div>
                      <span class="label label-md">{{ trans('Make it featured?') }}</span>
                    </label>
                  </div>

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

                  <div class="mb-2 mt-3">
                    <button class="btn btn-primary">{{ trans('Submit') }}</button>
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

<script>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import notify from '@/Composables/toastComposable'
export default {
  layout: AdminLayout
}
</script>

<script setup>
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import { Head, useForm } from '@inertiajs/vue3'

const props = defineProps(['languages', 'segments', 'buttons', 'info'])

const form = useForm({
  title: props.info.title,
  preview_image: '',
  banner_image: '',
  description: props.info.excerpt.value,
  main_description: props.info.long_description.value,
  language: props.info.lang,
  featured: props.info.featured == 1 ? true : false,
  status: props.info.status == 1 ? true : false
})

const update = () => {
  const url = route('admin.features.update', props.info.id)
  form.put(url, {
    onSuccess: () => {
      notify.success(trans('Item has been updated successfully'))
    }
  })
}
</script>
