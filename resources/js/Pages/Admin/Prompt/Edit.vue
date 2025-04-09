<script setup>
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
import InputFieldError from '@/Components/InputFieldError.vue'
import trans from '@/Composables/transComposable'
import toast from '@/Composables/toastComposable'
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import { useForm } from '@inertiajs/vue3'

import { ref } from 'vue'
import sharedComposable from '@/Composables/sharedComposable'
defineOptions({ layout: AdminLayout })

const props = defineProps([
  'prompt',
  'buttons',
  'segments',
  'models',
  'image_models',
  'image_ratios',
  'image_sizes'
])

const form = useForm({ ...props.prompt })
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
const submit = () => {
  form.patch(route('admin.prompts.update', props.prompt.id), {
    onSuccess: () => {
      toast.success(trans('Prompt has been updated successfully'))
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
const { trim } = sharedComposable()
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader :title="trans('Edit Prompt')" :buttons="buttons" />

    <div class="mx-auto lg:w-9/12">
      <h3 class="card-title mb-3">{{ trans('Edit Prompt') }}</h3>
      <div class="card card-body mb-5 capitalize">
        {{ form.type }} > {{ form.prompt_type }}
        <span v-if="form.prompt_type == 'image'" class="text-xs capitalize">
          ( {{ trim(form.meta?.image_ai_model) }} )
        </span>
      </div>
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
              <input type="number" v-model="form.credit_charge" step="any" class="input" />
              <InputFieldError :message="form.errors.credit_charge" />
            </div>
            <div v-if="form.prompt_type == 'video'">
              <label class="label mb-1">
                {{ trans('Video length') }} <small>({{ trans('Seconds') }})</small>
              </label>
              <input type="text" v-model="form.meta.seconds" class="input" />
              <InputFieldError :message="form.errors['meta.seconds']" />
            </div>
          </div>
        </div>
        <div
          class="card card-body grid grid-cols-1 gap-x-5 gap-y-4 lg:grid-cols-3"
          v-if="!['image', 'video'].includes(form.prompt_type)"
        >
          <div v-if="form.meta?.ai_model">
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
          class="card card-body grid grid-cols-2 gap-x-5 gap-y-4"
          v-if="form.prompt_type == 'image'"
        >
          <div class="col-span-full mb-2">
            <label class="label mb-1">{{ trans('Negative Prompt') }}</label>
            <textarea v-model="form.meta.negative_prompt" ref="bodyEl" class="textarea"></textarea>
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
          <ul class="mb-3 flex flex-wrap items-center gap-4">
            <li
              v-for="code in shortcodes[form.type]"
              @click="addToPrompt(code)"
              :key="code"
              class="cursor-pointer rounded border p-1"
            >
              {{ code }}
            </li>
          </ul>
          <div class="mb-2">
            <SpinnerBtn :processing="form.processing" :btn-text="trans('Update')" />
          </div>
        </div>
      </form>
    </div>
  </main>
</template>
