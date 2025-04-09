<script setup>
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
import sharedComposable from '@/Composables/sharedComposable'
import UserLayout from '@/Layouts/User/UserLayout.vue'
import Multiselect from '@vueform/multiselect'
import InputFieldError from '@/Components/InputFieldError.vue'
import { onMounted } from 'vue'
import NoDataFound from '@/Components/Admin/NoDataFound.vue'
import { useAiToolsStore } from '@/Store/aiToolsStore'
import RichEditor from '@/Components/Admin/RichEditor.vue'
defineOptions({ layout: UserLayout })

const props = defineProps(['template', 'languages', 'credits'])
const { copyToClipboard, trim } = sharedComposable()
const store = useAiToolsStore()

onMounted(() => {
  store.$patch({
    props: props,
    form: {
      model: props.template.ai_model,
      template_id: props.template.id,
      fields: props.template.fields
    }
  })
})
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader title="AI Tools" />
    <div class="grid grid-cols-1 place-items-start gap-5 lg:grid-cols-12">
      <form
        @submit.prevent="store.submit"
        class="card card-body col-span-1 space-y-6 lg:col-span-5"
      >
        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <img :src="template.icon" width="50" height="50" class="rounded-full" alt="icon" />
            <p class="mx-2 text-sm">{{ template.title }}</p>
          </div>
          <p class="capitalize text-gray-500">{{ trim(template.prompt_type) }}</p>
        </div>
        <!-- credits -->

        <!-- text -->
        <div class="grid grid-cols-2 gap-3" v-if="template.prompt_type === 'text'">
          <div>
            <label class="label mb-1">{{ trans('Language') }}*</label>
            <Multiselect
              class="multiselect-dark"
              v-model="store.form.language"
              :options="languages"
              valueProp="name"
              label="name"
              placeholder="Language"
            />
            <InputFieldError v-if="store.errors?.language" :message="store.errors?.language[0]" />
          </div>
          <div>
            <label class="label mb-1">{{ trans('Tone') }}*</label>
            <Multiselect
              class="multiselect-dark"
              v-model="store.form.tone"
              :options="store.tones"
              placeholder="Tone"
            />
            <InputFieldError v-if="store.errors?.tone" :message="store.errors?.tone[0]" />
          </div>
        </div>
        <!-- audio -->
        <div v-if="template.prompt_type === 'audio'">
          <label class="label">{{ trans('Valid Audio File') }}*</label>
          <input
            accept="audio/*"
            @change="(e) => (store.form.init_audio = e.target.files[0])"
            required
            type="file"
            class="input"
          />

          <InputFieldError v-if="store.errors?.init_audio" :message="store.errors?.init_audio[0]" />
        </div>
        <!-- fields -->
        <div>
          <div v-for="(field, i) in store.form.fields" :key="i">
            <label class="label mb-1">{{ field.name }}*</label>
            <input
              required
              v-if="field.type === 'input'"
              v-model="field.value"
              type="text"
              class="input"
              :placeholder="field.placeholder"
            />
            <textarea
              v-if="field.type === 'textarea'"
              required
              v-model="field.value"
              class="textarea"
              :placeholder="field.placeholder"
            ></textarea>
            <InputFieldError v-if="store.hasError" :message="store.fieldErrors[field.name]" />
            <InputFieldError
              v-if="!store.hasError && store.errors && store.errors['fields.' + i + '.value']"
              :message="store.errors['fields.' + i + '.value'][0]"
            />
          </div>
        </div>
        <!-- text -->
        <div v-if="template.prompt_type === 'text'">
          <label class="label">{{ trans('Maximum Word Limit') }}</label>
          <input
            v-model.number="store.form.max_token"
            type="text"
            class="input"
            placeholder="Maximum Length"
          />
          <InputFieldError v-if="store.errors?.max_token" :message="store.errors?.max_token[0]" />
        </div>
        <div class="flex items-center gap-5">
          <div
            class="flex-1"
            v-if="
              ['text', 'image'].includes(template.prompt_type) &&
              template?.ai_model !== 'stability_ai'
            "
          >
            <label class="label mb-1">{{ trans('Number Of Result') }}</label>

            <Multiselect
              class="multiselect-dark"
              v-model="store.form.qty"
              :options="[1, 2, 3, 4, 5]"
              placeholder="Number Of Result"
            />
            <InputFieldError v-if="store.errors?.qty" :message="store.errors?.qty[0]" />
          </div>
          <div class="flex-1" v-if="template.prompt_type === 'text'">
            <label class="label mb-1">{{ trans('Creativity Level') }}</label>
            <Multiselect
              class="multiselect-dark"
              v-model="store.form.creativity"
              :options="store.creativityLevels"
              value-by="value"
              label="label"
              placeholder="Creativity Level"
            />
            <InputFieldError
              v-if="store.errors?.creativity"
              :message="store.errors.creativity[0]"
            />
          </div>
          <!-- video -->
          <div class="flex-1" v-if="template.prompt_type === 'video'">
            <label class="label mb-1">{{ trans('Seconds') }}</label>
            <input
              v-model.number="store.form.seconds"
              type="number"
              class="input"
              placeholder="Seconds"
            />
            <InputFieldError v-if="store.errors?.seconds" :message="store.errors.seconds[0]" />
          </div>
        </div>

        <SpinnerBtn
          classes="btn btn-primary w-full py-3"
          :processing="store.isProcessing"
          :btn-text="trans('Generate')"
        />
      </form>
      <div class="card col-span-1 flex flex-col p-3 lg:col-span-7">
        <div class="user-activity-chart h-100 rounded p-4">
          <div class="flex" v-if="template.prompt_type === 'text'">
            <button class="me-1" @click="copyToClipboard(store.generatedText)">
              <i class="bx bx-clipboard text-2xl"></i>
            </button>
            <button
              class="ms-1"
              @click="store.downloadHTMLFile(store.generatedText, store.documentName)"
            >
              <i class="bx bx-download text-2xl"></i>
            </button>
          </div>
          <template v-if="template.prompt_type === 'text'">
            <div class="my-8">
              <input
                v-model="store.documentName"
                type="text"
                class="input"
                placeholder="Untitled Document..."
              />
            </div>
            <div>
              <RichEditor v-model="store.generatedText" />
            </div>
          </template>
          <template v-if="template.prompt_type === 'image' && store.generatedImages.length > 0">
            <div class="mt-6 grid grid-cols-3 gap-4 overflow-y-auto">
              <div
                v-for="(image, i) in store.generatedImages"
                :key="i"
                class="group relative h-44 overflow-hidden rounded-lg border border-primary-500 shadow shadow-primary-500"
              >
                <a
                  class="absolute right-1 top-0 opacity-0 group-hover:opacity-100"
                  :href="image"
                  download
                >
                  <i class="bx bx-download text-2xl"></i>
                </a>
                <img :src="image" class="h-full w-full object-cover" alt="image" />
              </div>
            </div>
          </template>
          <template v-if="template.prompt_type === 'video' && store.generatedVideo">
            <div class="relative grid grid-cols-1 gap-4">
              <div
                class="group overflow-hidden rounded-lg border border-primary-500 shadow shadow-primary-500"
              >
                <a
                  class="absolute right-2 top-0 z-10 opacity-0 group-hover:opacity-100"
                  :href="store.generatedVideo"
                  download
                >
                  <i class="bx bx-download text-4xl"></i>
                </a>
                <video class="h-full w-full" controls>
                  <source :src="store.generatedVideo" type="video/mp4" />
                </video>
              </div>
            </div>
          </template>
          <template
            v-if="
              (template.prompt_type === 'voice_clone' && store.generatedVoice) ||
              (template.prompt_type === 'audio' && store.generatedVoice)
            "
          >
            <div class="relative grid grid-cols-1 gap-4">
              <div class="group overflow-hidden rounded-lg shadow-primary-500">
                <a class="absolute right-4 z-10" :href="store.generatedVoice" download>
                  <i class="bx bx-download text-4xl"></i>
                </a>

                <audio controls class="mt-12 w-full">
                  <source :src="store.generatedVoice" type="audio/wav" />
                  <source :src="store.generatedVoice" type="audio/mp3" />
                  Your browser does not support the audio element.
                </audio>
              </div>
            </div>
          </template>
          <NoDataFound
            v-if="
              store.generatedImages?.length < 1 &&
              !store.generatedVideo &&
              !store.generatedVoice &&
              template.prompt_type !== 'text'
            "
          />
        </div>
      </div>
    </div>
  </main>
</template>
