<script setup>
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
import InputFieldError from '@/Components/InputFieldError.vue'
import sharedComposable from '@/Composables/sharedComposable'
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import toast from '@/Composables/toastComposable'
import { useForm } from '@inertiajs/vue3'

import { ref } from 'vue'
defineOptions({ layout: AdminLayout })
const { trim } = sharedComposable()
const props = defineProps([
  'template',
  'buttons',
  'segments',
  'models',
  'voices',
  'image_models',
  'image_ratios',
  'image_sizes',
  'instructions'
])
const list = [
  {
    title: 'text',
    icon: 'bx-news'
  },
  {
    title: 'image',
    icon: 'bx-image'
  },
  {
    title: 'video',
    icon: 'bxs-videos'
  },
  {
    title: 'audio',
    icon: 'bxs-microphone-alt'
  },
  {
    title: 'voice_clone',
    icon: 'bx-user-voice'
  }
]
const creditChargeKey = {
  text: 'word',
  video: 'seconds',
  voice_clone: 'clone',
  image: 'image',
  audio: 'audio'
}
const defaultInputFieldItem = {
  type: '',
  name: '',
  placeholder: '',
  value: ''
}

const form = useForm({
  ...props.template,
  fields: props.template?.fields ?? [{ ...defaultInputFieldItem }],
  _method: 'put'
})

const addNewField = () => {
  form.fields.push({ ...defaultInputFieldItem })
}

const removeField = (index) => {
  form.fields.splice(index, 1)
}

const submit = () => {
  form.post(route('admin.ai-templates.update', props.template), {
    onSuccess: () => {
      toast.success('Template has been updated successfully')
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
    <PageHeader :title="trans('Edit Template')" :buttons="buttons" />

    <div class="mx-auto lg:w-9/12">
      <h3 class="card-title mb-3">
        {{ trans('Edit Template') }}
        <span v-if="template.ai_model" class="text-xs capitalize"
          >( {{ trim(template.ai_model) }} )</span
        >
      </h3>

      <form @submit.prevent="submit" class="space-y-7">
        <div class="mt-2 grid grid-cols-2 gap-4 lg:grid-cols-3">
          <template v-for="item in list" :key="item.title">
            <button
              v-if="form.prompt_type == item.title"
              type="button"
              class="card flex h-20 items-center justify-center gap-2 rounded-md text-sm capitalize hover:bg-secondary-950"
              :class="{ 'border border-primary-600': form.prompt_type == item.title }"
              @click="form.prompt_type = item.title"
            >
              <i class="bx text-2xl" :class="item.icon"></i>
              <span class="mb-1">{{ item.title }}</span>
            </button>
          </template>
        </div>
        <div class="card card-body">
          <div class="mb-2">
            <label class="label mb-1">{{ trans('Title') }}</label>
            <input type="text" v-model="form.title" class="input" />
            <InputFieldError :message="form.errors.title" />
          </div>
          <div class="mb-2">
            <label class="label mb-1">{{ trans('Description') }}</label>
            <textarea v-model="form.description" class="textarea"></textarea>
            <InputFieldError :message="form.errors.description" />
          </div>

          <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
            <div class="mb-2">
              <label class="label mb-1">{{ trans('Icon') }}</label>
              <input
                type="file"
                accept="image/*"
                @change="(e) => (form.icon = e.target.files[0])"
                class="input"
              />
              <InputFieldError :message="form.errors.icon" />
            </div>

            <div class="mb-2">
              <label class="label mb-1">{{ trans('Preview') }}</label>
              <input
                type="file"
                accept="image/*"
                @change="(e) => (form.preview = e.target.files[0])"
                class="input"
              />
              <InputFieldError :message="form.errors.preview" />
            </div>
          </div>

          <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
            <div>
              <label class="label mb-1">{{ trans('Status') }}</label>
              <select class="select capitalize" v-model="form.status">
                <option value="" disabled selected>Select</option>
                <option v-for="t in ['active', 'draft']" :value="t" :key="t">
                  {{ t }}
                </option>
              </select>
              <InputFieldError :message="form.errors.status" />
            </div>

            <div>
              <label class="label mb-1">
                {{ trans('Credit Charge') }}
                <small>({{ trans('per') }} {{ creditChargeKey[form.prompt_type] }})</small>
              </label>
              <input type="number" v-model="form.credit_charge" class="input" />
              <InputFieldError :message="form.errors.credit_charge" />
            </div>
          </div>
        </div>
        <!-- image -->
        <div
          class="card card-body grid grid-cols-2 gap-x-5 gap-y-4"
          v-if="form.prompt_type == 'image'"
        >
          <div class="col-span-full mb-2">
            <label class="label mb-1">{{ trans('Negative Prompt') }}</label>
            <textarea v-model="form.meta.negative_prompt" ref="bodyEl" class="textarea"></textarea>
            <InputFieldError :message="form.errors['meta.negative_prompt']" />
          </div>
          <template v-if="form.ai_model == 'stablediffusion'">
            <div class="mb-2">
              <label class="label mb-1">{{ trans('Image Width') }}</label>
              <div class="flex">
                <input
                  step="8"
                  v-model="form.meta.image_width"
                  class="w-full cursor-pointer accent-primary-600"
                  type="range"
                  min="512"
                  max="1024"
                />
                <span class="label card w-20 rounded-md px-2 py-1 text-center">
                  {{ form.meta.image_width || 0 }} px
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
                  min="512"
                  max="1024"
                />
                <span class="label card w-20 rounded-md px-2 py-1 text-center">
                  {{ form.meta.image_height || 0 }} px
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
                  {{ form.meta.guidance_scale || 0 }}
                </span>
              </div>
              <InputFieldError :message="form.errors['meta.guidance_scale']" />
            </div>
            <div class="mb-2">
              <label class="label mb-1">{{ trans('Steps') }}</label>
              <div class="flex">
                <input
                  step="5"
                  v-model="form.meta.steps"
                  class="w-full cursor-pointer accent-primary-600"
                  type="range"
                  min="10"
                  max="512"
                />
                <span class="label card w-20 rounded-md px-2 py-1 text-center">
                  {{ form.meta.steps || 0 }} px
                </span>
              </div>
              <InputFieldError :message="form.errors['meta.steps']" />
            </div>
          </template>
          <div class="col-span-full flex gap-2">
            <template v-if="form.ai_model == 'stability_ai'">
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
            <template v-if="form.ai_model == 'dalle_3'">
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
              v-if="form.ai_model == 'stablediffusion' || form.ai_model == 'stability_ai'"
            >
              <label class="label mb-1">{{ trans('Seed') }}</label>
              <input type="number" v-model="form.meta.seed" class="input" />
              <InputFieldError :message="form.errors['meta.seed']" />
            </div>
          </div>
        </div>
        <!-- text -->
        <div class="card card-body grid grid-cols-2 gap-4" v-if="form.prompt_type == 'text'">
          <div>
            <label class="label mb-1">{{ trans('Ai Model') }}*</label>
            <select class="select capitalize" v-model="form.meta.model">
              <option value="" disabled selected>Select</option>
              <option v-for="model in models" :value="model" :key="model">
                {{ model }}
              </option>
            </select>
            <InputFieldError :message="form.errors['meta.model']" />
          </div>
          <div>
            <label class="label mb-1">{{ trans('Max Token') }}</label>
            <input type="number" v-model="form.meta.max_token" class="input" />
            <InputFieldError :message="form.errors.max_token" />
          </div>
          <div>
            <label class="label mb-1">{{ trans('Max Word') }}</label>
            <input type="number" v-model="form.meta.max_word" class="input" />
            <InputFieldError :message="form.errors['meta.max_word']" />
          </div>
        </div>
        <!-- voice -->
        <div
          class="card card-body grid grid-cols-2 gap-4"
          v-if="form.prompt_type == 'voice_clone' || form.prompt_type == 'audio'"
        >
          <div v-if="form.prompt_type == 'voice_clone'">
            <label class="label mb-1">{{ trans('Voices') }}*</label>
            <select class="select capitalize" v-model="form.meta.voice_id" required>
              <option value="null" disabled selected>Select</option>
              <option v-for="voice in voices" :value="voice" :key="voice">
                {{ trim(voice) }}
              </option>
            </select>
            <InputFieldError :message="form.errors['meta.voice_id']" />
          </div>

          <div>
            <label class="label mb-1"
              >{{ trans('Quality') }}* <small>(Decoder iterations)</small>
            </label>
            <input type="number" required v-model="form.meta.decoder_iterations" class="input" />
            <InputFieldError :message="form.errors['meta.decoder_iterations']" />
            <small>
              <a :href="sanitizeHtml(instructions[form.prompt_type])" target="_blank">
                * {{ trans('instructions') }}
              </a>
            </small>
          </div>
        </div>
        <!-- video -->
        <div class="card card-body space-y-4" v-if="form.prompt_type == 'video'">
          <div>
            <label class="label mb-1">
              {{ trans('Video length') }} <small>({{ trans('Max Seconds') }})</small>
            </label>
            <input type="number" v-model="form.meta.max_seconds" class="input" />
            <InputFieldError :message="form.errors['meta.max_seconds']" />
          </div>
          <div>
            <label class="label mb-1">{{ trans('Negative Prompt') }}</label>
            <textarea v-model="form.meta.negative_prompt" ref="bodyEl" class="textarea"></textarea>
            <InputFieldError :message="form.errors['meta.negative_prompt']" />
          </div>
        </div>
        <!-- fields -->
        <div class="card card-body">
          <div class="flex justify-between">
            <h5>{{ trans('Input Fields') }}</h5>
            <button type="button" class="btn btn-primary" @click="addNewField">+</button>
          </div>
          <div
            v-for="(field, index) in form.fields"
            :key="index"
            class="flex flex-col justify-between gap-3 lg:flex-row lg:items-center"
          >
            <div class="flex-1 space-y-1">
              <label class="label mb-1">{{ trans('Field Type') }}</label>
              <select class="select" v-model="field.type">
                <option value="" disabled selected>Select</option>
                <option v-for="t in ['input', 'textarea']" :value="t" :key="t">
                  {{ t }}
                </option>
              </select>
              <InputFieldError :message="form.errors['fields.' + index + '.type']" />
            </div>
            <div class="flex-1 space-y-1">
              <label class="label mb-1">{{ trans('Field Name') }}</label>
              <input type="text" v-model="field.name" class="input" />
              <InputFieldError :message="form.errors['fields.' + index + '.name']" />
            </div>
            <div class="flex-1 space-y-1">
              <label class="label mb-1">{{ trans('Field Placeholder') }}</label>
              <input type="text" v-model="field.placeholder" class="input" />
              <InputFieldError :message="form.errors['fields.' + index + '.placeholder']" />
            </div>
            <div class="text-right">
              <button type="button" class="btn btn-danger mt-5" @click="removeField(index)">
                X
              </button>
            </div>
          </div>
        </div>

        <div class="card card-body">
          <div class="mb-2">
            <label class="label mb-1">{{ trans('Custom Prompt') }}</label>
            <textarea v-model="form.prompt" ref="bodyEl" class="textarea"></textarea>
            <InputFieldError :message="form.errors.prompt" />
          </div>
          <ul class="mb-3 flex flex-wrap items-center gap-1">
            <li
              v-for="code in form.fields
                .filter((item) => item.name.length)
                .map((item) => `[${item.name}]`)"
              @click="addToPrompt(code)"
              :key="code"
              class="rounded border p-1"
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
