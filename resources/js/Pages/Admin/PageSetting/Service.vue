<script setup>
import { onBeforeMount, ref } from 'vue'

import ImageInput from '@/Components/Admin/ImageInput.vue'
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
import { useOptionUpdateStore } from '@/Store/Admin/optionUpdate'

const props = defineProps(['data'])
const form = ref({ ...props.data })
const store = useOptionUpdateStore()

onBeforeMount(() => {
  let properties = ['service', 'hero', 'sidebar_card']
  properties.forEach((key) => (form.value[key] = form.value[key] || {}))
})
</script>

<template>
  <form
    method="POST"
    @submit.prevent="store.submit('service_page', form)"
    enctype="multipart/form-data"
  >
    <h6>{{ trans('Banner Section') }}</h6>

    <div class="mb-10 mt-2 rounded border p-3 dark:border-gray-600">
      <div class="mb-2">
        <label>{{ trans('Title') }}</label>
        <input type="text" class="input" v-model="form.hero.title1" />
      </div>
      <div class="mb-2">
        <label>{{ trans('Title 2') }}</label>
        <input type="text" class="input" v-model="form.hero.title2" />
      </div>

      <ImageInput :label="trans('Banner Image')" v-model="form.hero.banner_img" class="mb-2" />
    </div>

    <h6>{{ trans('Service Page') }}</h6>
    <div class="mb-10 mt-2 rounded border p-3 dark:border-gray-600">
      <div class="mb-2">
        <label>{{ trans('Title') }}</label>
        <input type="text" class="input" v-model="form.service.title" />
        <small
          >Note: use <code>&lt;span&gt;text&lt;/span&gt;</code> to make text italic and
          <code>&lt;br/&gt;</code> to line break
        </small>
      </div>

      <div class="mb-2">
        <label>{{ trans('Right Button Text') }}</label>
        <input type="text" class="input" v-model="form.service.btn_text" />
      </div>

      <div class="mb-2">
        <label>{{ trans('Right Button Link') }}</label>
        <input type="url" class="input" v-model="form.service.btn_link" />
      </div>

      <ImageInput :label="trans('Background Image')" v-model="form.service.bg_img" class="mb-2" />

      <ImageInput
        :label="trans('BG bottom-right Image')"
        v-model="form.service.bg_bottom_right_image"
        class="mb-2"
      />
    </div>

    <h6>{{ trans('Sidebar card') }}</h6>
    <div class="mb-10 mt-2 rounded border p-3 dark:border-gray-600">
      <div class="mb-2">
        <label>{{ trans('Title') }}</label>
        <input type="text" class="input" v-model="form.sidebar_card.title" />
      </div>

      <div class="mb-2">
        <label>{{ trans('Sub title') }}</label>
        <input type="text" class="input" v-model="form.sidebar_card.sub_title" />
      </div>

      <div class="mb-2">
        <label>{{ trans('Button Text') }}</label>
        <input type="text" class="input" v-model="form.sidebar_card.btn_text" />
      </div>
      <div class="mb-2">
        <label>{{ trans('Button Link') }}</label>
        <input type="url" class="input" v-model="form.sidebar_card.btn_link" />
      </div>

      <ImageInput :label="trans('BG Image')" v-model="form.sidebar_card.bg_img" />
      <ImageInput
        :label="trans('Bottom Image')"
        v-model="form.sidebar_card.bottom_img"
        class="mb-2"
      />
    </div>

    <div class="mb-2">
      <SpinnerBtn :processing="store.processing" :btn-text="trans('Save Changes')" />
    </div>
  </form>
</template>
