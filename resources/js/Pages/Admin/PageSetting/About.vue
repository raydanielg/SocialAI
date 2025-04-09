<script setup>
import { onBeforeMount, ref } from 'vue'

import ImageInput from '@/Components/Admin/ImageInput.vue'
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
import { useOptionUpdateStore } from '@/Store/Admin/optionUpdate'

const props = defineProps(['data'])
const form = ref({ ...props.data })
const store = useOptionUpdateStore()

onBeforeMount(() => {
  let properties = ['header', 'cta_s1', 'partners', 'company', 'timeline', 'cta_s2', 'career_jobs']
  properties.forEach((key) => (form.value[key] = form.value[key] || {}))

  if (!form.value.timeline?.features?.length) {
    form.value.timeline.features = [
      {
        ...defaultFeature
      }
    ]
  }

  if (!form.value.cta_s1?.features?.length) {
    form.value.cta_s1.features = []
  }
})

const defaultFeature = {
  date: '',
  title: '',
  body: ''
}

const addFeatureItem = () => {
  form.value.timeline.features.push({ ...defaultFeature })
}

const removeFeatureItem = (index) => {
  form.value.timeline.features.splice(index, 1)
}
</script>

<template>
  <form
    method="POST"
    @submit.prevent="store.submit('about_page', form)"
    enctype="multipart/form-data"
  >
    <h6>{{ trans('Header Section') }}</h6>
    <div class="mb-10 mt-2 rounded border p-3 dark:border-gray-600">
      <div class="mb-2">
        <label>{{ trans('About [Site Name Title]') }}</label>
        <input type="text" class="input" v-model="form.header.title" />
      </div>

      <ImageInput :label="trans('Banner Image')" v-model="form.header.image" class="mb-2" />
    </div>

    <h6>{{ trans('Partners Section') }}</h6>
    <div class="mb-10 mt-2 rounded border p-3 dark:border-gray-600">
      <div class="mb-2">
        <label>{{ trans('Title') }}</label>
        <input type="text" v-model="form.partners.title" class="input" />
      </div>
      <div class="mb-2">
        <label>{{ trans('Sub title') }}</label>
        <input type="text" v-model="form.partners.sub_title" class="input" />
      </div>
    </div>

    <h6>{{ trans('About The Company ') }}</h6>
    <div class="mb-10 mt-2 rounded border p-3 dark:border-gray-600">
      <div class="mb-2">
        <label>{{ trans('Top Title') }}</label>
        <input type="text" v-model="form.company.top_title" class="input" />
      </div>
      <div class="mb-2">
        <label>{{ trans('Left Title') }}</label>
        <input type="text" v-model="form.company.left_title" class="input" />
      </div>
      <div class="mb-2">
        <label>{{ trans('Right text (phase 1)') }}</label>
        <input type="text" v-model="form.company.right_text1" class="input" />
      </div>
      <div class="mb-2">
        <label>{{ trans('Right text (phase 2)') }}</label>
        <input type="text" v-model="form.company.right_text2" class="input" />
      </div>

      <div class="mb-2">
        <label>{{ trans('About Video Link (use a social media link)') }}</label>
        <input type="url" class="input" v-model="form.company.demo_video" />
      </div>

      <div class="mb-2">
        <label>{{ trans('Creators') }}</label>
        <input type="text" class="input" v-model="form.company.creators" />
        <small> wrap with &lt;em&gt;text&lt;/em&gt; to decorate </small>
      </div>
      <div class="mb-2">
        <label>{{ trans('Revenue per Year') }}</label>
        <input type="text" class="input" v-model="form.company.revenue" />
        <small> wrap with &lt;em&gt;text&lt;/em&gt; to decorate </small>
      </div>
      <div class="mb-2">
        <label>{{ trans('Countries') }}</label>
        <input type="text" class="input" v-model="form.company.countries" />
        <small> wrap with &lt;em&gt;text&lt;/em&gt; to decorate </small>
      </div>
    </div>

    <h6>{{ trans('Card Section (Call to action)') }}</h6>
    <div class="mb-10 mt-2 rounded border p-3 dark:border-gray-600">
      <div class="mb-2">
        <label>{{ trans('Top Title') }}</label>
        <input type="text" class="input" v-model="form.cta_s1.top_title" />
      </div>
      <div class="mb-2">
        <label>{{ trans('Title') }}</label>
        <input type="text" class="input" v-model="form.cta_s1.title" />
      </div>

      <div class="mb-2">
        <label>{{ trans('Sub title') }}</label>
        <input type="text" class="input" v-model="form.cta_s1.subtitle" />
      </div>

      <div class="mb-2">
        <label>{{ trans('features') }}</label>
        <input type="text" class="input" v-model="form.cta_s1.features" />
        <p>{{ trans('use comma (,) for line break') }}</p>
      </div>

      <div class="mb-2">
        <label>{{ trans('Button Text') }}</label>
        <input type="text" class="input" v-model="form.cta_s1.btn_text" />
      </div>

      <div class="mb-2">
        <label>{{ trans('Button Link') }}</label>
        <input type="url" class="input" v-model="form.cta_s1.btn_link" />
      </div>

      <ImageInput :label="trans('BG Image')" v-model="form.cta_s1.bg_image" class="mb-2" />
      <ImageInput :label="trans('Overlay Image 1')" v-model="form.cta_s1.image1" class="mb-2" />
      <ImageInput :label="trans('Overlay Image 2')" v-model="form.cta_s1.image2" class="mb-2" />
      <ImageInput :label="trans('Overlay Image 3')" v-model="form.cta_s1.image3" class="mb-2" />
      <ImageInput
        :label="trans('Left Bottom Image')"
        v-model="form.cta_s1.left_bottom"
        class="mb-2"
      />
    </div>
    <h6>{{ trans('Timeline Section') }}</h6>
    <div class="mb-10 mt-2 rounded border p-3 dark:border-gray-600">
      <div class="mb-2">
        <label>{{ trans('Top title') }}</label>
        <input type="text" class="input" v-model="form.timeline.top_title" />
      </div>
      <div class="mb-2">
        <label>{{ trans('Title') }}</label>
        <input type="text" class="input" v-model="form.timeline.title" />
      </div>

      <div class="mb-2">
        <label class="mr-2">{{ trans('Timeline Items') }}</label>
        <div
          class="mb-2 flex items-center gap-x-2 rounded border p-2 dark:border-gray-600"
          v-for="(item, index) in form.timeline.features"
          :key="index"
        >
          <span class="rounded-full bg-indigo-600 p-2 py-1 text-center text-white">{{
            index + 1
          }}</span>
          <div class="flex flex-grow flex-col gap-1">
            <input type="text" class="input" placeholder="Date" v-model="item.date" />
            <input type="text" class="input" placeholder="title" v-model="item.title" />
            <textarea class="textarea" v-model="item.body" placeholder="body"> </textarea>
          </div>
          <button type="button" @click="removeFeatureItem(index)" class="btn btn-danger">X</button>
        </div>
        <button type="button" @click="addFeatureItem" class="btn btn-primary">+</button>
      </div>
    </div>

    <h6>{{ trans('Jobs section') }}</h6>
    <div class="mb-10 mt-2 rounded border p-3 dark:border-gray-600">
      <div class="mb-2">
        <label>{{ trans('Top title') }}</label>
        <input type="text" class="input" v-model="form.career_jobs.sub_title" />
      </div>
      <div class="mb-2">
        <label>{{ trans('Title') }}</label>
        <input type="text" class="input" v-model="form.career_jobs.title" />
      </div>
    </div>

    <div class="mb-2">
      <SpinnerBtn :processing="store.processing" :btn-text="trans('Save Changes')" />
    </div>
  </form>
</template>
