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

if (!form.value.socials) {
  form.value.socials = {}
}

onBeforeMount(() => {
  let properties = ["career_platform", "career_header", "career_jobs"]
  properties.forEach((key) => (form.value[key] = form.value[key] || {}))

  if (!form.value.career_platform?.items?.length) {
    form.value.career_platform.items = [
      {
        ...defaultPlatformItem,
      },
    ]
  }
})

const defaultPlatformItem = {
  title: "",
  body: "",
}

const addPlatformItem = () => {
  form.value.career_platform.items.push({ ...defaultPlatformItem })
}

const removePlatformItem = (index) => {
  form.value.career_platform.items.splice(index, 1)
}
</script>

<template>
  <form
    method="POST"
    @submit.prevent="store.submit('career_page', form)"
    enctype="multipart/form-data"
  >
    <h6>{{ trans("Header section") }}</h6>
    <div class="mb-10 mt-2 rounded border p-3 dark:border-gray-600">
      <div class="mb-2">
        <label>{{ trans("Title") }}</label>
        <input type="text" class="input" v-model="form.career_header.title" />
      </div>
      <div class="mb-2">
        <label>{{ trans("Sub title") }}</label>
        <input type="text" class="input" v-model="form.career_header.sub_title" />
      </div>

      <ImageInput
        :label="trans('Left Image')"
        v-model="form.career_header.image1"
        class="mb-2"
      />
      <ImageInput
        :label="trans('Center Image')"
        v-model="form.career_header.image2"
        class="mb-2"
      />
      <ImageInput
        :label="trans('Top Right Image')"
        v-model="form.career_header.image3"
        class="mb-2"
      />
      <ImageInput
        :label="trans('Right Bottom Image')"
        v-model="form.career_header.image4"
        class="mb-2"
      />
    </div>

    <h6>{{ trans("Our platform section") }}</h6>
    <div class="mb-10 mt-2 rounded border p-3 dark:border-gray-600">
      <div class="mb-2">
        <label>{{ trans("Top title") }}</label>
        <input type="text" class="input" v-model="form.career_platform.top_title" />
      </div>
      <div class="mb-2">
        <label>{{ trans("Title") }}</label>
        <input type="text" class="input" v-model="form.career_platform.title" />
      </div>

      <div class="mb-2">
        <label>{{ trans("Sub title") }}</label>
        <input type="text" class="input" v-model="form.career_platform.sub_title" />
      </div>

      <ImageInput
        :label="trans('Left Image')"
        v-model="form.career_platform.image1"
        class="mb-2"
      />

      <div class="mb-2">
        <label class="mr-2">{{ trans("Platform Items") }}</label>
        <div
          class="mb-2 flex items-center gap-x-2 rounded border p-2 dark:border-gray-600"
          v-for="(item, index) in form.career_platform.items"
          :key="index"
        >
          <span class="rounded-full border border-black p-2 py-1 text-center font-bold">{{
            index + 1
          }}</span>
          <div class="flex flex-grow flex-col gap-1">
            <input type="text" class="input" placeholder="title" v-model="item.title" />
            <textarea class="textarea" v-model="item.body" placeholder="body"> </textarea>
          </div>
          <button type="button" @click="removePlatformItem(index)" class="btn btn-danger">
            X
          </button>
        </div>
        <button type="button" @click="addPlatformItem" class="btn btn-primary">+</button>
      </div>
    </div>

    <h6>{{ trans("Jobs section") }}</h6>
    <div class="mb-10 mt-2 rounded border p-3 dark:border-gray-600">
      <div class="mb-2">
        <label>{{ trans("Title") }}</label>
        <input type="text" class="input" v-model="form.career_jobs.title" />
      </div>

      <div class="mb-2">
        <label>{{ trans("Sub title") }}</label>
        <input type="text" class="input" v-model="form.career_jobs.sub_title" />
      </div>
    </div>

    <div class="mb-2">
      <SpinnerBtn :processing="store.processing" :btn-text="trans('Save Changes')" />
    </div>
  </form>
</template>
