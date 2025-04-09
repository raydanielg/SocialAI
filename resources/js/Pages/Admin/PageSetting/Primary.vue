<script setup>
import { onBeforeMount, ref } from 'vue'

import ImageInput from '@/Components/Admin/ImageInput.vue'
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
import { useOptionUpdateStore } from '@/Store/Admin/optionUpdate'

const props = defineProps(['data'])
const form = ref({ ...props.data })
const store = useOptionUpdateStore()

if (!form.value.socials) {
  form.value.socials = {}
}

onBeforeMount(() => {
  let properties = ['cta_s1', 'cta_s2', 'footer_cta', 'faq_section']
  properties.forEach((key) => (form.value[key] = form.value[key] || {}))
})
</script>

<template>
  <form
    method="POST"
    @submit.prevent="store.submit('primary_data', form)"
    enctype="multipart/form-data"
  >
    <h6>{{ trans('Primary Settings') }}</h6>
    <div class="mb-10 mt-2 rounded border p-3 dark:border-gray-600">
      <ImageInput :label="trans('Site Logo - light Color')" v-model="form.logo" class="mb-2" />

      <ImageInput :label="trans('Site Logo - Deep color')" v-model="form.deep_logo" class="mb-2" />

      <ImageInput :label="trans('Favicon')" v-model="form.favicon" class="mb-2" />

      <div class="mb-2">
        <label>{{ trans('Footer Logo After text') }}</label>
        <input type="text" class="input" v-model="form.slogan" />
      </div>

      <div class="mb-2">
        <label>{{ trans('Footer Copyright text') }}</label>
        <input type="text" class="input" v-model="form.copyright_text" />
      </div>

      <div class="mb-2">
        <label>{{ trans('Email address') }}</label>
        <input type="email" v-model="form.contact_email" class="input" />
      </div>
      <div class="mb-2">
        <label>{{ trans('Contact Phone') }}</label>
        <input type="number" class="input" v-model="form.contact_phone" />
      </div>

      <div class="mb-2">
        <label>{{ trans('Office Location') }}</label>
        <input type="text" class="input" v-model="form.address" />
      </div>
    </div>

    <h6>{{ trans('Social Networks') }}</h6>
    <div class="mb-10 mt-2 rounded border p-3 dark:border-gray-600">
      <div class="mb-2">
        <label>{{ trans('Facebook Profile Link') }}</label>
        <input type="url" name="socials[facebook]" class="input" v-model="form.socials.facebook" />
      </div>
      <div class="mb-2">
        <label>{{ trans('Youtube Profile Link') }}</label>
        <input type="url" name="socials[youtube]" class="input" v-model="form.socials.youtube" />
      </div>
      <div class="mb-2">
        <label>{{ trans('Twitter Profile Link') }}</label>
        <input type="url" name="socials[twitter]" class="input" v-model="form.socials.twitter" />
      </div>
      <div class="mb-2">
        <label>{{ trans('Instagram Profile Link') }}</label>
        <input
          type="url"
          name="socials[instagram]"
          class="input"
          v-model="form.socials.instagram"
        />
      </div>
      <div class="mb-2">
        <label>{{ trans('Linkedin Profile Link') }}</label>
        <input type="url" name="socials[linkedin]" class="input" v-model="form.socials.linkedin" />
      </div>
    </div>

    <h6>{{ trans('Footer CTA banner') }}</h6>
    <div class="mb-10 mt-2 rounded border p-3 dark:border-gray-600">
      <ImageInput :label="trans('BG Image')" v-model="form.footer_cta.img1" />

      <div class="mb-2">
        <label>{{ trans('Title') }}</label>
        <input type="text" class="input" v-model="form.footer_cta.title" />
      </div>
      <div class="mb-2">
        <label>{{ trans('Sub title') }}</label>
        <input type="text" class="input" v-model="form.footer_cta.sub_title" />
      </div>

      <div class="mb-2">
        <label>{{ trans('Button Text') }}</label>
        <input type="text" class="input" v-model="form.footer_cta.btn_text" />
      </div>
      <div class="mb-2">
        <label>{{ trans('Button Link') }}</label>
        <input type="url" class="input" v-model="form.footer_cta.btn_link" />
      </div>
    </div>

    <h6>{{ trans('Manage Cards CTA Section') }}</h6>
    <div class="mb-10 mt-2 rounded border p-3 dark:border-gray-600">
      <div class="mb-2">
        <label>{{ trans('Title') }}</label>
        <input type="text" class="input" v-model="form.cta_s1.title" />
        <small
          >Note: use <code>&lt;span&gt;text&lt;/span&gt;</code> to make text italic and
          <code>&lt;br/&gt;</code> to line break
        </small>
      </div>

      <div class="mb-2">
        <label>{{ trans('Subtitle') }}</label>
        <input type="text" class="input" v-model="form.cta_s1.sub_title" />
      </div>

      <div class="mb-2">
        <label>{{ trans('Button Text') }}</label>
        <input type="text" class="input" v-model="form.cta_s1.btn_text" />
      </div>

      <div class="mb-2">
        <label>{{ trans('Button Link') }}</label>
        <input type="url" class="input" v-model="form.cta_s1.btn_link" />
      </div>

      <ImageInput
        :label="trans('Left Background Image')"
        v-model="form.cta_s1.bg_img"
        class="mb-2"
      />
      <ImageInput
        :label="trans('BG top-left Image')"
        v-model="form.cta_s1.bg_top_left_image"
        class="mb-2"
      />
      <ImageInput
        :label="trans('BG top-right Image')"
        v-model="form.cta_s1.bg_top_right_image"
        class="mb-2"
      />
      <ImageInput
        :label="trans('BG top-right Image 2')"
        v-model="form.cta_s1.bg_top_right_image2"
        class="mb-2"
      />
      <ImageInput
        :label="trans('BG bottom-center Image')"
        v-model="form.cta_s1.bg_bottom_center_image"
        class="mb-2"
      />
      <ImageInput
        :label="trans('BG Overflow Image')"
        v-model="form.cta_s1.bg_overflow_img"
        class="mb-2"
      />
    </div>

    <h6>{{ trans('Track and Analyze Sales CTA Section') }}</h6>
    <div class="mb-10 mt-2 rounded border p-3 dark:border-gray-600">
      <div class="mb-2">
        <label>{{ trans('Title') }}</label>
        <input type="text" class="input" v-model="form.cta_s2.title" />
        <small
          >Note: use <code>&lt;span&gt;text&lt;/span&gt;</code> to make text italic and
          <code>&lt;br/&gt;</code> to line break
        </small>
      </div>

      <div class="mb-2">
        <label>{{ trans('Subtitle') }}</label>
        <input type="text" class="input" v-model="form.cta_s2.sub_title" />
      </div>

      <div class="mb-2">
        <label>{{ trans('List items') }}</label>
        <input type="text" class="input" v-model="form.cta_s2.list_items" />
        <small>{{ trans('use (,) to separate') }}</small>
      </div>

      <ImageInput
        :label="trans('Right Background Image')"
        v-model="form.cta_s2.bg_img"
        class="mb-2"
      />
      <ImageInput
        :label="trans('BG Overflow Image')"
        v-model="form.cta_s2.bg_overflow_image"
        class="mb-2"
      />
      <ImageInput
        :label="trans('Bottom BG Image')"
        v-model="form.cta_s2.bottom_bg_img"
        class="mb-2"
      />
    </div>

    <h6>{{ trans('Faq Section') }}</h6>
    <div class="mb-10 mt-2 rounded border p-3 dark:border-gray-600">
      <div class="mb-2">
        <label>{{ trans('Top title') }}</label>
        <input type="text" class="input" v-model="form.faq_section.top_title" />
      </div>

      <div class="mb-2">
        <label>{{ trans('Title') }}</label>
        <input type="text" class="input" v-model="form.faq_section.title" />
      </div>

      <div class="mb-2">
        <label>{{ trans('Sub title') }}</label>
        <input type="text" class="input" v-model="form.faq_section.sub_title" />
      </div>

      <div class="mb-2">
        <label>{{ trans('Button Text') }}</label>
        <input type="text" class="input" v-model="form.faq_section.btn_text" />
      </div>
      <div class="mb-2">
        <label>{{ trans('Button Link') }}</label>
        <input type="url" class="input" v-model="form.faq_section.btn_link" />
      </div>

      <ImageInput
        :label="trans('Left Overflow Image')"
        v-model="form.faq_section.img_1"
        class="mb-2"
      />
    </div>

    <div class="mb-2">
      <SpinnerBtn :processing="form.processing" :btn-text="trans('Save Changes')" />
    </div>
  </form>
</template>
