<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import { router } from '@inertiajs/vue3'
import { ref, onMounted } from 'vue'

import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
import RichEditor from '@/Components/Admin/RichEditor.vue'
defineOptions({ layout: AdminLayout })

const props = defineProps(['info', 'seo'])

const isProcessing = ref(false)

const seoMeta = ref({
  meta_title: '',
  meta_description: '',
  meta_tags: ''
})

onMounted(() => {
  seoMeta.value.meta_title = props.seo.title
  seoMeta.value.meta_description = props.seo.description
  seoMeta.value.meta_tags = props.seo.tags
})

const editPage = () => {
  const data = { ...seoMeta.value, ...props.info }
  isProcessing.value = true
  router.patch(route('admin.page.update', props.info.id), data)
}
</script>

<template>
  <main class="container p-4 sm:p-6">
    <PageHeader />

    <form method="post" @submit.prevent="editPage">
      <!-- Alerts -->
      <div class="card">
        <div class="card-body space-y-5">
          <div>
            <label class="label label-required mb-1">{{ trans('Page Title') }}</label>
            <input type="text" name="title" v-model="info.title" required class="input" />
          </div>
          <div>
            <label class="label label-required mb-1">{{ trans('Page Description') }}</label>

            <RichEditor v-model="info.description.value" />
          </div>

          <div class="mb-2">
            <label class="label label-required mb-1">{{ trans('SEO Meta Title') }}</label>
            <input
              v-model="seoMeta.meta_title"
              type="text"
              name="meta_title"
              required
              class="input"
            />
          </div>
          <div class="mb-2 mt-2">
            <label class="label label-required mb-1">{{ trans('SEO Meta Description') }}</label>
            <textarea
              v-model="seoMeta.meta_description"
              name="meta_description"
              required
              class="textarea"
            ></textarea>
          </div>
          <div class="mb-2 mt-3">
            <label class="label label-required mb-1">{{ trans('SEO Meta Tags') }}</label>
            <input
              v-model="seoMeta.meta_tags"
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
                  v-model="info.status"
                  class="toggle-input peer sr-only"
                  id="toggle-status"
                  type="checkbox"
                />
                <div class="toggle-body"></div>
                <span class="label label-md">{{ trans('Make it publish?') }}</span>
              </label>
            </div>
          </div>

          <SpinnerBtn :processing="isProcessing" :btnText="trans('Save Changes')" />
        </div>
      </div>
    </form>
  </main>
</template>
