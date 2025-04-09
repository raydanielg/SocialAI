<script setup>
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
import InputFieldError from '@/Components/InputFieldError.vue'
import sharedComposable from '@/Composables/sharedComposable'
import toast from '@/Composables/toastComposable'
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import { useForm } from '@inertiajs/vue3'

import { ref } from 'vue'
defineOptions({ layout: AdminLayout })

const { pickBy } = sharedComposable()
const props = defineProps([
  'buttons',
  'segments',
  'models',
  'image_models',
  'image_ratios',
  'image_sizes'
])
const list = {
  brand: [
    {
      title: 'slogan',
      icon: 'bx-label'
    },

    {
      title: 'identity',
      icon: 'bx-fingerprint'
    },
    {
      title: 'audience',
      icon: 'bx-group'
    },
    {
      title: 'strategy',
      icon: 'bx-bulb'
    },
    {
      title: 'voice-tone',
      icon: 'bx-user-voice'
    },
    {
      title: 'voice',
      icon: 'bxs-microphone-alt'
    }
  ],

  content: [
    {
      title: 'post',
      icon: 'bx-news'
    },
    {
      title: 'image',
      icon: 'bx-image'
    }
  ]
}
const shortcodes = {
  brand: ['[category]', '[description]', '[name]'],
  content: [
    '[description]',
    '[slogan]',
    '[category]',
    '[identity]',
    '[audience]',
    '[strategy]',
    '[voices]',
    '[brand_name]',
    '[post_description]'
  ]
}
const form = useForm({
  title: '',
  status: '',
  type: '',
  prompt: '',
  prompt_type: '',
  max_token: 0,
  credit_charge: 0,
  meta: {
    ai_model: '',
    image_ai_model: '',
    max_word: null,
    aspect_ratio: null,
    image_size: null,
    image_quality: null,
    image_height: null,
    image_width: null,
    guidance_scale: null,
    negative_prompt: null,
    seed: null,
    seconds: null
  }
})

const submit = () => {
  form.post(route('admin.prompts.store'), {
    onSuccess: () => {
      toast.success('Prompt has been added successfully')
      form.reset()
    }
  })
}

const bodyEl = ref('')
const addToPrompt = (code) => {
  let curPos = bodyEl.value.selectionStart
  let text = form.prompt
  form.prompt = text.slice(0, curPos) + code + text.slice(curPos)

  let focusPosition = curPos + code.length
  setTimeout(() => {
    bodyEl.value.setSelectionRange(focusPosition, focusPosition)
    bodyEl.value.focus()
  }, 100)
}
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader :title="trans('Create Prompt')" :buttons="buttons" />
    <div class="mx-auto lg:w-9/12">
      <template v-if="form.type && form.prompt_type">
        <h3 class="card-title mb-3">{{ trans('Create New Prompt') }}</h3>
        <div class="card card-body mb-5 capitalize">{{ form.type }} > {{ form.prompt_type }}</div>
        <form @submit.prevent="submit" class="space-y-7">
          <div class="card card-body">
            <div class="mb-2">
              <label class="label mb-1">{{ trans('Title') }}</label>
              <input type="text" v-model="form.title" class="input" />
              <InputFieldError :message="form.errors.title" />
            </div>

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
              <div>
                <label class="label mb-1">{{ trans('Status') }}</label>
                <select class="select capitalize" v-model="form.status">
                  <option value="" disabled selected>Select</option>
                  <option v-for="status in ['active', 'inactive']" :value="status" :key="status">
                    {{ status }}
                  </option>
                </select>
                <InputFieldError :message="form.errors.status" />
                <small>* Only 1 prompt will be active for 1 category</small>
              </div>
              <div class="mb-2">
                <label class="label mb-1">{{ trans('Credit Charge') }}</label>
                <input type="number" step="any" v-model="form.credit_charge" class="input" />
                <InputFieldError :message="form.errors.credit_charge" />
              </div>
              <div v-if="form.prompt_type == 'video'">
                <label class="label mb-1">
                  {{ trans('Video length') }} <small>({{ trans('Seconds') }})</small>
                </label>
                <input type="text" v-model="form.meta.seconds" class="input" />
                <InputFieldError :message="form.errors['meta.seconds']" />
              </div>
              <div v-if="['image'].includes(form.prompt_type)">
                <label class="label mb-1">{{ trans('Ai Model') }}*</label>
                <select class="select capitalize" v-model="form.meta.image_ai_model">
                  <option value="" disabled selected>Select</option>
                  <option v-for="model in image_models" :value="model" :key="model">
                    {{ model }}
                  </option>
                </select>
                <InputFieldError :message="form.errors['meta.image_ai_model']" />
              </div>
            </div>
          </div>

          <div
            class="card card-body grid grid-cols-1 gap-x-5 gap-y-4 lg:grid-cols-3"
            v-if="!['image', 'video'].includes(form.prompt_type)"
          >
            <div>
              <label class="label mb-1">{{ trans('Ai Model') }}*</label>
              <select class="select capitalize" v-model="form.meta.ai_model">
                <option value="" disabled selected>Select</option>
                <option v-for="model in models" :value="model" :key="model">
                  {{ model }}
                </option>
              </select>
              <InputFieldError :message="form.errors['meta.ai_model']" />
            </div>
            <div class="mb-2">
              <label class="label mb-1">{{ trans('Max Token') }}</label>
              <input type="number" v-model="form.max_token" class="input" />
              <InputFieldError :message="form.errors.max_token" />
            </div>
            <div class="mb-2">
              <label class="label mb-1">{{ trans('Max Word') }}</label>
              <input type="number" v-model="form.meta.max_word" class="input" />
              <InputFieldError :message="form.errors['meta.max_word']" />
            </div>
          </div>
          <div
            class="card card-body grid grid-cols-3 gap-x-5 gap-y-4"
            v-if="form.prompt_type == 'image'"
          >
            <div class="col-span-full mb-2">
              <label class="label mb-1">{{ trans('Negative Prompt') }}</label>
              <textarea
                v-model="form.meta.negative_prompt"
                ref="bodyEl"
                class="textarea"
              ></textarea>
              <InputFieldError :message="form.errors['meta.negative_prompt']" />
            </div>
            <template v-if="form.meta?.image_ai_model == 'stablediffusion'">
              <div class="mb-2">
                <label class="label mb-1">{{ trans('Image Width') }}</label>
                <div class="flex">
                  <input
                    step="8"
                    v-model="form.meta.image_width"
                    class="w-full cursor-pointer accent-primary-600"
                    type="range"
                    min="250"
                    max="1024"
                  />
                  <span class="label card w-20 rounded-md px-2 py-1 text-center">
                    {{ form.meta.image_width }} px
                  </span>
                </div>
                <p class="text-sm">* Width and Height should be same px</p>
                <InputFieldError :message="form.errors['meta.image_width']" />
              </div>
              <div class="mb-2">
                <label class="label mb-1">{{ trans('Image Height') }}</label>
                <div class="flex">
                  <input
                    step="8"
                    v-model="form.meta.image_height"
                    class="w-full cursor-pointer accent-primary-600"
                    type="range"
                    min="250"
                    max="1024"
                  />
                  <span class="label card w-20 rounded-md px-2 py-1 text-center">
                    {{ form.meta.image_height }} px
                  </span>
                </div>
                <p class="text-sm">* Width and Height should be same px</p>
                <InputFieldError :message="form.errors['meta.image_height']" />
              </div>
              <div class="mb-2">
                <label class="label mb-1">{{ trans('Guidance Scale') }}</label>
                <div class="flex">
                  <input
                    step="2"
                    v-model="form.meta.guidance_scale"
                    class="w-full cursor-pointer accent-primary-600"
                    type="range"
                    min="0"
                    max="20"
                  />
                  <span class="label card w-20 rounded-md px-2 py-1 text-center">
                    {{ form.meta.guidance_scale }}
                  </span>
                </div>
                <InputFieldError :message="form.errors['meta.guidance_scale']" />
              </div>
            </template>
            <div class="col-span-full flex gap-2">
              <template v-if="form.meta?.image_ai_model == 'stability_ai'">
                <div class="flex-1">
                  <label class="label mb-1">{{ trans('Image Aspect Ratio') }}*</label>
                  <select class="select capitalize" v-model="form.meta.aspect_ratio">
                    <option value="null" disabled selected>Select</option>
                    <option v-for="ratio in image_ratios" :value="ratio" :key="ratio">
                      {{ ratio }}
                    </option>
                  </select>
                  <InputFieldError :message="form.errors['meta.aspect_ratio']" />
                </div>
              </template>
              <template v-if="form.meta?.image_ai_model == 'dalle_3'">
                <div class="flex-1">
                  <label class="label mb-1">{{ trans('Image Size') }}*</label>
                  <select class="select capitalize" v-model="form.meta.image_size">
                    <option value="null" disabled selected>Select</option>
                    <option v-for="size in image_sizes" :value="size" :key="size">
                      {{ size }}
                    </option>
                  </select>
                  <InputFieldError :message="form.errors['meta.image_size']" />
                </div>
                <div class="flex-1">
                  <label class="label mb-1">{{ trans('Image Quality') }}*</label>
                  <select class="select capitalize" v-model="form.meta.image_quality">
                    <option value="null" disabled selected>Select</option>
                    <option v-for="quality in ['standard', 'hd']" :value="quality" :key="quality">
                      {{ quality }}
                    </option>
                  </select>
                  <InputFieldError :message="form.errors['meta.image_quality']" />
                </div>
              </template>
              <div
                class="mb-2 flex-1"
                v-if="
                  form.meta?.image_ai_model == 'stablediffusion' ||
                  form.meta?.image_ai_model == 'stability_ai'
                "
              >
                <label class="label mb-1">{{ trans('Seed') }}</label>
                <input type="number" v-model="form.meta.seed" class="input" />
                <InputFieldError :message="form.errors['meta.seed']" />
              </div>
            </div>
          </div>
          <div class="card card-body">
            <div class="mb-2">
              <label class="label mb-1">{{ trans('Prompt') }}</label>
              <textarea v-model="form.prompt" ref="bodyEl" class="textarea"></textarea>
              <InputFieldError :message="form.errors.prompt" />
            </div>
            <div class="flex gap-2">
              <label class="label mb-1 mt-1">Shortcodes: </label>
              <ul v-if="form.type" class="mb-3 flex flex-wrap items-center gap-4">
                <li
                  v-for="code in shortcodes[form.type]"
                  @click="addToPrompt(code)"
                  :key="code"
                  class="cursor-pointer rounded border p-1"
                >
                  {{ code }}
                </li>
              </ul>
            </div>
            <div class="mb-2 flex items-center gap-x-3">
              <SpinnerBtn :processing="form.processing" :btn-text="trans('Create ')" />
              <button class="btn btn-dark" @click="() => form.reset()">Reset</button>
            </div>
          </div>
        </form>
      </template>

      <template v-else>
        <div class="mt-20 grid grid-cols-2 gap-4">
          <button
            class="card flex h-28 items-center justify-center gap-2 rounded-md text-xl capitalize hover:bg-secondary-200 dark:hover:bg-secondary-900"
            :class="{ 'border border-primary-600': form.type == key }"
            v-for="(value, key) in list"
            :key="key"
            @click="
              () => {
                form.type = key
                form.prompt_type = ''
              }
            "
          >
            <i v-if="key == 'brand'" class="bx bx-layout text-3xl"></i>
            <i v-if="key == 'content'" class="bx bx-book-content text-3xl"></i>
            <span class="mb-px">{{ key }}</span>
          </button>
        </div>
        <div class="mt-5 grid grid-cols-2 gap-4 lg:grid-cols-4" v-if="form.type">
          <button
            class="card flex h-20 items-center justify-center gap-2 rounded-md text-sm capitalize hover:bg-secondary-200 dark:hover:bg-secondary-900"
            :class="{ 'border border-primary-600': form.prompt_type == item }"
            v-for="item in list[form.type]"
            :key="item"
            @click="form.prompt_type = item.title"
          >
            <i class="bx text-2xl" :class="item.icon"></i>
            <span class="mb-1">{{ item.title }}</span>
          </button>
        </div>
      </template>
    </div>
  </main>
</template>
