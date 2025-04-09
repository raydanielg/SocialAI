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
  let properties = ["hero", "list", "slider"]
  properties.forEach((key) => (form.value[key] = form.value[key] || {}))

  if (!props.data.slider?.row_one?.length) {
    props.data.slider.row_one = [{ ...defaultIntegration }];
  }
  if (!props.data.slider?.row_two?.length) {
    props.data.slider.row_two = [{ ...defaultIntegration }];
  }

})

const defaultIntegration = {
  preview: "",
};


const addIntegrationRowOneItem = () => {
  props.data?.slider?.row_one?.push({ ...defaultIntegration });
};

const removeIntegrationRowOneItem = (index) => {
  props.data?.slider?.row_one?.splice(index, 1);
};

const addIntegrationRowTwoItem = () => {
  props.data?.slider?.row_two?.push({ ...defaultIntegration });
};

const removeIntegrationRowTwoItem = (index) => {
  props.data?.slider?.row_two?.splice(index, 1);
};
</script>

<template>
  <form method="POST" @submit.prevent="store.submit('integration_page', form)" enctype="multipart/form-data">
    <h6>{{ trans("Banner Section") }}</h6>
    <div class="mb-10 mt-2 rounded border p-3 dark:border-gray-600">
      <div class="mb-2">
        <label>{{ trans("Title") }}</label>
        <input type="text" class="input" v-model="form.hero.title" />
      </div>
      <ImageInput :label="trans('Banner Image')" v-model="form.hero.banner_img" class="mb-2" />
    </div>

    <h6>{{ trans("List Section") }}</h6>
    <div class="mb-10 mt-2 rounded border p-3 dark:border-gray-600">
      <div class="mb-2">
        <label>{{ trans("Title") }}</label>
        <input type="text" class="input" v-model="form.list.title" />
      </div>
      <div class="mb-2">
        <label>{{ trans("Sub Title") }}</label>
        <input type="text" class="input" v-model="form.list.sub_title" />
      </div>
    </div>

    <h6>{{ trans("Integrated with Your Favorite Apps") }}</h6>
    <div class="mb-10 mt-2 rounded border p-3 dark:border-gray-600">
      <div class="mb-2">
        <label>{{ trans("Top Title") }}</label>
        <input type="text" class="input" v-model="data.slider.top_title" />
      </div>

      <div class="mb-2">
        <label>{{ trans("Title") }}</label>
        <input type="text" class="input mb-1" v-model="data.slider.title" />
        <small>Note: use <code>&lt;span&gt;text&lt;/span&gt;</code> to make text
          italic and <code>&lt;br/&gt;</code> to line break
        </small>
      </div>

      <label class="mr-2">{{ trans("Slider Items") }}</label>
      <div class="grid grid-cols-2 gap-2">
        <div>
          <div class="mb-2 flex items-center justify-between">
            <p>{{ trans("Row One") }}</p>
            <button type="button" @click="addIntegrationRowOneItem" class="btn btn-primary me-2">
              +
            </button>
          </div>
          <div class="mb-2 flex items-center justify-between gap-x-2 border p-2 dark:border-gray-600"
            v-for="(item, index) in data.slider.row_one" :key="index">
            <span class="rounded-full bg-indigo-600 p-2 py-1 text-center text-white">{{ index + 1 }}</span>
            <div class="flex w-full gap-2">
              <ImageInput v-model="item.preview" class="w-full" />
              <button type="button" @click="removeIntegrationRowOneItem(index)" class="btn btn-danger">
                X
              </button>
            </div>
          </div>
        </div>

        <div>
          <div class="mb-2 flex items-center justify-between">
            <p>{{ trans("Row Two") }}</p>
            <button type="button" @click="addIntegrationRowTwoItem" class="btn btn-primary me-2">
              +
            </button>
          </div>
          <div class="mb-2 flex items-center justify-between gap-x-2 border p-2 dark:border-gray-600"
            v-for="(item, index) in data.slider.row_two" :key="index">
            <span class="rounded-full bg-indigo-600 p-2 py-1 text-center text-white">{{ index + 1 }}</span>
            <div class="flex w-full gap-2">
              <ImageInput v-model="item.preview" class="w-full" />
              <button type="button" @click="removeIntegrationRowTwoItem(index)" class="btn btn-danger">
                X
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="mb-2">
      <SpinnerBtn :processing="store.processing" :btn-text="trans('Save Changes')" />
    </div>
  </form>
</template>
