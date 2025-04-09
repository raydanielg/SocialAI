<script setup>
import PageHeader from '@root/Layouts/Admin/PageHeader.vue'
import SpinnerBtn from '@root/Components/Admin/SpinnerBtn.vue'
import FloatingDropdown from '@root/Components/Admin/FloatingDropdown.vue'
import sharedComposable from '@root/Composables/sharedComposable'
import { useModalStore } from '@root/Store/modalStore'
import UserLayout from '@root/Layouts/User/UserLayout.vue'
import InputFieldError from '@root/Components/InputFieldError.vue'
import NoDataFound from '@root/Components/Admin/NoDataFound.vue'
import Modal from '@root/Components/Modal.vue'
import { useVideoAiStore } from '@videoai/Store/videoAiStore'
import PromptInput from '@videoai/Components/PromptInput.vue'
import { computed, onMounted, ref } from 'vue'
import { useForm } from '@inertiajs/vue3'

defineOptions({ layout: UserLayout })

const props = defineProps({
  credits: {
    type: Number,
    required: true
  },
  examplePresets: {
    type: Object,
    required: true
  },
  customPresets: {
    type: Object,
    required: true
  },
  aiVideoSetting: {
    type: Object
  },
  aiVideoConfig: {
    type: Object
  }
})

const { copyToClipboard, trim, deleteRow } = sharedComposable()
const store = useVideoAiStore()
const modalStore = useModalStore()

onMounted(() => {
  store.$patch({
    props: props,
    validationRules: props.aiVideoConfig.validation
  })
  if (store.generateVideoId) {
    store.fetchVideo()
  }
})

const selectedPreset = ref(null)
const activeTab = ref('example')
const isEditing = ref(false)
const tabs = ['custom', 'example']

const form = useForm({
  id: null,
  prompt: '',
  title: ''
})
const setEditForm = (data) => {
  modalStore.open('customPreset')
  isEditing.value = true
  form.id = data.id
  form.prompt = data.prompt
  form.title = data.title
}
const submitPreset = () => {
  const routeUrl = isEditing.value
    ? route('user.videoai.prompt-preset.update', form.id)
    : route('user.videoai.prompt-preset.store')
  const method = isEditing.value ? 'patch' : 'post'
  console.log({ routeUrl, method })

  form[method](routeUrl, {
    onSuccess: () => {
      form.reset()
      modalStore.close()
      isEditing.value = false
    }
  })
}

const requiredCredits = computed(() => {
  const creditCost = props.aiVideoSetting?.meta?.credit || 0
  const duration = store.form?.duration || 0
  return duration * creditCost
})
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader title="AI Video Generator" />
    <div class="grid grid-cols-1 place-items-start gap-5 lg:grid-cols-12">
      <!-- Input Form -->
      <form
        @submit.prevent="store.submit"
        class="card card-body col-span-1 space-y-6 lg:col-span-5"
      >
        <!-- Image Upload -->
        <div class="space-y-2">
          <label class="label mb-1">{{ trans('Source Image') }} </label>
          <div class="relative">
            <input
              type="file"
              accept="image/*"
              class="hidden"
              ref="fileInput"
              @change="store.handleImageSelect"
            />
            <div
              v-if="!store.imagePreview"
              class="input flex h-32 cursor-pointer items-center justify-center border-2 border-dashed p-4"
              @click="$refs.fileInput.click()"
            >
              <span class="text-gray-500">{{ trans('Click to upload an image') }}</span>
            </div>
            <div v-else class="relative">
              <img
                :src="store.imagePreview"
                class="h-64 w-full rounded-lg border object-cover dark:border-dark-700"
                alt="Preview"
              />
              <button
                @click.prevent="store.clearImage"
                class="absolute right-2 top-2 rounded-full bg-red-500 p-1 text-white"
              >
                <Icon icon="lucide:x" />
              </button>
            </div>
          </div>
          <InputFieldError
            class="text-sm"
            v-if="store.fieldErrors?.image"
            :message="store.fieldErrors.image"
          />
        </div>

        <div>
          <PromptInput v-model="store.form.prompt" />
          <InputFieldError
            class="text-sm"
            v-if="store.fieldErrors?.prompt"
            :message="store.fieldErrors.prompt"
          />
          <template v-if="Object.keys(store.errors).length">
            <div class="text-sm">
              <InputFieldError v-for="(error, key) in store.errors" :key="key" :message="error" />
            </div>
          </template>
        </div>

        <div class="flex items-center gap-5">
          <div class="flex-1">
            <label class="label mb-1">{{ trans('Duration') }}</label>
            <select name="duration" v-model="store.form.duration" class="select">
              <option value="" selected>{{ trans('Select Duration') }}</option>
              <option
                v-for="duration in aiVideoConfig.validation.duration"
                :key="duration"
                :value="duration"
              >
                {{ duration }}s
              </option>
            </select>
            <InputFieldError
              class="text-sm"
              v-if="store.fieldErrors?.duration"
              :message="store.fieldErrors.duration"
            />
          </div>
        </div>

        <div class="flex justify-between">
          <div class="flex gap-3 text-sm">
            <button
              v-for="tab in tabs"
              :key="tab"
              type="button"
              class="px-px pb-0.5 capitalize"
              :class="{
                'border-b-2 border-b-primary-500 text-primary-500': activeTab === tab,
                'text-secondary-300': activeTab !== tab
              }"
              @click="activeTab = tab"
            >
              {{ trans(tab) }}
            </button>
          </div>
          <button
            v-if="activeTab === 'custom'"
            @click="modalStore.open('customPreset')"
            type="button"
            class="btn btn-outline-primary btn-xs"
          >
            <Icon icon="bx:plus" />
            <span>{{ trans('Create New') }}</span>
          </button>
        </div>
        <div v-if="activeTab === 'example'">
          <ul class="divide-y divide-gray-600">
            <li
              v-for="(preset, index) in examplePresets"
              :key="index"
              class="flex items-center justify-between px-2 py-2"
            >
              <p class="flex items-center gap-1">
                <Icon icon="solar:layers-minimalistic-bold-duotone" class="mt-0.5 text-lg" />
                <span class="text-sm">{{ preset.title }}</span>
              </p>
              <div class="flex items-center gap-1">
                <button
                  type="button"
                  class="rounded border border-primary-600 px-2 pb-1 pt-0.5 text-[11px] text-primary-500 hover:bg-primary-400"
                  @click="store.setPreset(preset)"
                >
                  {{ trans('Apply') }}
                </button>
                <button
                  type="button"
                  class="rounded p-0.5 text-primary-500 hover:bg-primary-500/50"
                  @click="
                    () => {
                      selectedPreset = preset
                      modalStore.open('promptDetails')
                    }
                  "
                >
                  <Icon icon="lucide:align-left" />
                </button>
              </div>
            </li>
          </ul>
          <p v-if="!examplePresets.length" class="text-sm text-red-500">
            {{ trans('No custom presets found') }}
          </p>
        </div>
        <div v-if="activeTab === 'custom'">
          <ul class="divide-y divide-gray-600" v-if="customPresets.length">
            <li
              v-for="(preset, index) in customPresets"
              :key="index"
              class="flex items-center justify-between px-2 py-2"
            >
              <p class="flex items-center gap-1">
                <Icon icon="solar:layers-minimalistic-bold-duotone" class="mt-0.5 text-lg" />
                <span class="text-sm">{{ preset.title }}</span>
              </p>
              <div class="flex items-center gap-1">
                <button
                  type="button"
                  class="rounded border border-primary-600 px-2 pb-1 pt-0.5 text-[11px] text-primary-500 hover:bg-primary-400"
                  @click="store.setPreset(preset)"
                >
                  {{ trans('Apply') }}
                </button>
                <FloatingDropdown
                  btn-type="icon"
                  icon-name="bx:dots-horizontal-rounded"
                  btn-class="text-primary-500 hover:bg-primary-500/50 rounded"
                  icon-class="text-xl"
                >
                  <div class="flex w-28 flex-col gap-1 py-2">
                    <button
                      type="button"
                      class="w-full rounded py-0.5 text-start text-sm hover:bg-secondary-700"
                      @click="setEditForm(preset)"
                    >
                      <span class="pl-1.5">{{ trans('Edit') }}</span>
                    </button>
                    <button
                      type="button"
                      class="w-full rounded py-0.5 text-start text-sm hover:bg-secondary-700"
                      @click="deleteRow(route('user.videoai.prompt-preset.destroy', preset.id))"
                    >
                      <span class="pl-1.5">{{ trans('Delete') }}</span>
                    </button>
                  </div>
                </FloatingDropdown>
              </div>
            </li>
          </ul>
          <div
            v-else
            class="flex h-32 flex-col items-center justify-center gap-2 rounded-md bg-dark-700 p-2 text-sm text-gray-600 dark:text-gray-300"
          >
            <p>{{ trans('No custom presets found') }}</p>
            <button @click="modalStore.open('customPreset')" type="button" class="btn btn-primary">
              <Icon icon="solar:layers-minimalistic-bold-duotone" class="mt-0.5" />
              <span>{{ trans('Create New') }}</span>
            </button>
          </div>
        </div>

        <div class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-300">
          <p>{{ trans('Available Credits') }}: {{ props.credits }}</p>
          <p>{{ trans('Required Credits') }}: {{ requiredCredits }}</p>
        </div>

        <!-- Generate Button -->
        <SpinnerBtn
          classes="btn btn-primary w-full py-3"
          :processing="store.isProcessing"
          :btn-text="trans('Generate')"
        />
      </form>

      <!-- Output Section -->
      <div class="card col-span-1 flex flex-col p-3 lg:col-span-7">
        <div class="user-activity-chart h-100 rounded p-4">
          <div v-if="store.isProcessing" class="flex items-center justify-center p-8">
            <div class="flex flex-col items-center justify-center">
              <div
                class="mb-4 h-12 w-12 animate-spin rounded-full border-4 border-primary-500 border-t-transparent"
              ></div>
              <p class="text-gray-500">{{ trans('Generating video...') }}</p>
            </div>
          </div>

          <div v-else-if="store.generatedVideo" class="relative grid grid-cols-1 gap-4">
            <div
              class="group overflow-hidden rounded-lg border border-primary-500 shadow shadow-primary-500"
            >
              <a
                class="absolute right-2 top-0 z-10 opacity-0 transition-opacity duration-200 group-hover:opacity-100"
                :href="store.generatedVideo"
                download
              >
                <i class="bx bx-download text-4xl"></i>
              </a>
              <video class="h-full w-full" controls>
                <source :src="store.generatedVideo" type="video/mp4" />
                {{ trans('Your browser does not support the video tag.') }}
              </video>
            </div>
          </div>

          <NoDataFound v-if="!store.generatedVideo && !store.isProcessing" />
        </div>
      </div>
    </div>
  </main>

  <Modal
    modelSize="w-1/4"
    bg-color="bg-white dark:bg-dark-800 c-modal-content-small"
    :state="modalStore.states['customPreset']"
  >
    <p class="flex w-11/12 -translate-y-1 items-center gap-1">
      <Icon icon="solar:layers-minimalistic-bold-duotone" class="mt-0.5 text-xl" />
      <span class="text-sm capitalize">
        {{ trans(`${isEditing ? 'Update' : 'Create New'} Preset`) }}
      </span>
    </p>

    <div class="mt-4 flex min-h-24 flex-col justify-between">
      <div class="mb-2">
        <label class="label label-required mb-1">{{ trans('Title') }}</label>
        <input type="text" v-model="form.title" class="input" />
        <InputFieldError class="text-sm" :message="form.errors.title" />
      </div>
      <div class="mb-2">
        <label class="label label-required mb-1">{{ trans('Prompt') }}</label>
        <textarea v-model="form.prompt" class="textarea"></textarea>
        <InputFieldError class="text-sm" :message="form.errors.prompt" />
      </div>

      <div class="mt-6 flex gap-2 border-t pt-6 dark:border-gray-700">
        <button type="button" class="btn btn-outline-danger flex-1" @click="modalStore.close">
          {{ trans('Cancel') }}
        </button>
        <SpinnerBtn
          @click="submitPreset"
          classes="btn btn-primary flex-1"
          icon=""
          :processing="form.processing"
          :btn-text="trans(isEditing ? 'Update' : 'Create')"
        />
      </div>
    </div>
  </Modal>
  <Modal
    modelSize="w-1/4"
    bg-color="bg-white dark:bg-dark-800 c-modal-content-small"
    :state="modalStore.states['promptDetails']"
  >
    <p class="flex w-11/12 -translate-y-1 items-center gap-1">
      <Icon icon="solar:layers-minimalistic-bold-duotone" class="mt-0.5 text-xl" />
      <span class="text-sm capitalize">{{ selectedPreset.title }}</span>
    </p>

    <div class="mt-4 flex min-h-24 flex-col justify-between">
      <p class="text-sm text-gray-600 dark:text-gray-300">
        {{ selectedPreset.description }}
      </p>

      <div class="mt-6 border-t pt-6 dark:border-gray-700">
        <button
          type="button"
          class="btn btn-primary w-full"
          @click="store.setPreset(selectedPreset)"
        >
          {{ trans('Apply') }}
        </button>
      </div>
    </div>
  </Modal>
</template>
