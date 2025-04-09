<script setup>
import { onBeforeMount } from 'vue'

import ImageInput from '@/Components/Admin/ImageInput.vue'
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
import { useOptionUpdateStore } from '@/Store/Admin/optionUpdate'

const props = defineProps(['data'])
const form = useOptionUpdateStore()

const defaultReview = {
  ratting: 5,
  comment: '',
  image: ''
}

const defaultIcon = {
  icon: '',
  link: '',
  title: ''
}

const defaultIntegration = {
  preview: ''
}

onBeforeMount(() => {
  let properties = ['hero', 'counter', 'service', 'rated', 'integration', 'cta_s3']

  properties.forEach((key) => (props.data[key] = props.data[key] || {}))

  if (!props.data.hero?.icons?.length) {
    props.data.hero.icons = [{ ...defaultIcon }]
  }

  if (!props.data.rated?.reviews?.length) {
    props.data.rated.reviews = [{ ...defaultReview }]
  }
  if (!props.data.cta_s3?.icons?.length) {
    props.data.cta_s3.icons = [{ ...defaultIcon }]
  }

  if (!props.data.integration?.row_one?.length) {
    props.data.integration.row_one = [{ ...defaultIntegration }]
  }
  if (!props.data.integration?.row_two?.length) {
    props.data.integration.row_two = [{ ...defaultIntegration }]
  }
})

// hero browser icons
const addItem = () => {
  props.data?.hero?.icons?.push({ ...defaultIcon })
}

const removeItem = (index) => {
  props.data?.hero?.icons?.splice(index, 1)
}

// review items
const addReviewItem = () => {
  if (props.data?.rated?.reviews?.length >= 3) {
    return
  }
  props.data?.rated?.reviews?.push({ ...defaultReview })
}

const removeReviewItem = (index) => {
  props.data?.rated?.reviews?.splice(index, 1)
}

// cta s3 browser icons
const addCta3Item = () => {
  props.data?.cta_s3?.icons?.push({ ...defaultIcon })
}

const removeCta3Item = (index) => {
  props.data?.cta_s3?.icons?.splice(index, 1)
}

const addIntegrationRowOneItem = () => {
  props.data?.integration?.row_one?.push({ ...defaultIntegration })
}

const removeIntegrationRowOneItem = (index) => {
  props.data?.integration?.row_one?.splice(index, 1)
}

const addIntegrationRowTwoItem = () => {
  props.data?.integration?.row_two?.push({ ...defaultIntegration })
}

const removeIntegrationRowTwoItem = (index) => {
  props.data?.integration?.row_two?.splice(index, 1)
}
</script>

<template>
  <form @submit.prevent="form.submit('home_page', data)">
    <h6>{{ trans('Hero Section') }}</h6>
    <div class="mb-10 mt-2 rounded border p-3 dark:border-gray-600">
      <div class="mb-2">
        <label>{{ trans('Title') }}</label>
        <input type="text" class="input" v-model="data.hero.title" />
        <small
          >Note: use <code>&lt;span&gt;text&lt;/span&gt;</code> to make text italic and
          <code>&lt;br/&gt;</code> to line break
        </small>
      </div>

      <div class="mb-2">
        <label>{{ trans('Sub title') }}</label>
        <input type="text" class="input" v-model="data.hero.subtitle" />
      </div>

      <div class="mb-2">
        <label>{{ trans('Left Button Text') }}</label>
        <input type="text" class="input" v-model="data.hero.btn_one_text" />
      </div>

      <div class="mb-2">
        <label>{{ trans('Left Button Link') }}</label>
        <input type="url" class="input" v-model="data.hero.btn_one_link" />
      </div>
      <div class="mb-2">
        <label>{{ trans('Right Button Text') }}</label>
        <input type="text" class="input" v-model="data.hero.btn_two_text" />
      </div>

      <div class="mb-2">
        <label>{{ trans('Right Button Link') }}</label>
        <input type="url" class="input" v-model="data.hero.btn_two_link" />
      </div>

      <div class="mb-2">
        <label class="mr-2">{{ trans('Bottom Icons') }}</label>
        <div
          class="mb-2 flex items-center justify-between gap-x-2 rounded border p-2 dark:border-gray-600"
          v-for="(item, index) in data.hero.icons"
          :key="index"
        >
          <span class="rounded-full bg-indigo-600 p-2 py-1 text-center text-white">{{
            index + 1
          }}</span>
          <div class="flex justify-between gap-3">
            <ImageInput v-model="item.icon" class="w-full" />
            <input type="text" class="input" placeholder="title" v-model="item.title" />
            <input type="text" class="input" placeholder="link" v-model="item.link" />
          </div>
          <button type="button" @click="removeItem(index)" class="btn btn-danger">X</button>
        </div>
        <button type="button" @click="addItem" class="btn btn-primary">+</button>
      </div>

      <ImageInput v-model="data.hero.bottom_img" label="Bottom Image" class="mb-2" />
      <ImageInput
        v-model="data.hero.bottom_bg_overflow"
        label="Bottom BG Left Overflow Image"
        class="mb-2"
      />
    </div>

    <h6>{{ trans('Counter Section') }}</h6>
    <div class="mb-10 mt-2 rounded border p-3 dark:border-gray-600">
      <div class="grid grid-cols-2 gap-2" v-for="item in ['one', 'two', 'three']" :key="item">
        <div class="mb-2">
          <label>{{ trans(`Counter ${item} title`) }}</label>
          <input type="text" class="input" v-model="data.counter[`${item}_title`]" />
        </div>
        <div class="mb-2">
          <label>{{ trans(`Counter ${item} subtitle`) }}</label>
          <input type="text" class="input" v-model="data.counter[`${item}_subtitle`]" />
        </div>
      </div>
    </div>

    <h6>{{ trans('Service Section') }}</h6>
    <div class="mb-10 mt-2 rounded border p-3 dark:border-gray-600">
      <div class="mb-2">
        <label>{{ trans('Title') }}</label>
        <input type="text" class="input" v-model="data.service.title" />
        <small
          >Note: use <code>&lt;span&gt;text&lt;/span&gt;</code> to make text italic and
          <code>&lt;br/&gt;</code> to line break
        </small>
      </div>

      <div class="mb-2">
        <label>{{ trans('Right Button Text') }}</label>
        <input type="text" class="input" v-model="data.service.btn_text" />
      </div>

      <div class="mb-2">
        <label>{{ trans('Right Button Link') }}</label>
        <input type="url" class="input" v-model="data.service.btn_link" />
      </div>
      <ImageInput v-model="data.service.bg_img" label="Background Image" class="mb-2" />
      <ImageInput
        v-model="data.service.bg_bottom_right_image"
        label="BG bottom-right Image"
        class="mb-2"
      />
    </div>

    <h6>{{ trans('Rated Section') }}</h6>
    <div class="mb-10 mt-2 rounded border p-3 dark:border-gray-600">
      <div class="mb-2">
        <label>{{ trans('Title') }}</label>
        <input type="text" class="input" v-model="data.rated.title" />
        <small
          >Note: use <code>&lt;span&gt;text&lt;/span&gt;</code> to make text italic and
          <code>&lt;br/&gt;</code> to line break
        </small>
      </div>

      <!-- btn -->
      <div class="mb-2">
        <label>{{ trans('Button Text') }}</label>
        <input type="text" class="input" v-model="data.rated.btn_text" />
      </div>

      <div class="mb-2">
        <label>{{ trans('Button Link') }}</label>
        <input type="url" class="input" v-model="data.rated.btn_link" />
      </div>

      <ImageInput v-model="data.rated.bg_img" label="Background Image" class="mb-2" />
      <ImageInput v-model="data.rated.bg_top_left_image" label="BG top-left shape" class="mb-2" />

      <ImageInput v-model="data.rated.bg_top_right_image" label="BG top-right shape" class="mb-2" />

      <ImageInput
        v-model="data.rated.bg_bottom_center_image"
        label="BG bottom-center Image"
        class="mb-2"
      />

      <!-- add review items with ratting,image,comment -->
      <div class="mb-2">
        <label class="mr-2">{{ trans('Reviews') }}</label>
        <div
          class="mb-2 flex items-center justify-between gap-x-2 border p-2 dark:border-gray-600"
          v-for="(item, index) in data.rated.reviews"
          :key="index"
        >
          <span class="rounded-full bg-indigo-600 p-2 py-1 text-center text-white">{{
            index + 1
          }}</span>
          <div class="flex flex-grow gap-2">
            <select class="input w-1/4" v-model="item.ratting">
              <option value="">{{ trans('Ratting') }}</option>
              <option v-for="i in 5" :key="i" :value="i">{{ i }}</option>
            </select>
            <input type="text" class="input" placeholder="comment" v-model="item.comment" />
            <ImageInput v-model="item.image" class="w-full" />
          </div>
          <button type="button" @click="removeReviewItem(index)" class="btn btn-danger">X</button>
        </div>
        <button type="button" @click="addReviewItem" class="btn btn-primary">+</button>
      </div>
    </div>

    <h6>{{ trans('Manage Cards CTA Section') }}</h6>
    <div class="mb-10 mt-2 rounded border p-3 dark:border-gray-600">
      <button class="tabs-btn" type="button" data-panel-id="#primary">
        {{ trans('See in primary settings') }}
      </button>
    </div>

    <h6>{{ trans('Track and Analyze Sales CTA Section') }}</h6>
    <div class="mb-10 mt-2 rounded border p-3 dark:border-gray-600">
      <button class="tabs-btn" type="button" data-panel-id="#primary">
        {{ trans('See in primary settings') }}
      </button>
    </div>

    <h6>{{ trans('Integration section') }}</h6>
    <div class="mb-10 mt-2 rounded border p-3 dark:border-gray-600">
      <div class="mb-2">
        <label>{{ trans('Top Title') }}</label>
        <input type="text" class="input" v-model="data.integration.top_title" />
      </div>
      <div class="mb-2">
        <label>{{ trans('Title') }}</label>
        <input type="text" class="input" v-model="data.integration.title" />
        <small
          >Note: use <code>&lt;span&gt;text&lt;/span&gt;</code> to make text italic and
          <code>&lt;br/&gt;</code> to line break
        </small>
      </div>

      <div class="mb-2">
        <label>{{ trans('Button Text') }}</label>
        <input type="text" class="input" v-model="data.integration.btn_text" />
      </div>

      <div class="mb-2">
        <label>{{ trans('Button Link') }}</label>
        <input type="text" class="input" v-model="data.integration.btn_link" />
      </div>

      <label class="mr-2">{{ trans('Integration Items') }}</label>
      <div class="grid grid-cols-2 gap-2">
        <div>
          <div class="mb-2 flex items-center justify-between">
            <p>{{ trans('Row One') }}</p>
            <button type="button" @click="addIntegrationRowOneItem" class="btn btn-primary me-2">
              +
            </button>
          </div>
          <div
            class="mb-2 flex items-center justify-between gap-x-2 border p-2 dark:border-gray-600"
            v-for="(item, index) in data.integration.row_one"
            :key="index"
          >
            <span class="rounded-full bg-indigo-600 p-2 py-1 text-center text-white">{{
              index + 1
            }}</span>
            <div class="flex w-full gap-2">
              <ImageInput v-model="item.preview" class="w-full" />
              <button
                type="button"
                @click="removeIntegrationRowOneItem(index)"
                class="btn btn-danger"
              >
                X
              </button>
            </div>
          </div>
        </div>

        <div>
          <div class="mb-2 flex items-center justify-between">
            <p>{{ trans('Row Two') }}</p>
            <button type="button" @click="addIntegrationRowTwoItem" class="btn btn-primary me-2">
              +
            </button>
          </div>
          <div
            class="mb-2 flex items-center justify-between gap-x-2 border p-2 dark:border-gray-600"
            v-for="(item, index) in data.integration.row_two"
            :key="index"
          >
            <span class="rounded-full bg-indigo-600 p-2 py-1 text-center text-white">{{
              index + 1
            }}</span>
            <div class="flex w-full gap-2">
              <ImageInput v-model="item.preview" class="w-full" />
              <button
                type="button"
                @click="removeIntegrationRowTwoItem(index)"
                class="btn btn-danger"
              >
                X
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <h6>{{ trans('Home Footer Section') }}</h6>
    <div>
      <div class="mb-2">
        <label>{{ trans('Title') }}</label>
        <input type="text" class="input" v-model="data.cta_s3.title" />
        <small
          >Note: use <code>&lt;span&gt;text&lt;/span&gt;</code> to make text italic and
          <code>&lt;br/&gt;</code> to line break
        </small>
      </div>

      <div class="mb-2">
        <label>{{ trans('Button Text') }}</label>
        <input type="text" class="input" v-model="data.cta_s3.btn_text" />
      </div>

      <div class="mb-2">
        <label>{{ trans('Button Link') }}</label>
        <input type="url" class="input" v-model="data.cta_s3.btn_link" />
      </div>

      <div class="mb-2">
        <label class="mr-2">{{ trans('Bottom Icons') }}</label>
        <div
          class="mb-2 flex items-center justify-between gap-x-2 border p-2 dark:border-gray-600"
          v-for="(item, index) in data.cta_s3.icons"
          :key="index"
        >
          <span class="rounded-full bg-indigo-600 p-2 py-1 text-center text-white">{{
            index + 1
          }}</span>
          <div class="flex gap-2">
            <ImageInput v-model="item.icon" class="w-full" />
            <input type="text" class="input" placeholder="title" v-model="item.title" />
            <input type="url" class="input" placeholder="link" v-model="item.link" />
          </div>
          <button type="button" @click="removeCta3Item(index)" class="btn btn-danger">X</button>
        </div>
        <button type="button" @click="addCta3Item" class="btn btn-primary">+</button>
      </div>
      <div class="mb-2">
        <label>{{ trans('List items') }}</label>
        <input type="text" class="input" v-model="data.cta_s3.list_items" />
        <small>{{ trans('use (,) to separate') }}</small>
      </div>
    </div>

    <div class="mb-2">
      <SpinnerBtn :processing="form.processing" :btn-text="trans('Save Changes')" />
    </div>
  </form>
</template>
