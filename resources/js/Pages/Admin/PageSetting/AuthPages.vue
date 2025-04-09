<script setup>
import {
  onBeforeMount,
  ref,
} from "vue";

import ImageInput from "@/Components/Admin/ImageInput.vue";
import SpinnerBtn from "@/Components/Admin/SpinnerBtn.vue";
import { useOptionUpdateStore } from "@/Store/Admin/optionUpdate";

const props = defineProps(["data"])
const form = ref({ ...props.data })
const store = useOptionUpdateStore()

onBeforeMount(() => {
  let properties = ["login"]
  properties.forEach((key) => (form.value[key] = form.value[key] || {}))
})
</script>

<template>
  <form
    method="POST"
    @submit.prevent="store.submit('auth_pages', form)"
    enctype="multipart/form-data"
  >
    <h6>{{ trans("Left Banner Section (All pages)") }}</h6>
    <div class="mb-10 mt-2 rounded border p-3 dark:border-gray-600">
      <div class="mb-2">
        <label>{{ trans("Banner text") }}</label>
        <input type="text" class="input" v-model="form.login.banner_text" />
      </div>

      <ImageInput :label="trans('Image 1')" v-model="form.login.image1" class="mb-2" />
      <ImageInput :label="trans('Image 2')" v-model="form.login.image2" class="mb-2" />
      <ImageInput :label="trans('Image 3')" v-model="form.login.image3" class="mb-2" />
      <ImageInput :label="trans('Image 4')" v-model="form.login.image4" class="mb-2" />
      <ImageInput
        :label="trans('Background Image')"
        v-model="form.login.bg_image"
        class="mb-2"
      />
      <ImageInput :label="trans('Image 5')" v-model="form.login.image5" class="mb-2" />
    </div>

    <div class="mb-2">
      <SpinnerBtn :processing="store.processing" :btn-text="trans('Save Changes')" />
    </div>
  </form>
</template>
