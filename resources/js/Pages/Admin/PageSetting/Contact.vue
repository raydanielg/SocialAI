<script setup>
import { ref } from "vue";

import ImageInput from "@/Components/Admin/ImageInput.vue";
import SpinnerBtn from "@/Components/Admin/SpinnerBtn.vue";
import { useOptionUpdateStore } from "@/Store/Admin/optionUpdate";

const props = defineProps(["data"])
const form = ref({ ...props.data })
const store = useOptionUpdateStore()
</script>

<template>
  <form
    method="POST"
    @submit.prevent="store.submit('contact_page', form)"
    enctype="multipart/form-data"
  >
    <h6>{{ trans("Top section") }}</h6>

    <div class="mb-10 mt-2 rounded border p-3 dark:border-gray-600">
      <div class="mb-2">
        <label>{{ trans("Page Title") }}</label>
        <input type="text" class="input" v-model="form.page_title" />
      </div>

      <ImageInput :label="trans('Banner Image')" v-model="form.image" class="mb-2" />

      <div class="flex gap-2">
        <ImageInput
          :label="trans('Office (Left) Image')"
          v-model="form.office_left_img"
          class="mb-2"
        />

        <div class="mb-2">
          <label>{{ trans("Office (Left) Name") }}</label>
          <input type="text" class="input" v-model="form.office_left_name" />
        </div>
        <div class="mb-2">
          <label>{{ trans("Office (Left) Address") }}</label>
          <input type="text" class="input" v-model="form.office_left_address" />
        </div>
      </div>

      <div class="flex gap-2">
        <ImageInput
          :label="trans('Office (Center) Image')"
          v-model="form.office_center_img"
          class="mb-2"
        />

        <div class="mb-2">
          <label>{{ trans("Office (Center) Name") }}</label>
          <input type="text" class="input" v-model="form.office_center_name" />
        </div>
        <div class="mb-2">
          <label>{{ trans("Office (Center) Address") }}</label>
          <input type="text" class="input" v-model="form.office_center_address" />
        </div>
      </div>

      <div class="flex gap-2">
        <ImageInput
          :label="trans('Office (Center) Image')"
          v-model="form.office_right_img"
          class="mb-2"
        />

        <div class="mb-2">
          <label>{{ trans("Office (Right) Name") }}</label>
          <input type="text" class="input" v-model="form.office_right_name" />
        </div>
        <div class="mb-2">
          <label>{{ trans("Office (Right) Address") }}</label>
          <input type="text" class="input" v-model="form.office_right_address" />
        </div>
      </div>
    </div>

    <h6>{{ trans("Contact form left section") }}</h6>
    <div class="mb-10 mt-2 rounded border p-3 dark:border-gray-600">
      <div class="mb-2">
        <label>{{ trans("Top Title") }}</label>
        <input type="text" class="input" v-model="form.top_title" />
      </div>
   
      <div class="mb-2">
        <label>{{ trans("Sub Title") }}</label>
        <input type="text" class="input" v-model="form.sub_title" />
      </div>
      <div class="mb-2">
        <label>{{ trans("facebook") }}</label>
        <input type="url" class="input" v-model="form.facebook" />
      </div>
      <div class="mb-2">
        <label>{{ trans("twitter") }}</label>
        <input type="url" class="input" v-model="form.twitter" />
      </div>
      <div class="mb-2">
        <label>{{ trans("linkedin") }}</label>
        <input type="url" class="input" v-model="form.linkedin" />
      </div>
      <div class="mb-2">
        <label>{{ trans("instagram") }}</label>
        <input type="url" class="input" v-model="form.instagram" />
      </div>

      <ImageInput
        :label="trans('Left Image')"
        v-model="form.left_img"
        class="mb-2"
      />

    </div>

    <h6>{{ trans("Book A Demo Section") }}</h6>
    <div class="mb-10 mt-2 rounded border p-3 dark:border-gray-600">
      <div class="mb-2">
        <label>{{ trans("Title") }}</label>
        <input type="text" class="input" v-model="form.bottom_title" />
      </div>
      <div class="mb-2">
        <label>{{ trans("Sub Title") }}</label>
        <input type="text" class="input" v-model="form.bottom_sub_title" />
      </div>

      <ImageInput
        :label="trans('Email Image')"
        v-model="form.bottom_email_img"
        class="mb-2"
      />

      <div class="mb-2">
        <label>{{ trans("Email") }}</label>
        <input type="email" class="input" v-model="form.email" />
      </div>

      <ImageInput
        :label="trans('Phone Image')"
        v-model="form.bottom_phone_img"
        class="mb-2"
      />

      <div class="mb-2">
        <label>{{ trans("Phone") }}</label>
        <input type="text" class="input" v-model="form.phone" />
      </div>

      <ImageInput
        :label="trans('Address Image')"
        v-model="form.bottom_address_img"
        class="mb-2"
      />

      <div class="mb-2">
        <label>{{ trans("Address") }}</label>
        <input type="text" class="input" v-model="form.address" />
      </div>
    </div>

    <div class="mb-2">
      <SpinnerBtn :processing="store.processing" :btn-text="trans('Save Changes')" />
    </div>
  </form>
</template>
