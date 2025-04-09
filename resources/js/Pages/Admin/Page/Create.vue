<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import { useForm } from '@inertiajs/vue3'
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
import RichEditor from '@/Components/Admin/RichEditor.vue'
defineOptions({ layout: AdminLayout })

const form = useForm({
  title: '',
  description: '',
  meta_title: '',
  meta_description: '',
  meta_tags: '',
  status: false
})
const createPage = () => form.post(route('admin.page.store'))
</script>

<template>
  <main class="container p-4 sm:p-6">
    <PageHeader />

    <form method="post" @submit.prevent="createPage">
      <div class="card">
        <div class="card-body space-y-5">
          <div class="mb-2">
            <label class="label label-required mb-1">{{ trans('Page Title') }}</label>
            <input type="text" name="title" v-model="form.title" required class="input" />
          </div>
          <div class="mb-2">
            <label class="label label-required mb-1">{{ trans('Page Description') }}</label>
            <RichEditor v-model="form.description" />
          </div>

          <div class="mb-2">
            <label class="label label-required mb-1">{{ trans('SEO Meta Title') }}</label>
            <div class="col-lg-12">
              <input
                v-model="form.meta_title"
                type="text"
                name="meta_title"
                required
                class="input"
              />
            </div>
          </div>
          <div class="mb-2 mt-2">
            <label class="label label-required mb-1">{{ trans('SEO Meta Description') }}</label>
            <div class="col-lg-12">
              <textarea
                v-model="form.meta_description"
                name="meta_description"
                required
                class="textarea"
              ></textarea>
            </div>
          </div>
          <div class="mb-2 mt-3">
            <label class="label label-required mb-1">{{ trans('SEO Meta Tags') }}</label>
            <div class="col-lg-12">
              <input v-model="form.meta_tags" type="text" name="meta_tags" required class="input" />
            </div>
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
          <SpinnerBtn :processing="form.processing" :btnText="trans('Create')" />
        </div>
      </div>
    </form>
  </main>
</template>
