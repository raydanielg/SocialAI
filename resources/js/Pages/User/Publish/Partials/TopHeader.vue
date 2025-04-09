<script setup>
import { computed, ref } from 'vue'

import moment from 'moment'
import { storeToRefs } from 'pinia'

import FloatingDropdown from '@/Components/Admin/FloatingDropdown.vue'
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
// modal
import Modal from '@/Components/Modal.vue'
import toastr from '@/Composables/toastComposable'
import trans from '@/Composables/transComposable'
import { useModalStore } from '@/Store/modalStore'
import { usePublishStore } from '@/Store/publishStore'

const store = usePublishStore()

const { getPlatformTabState, platforms, publishAccounts, form: brandContent } = storeToRefs(store)

const modalStore = useModalStore()

const steps = [
  {
    step: 1,
    title: 'Instant Publish'
  },
  {
    step: 2,
    title: 'Schedule for later'
  }
]

const activeStep = ref(1)

const getActiveStep = computed(() => {
  return steps.find((item) => item.step == activeStep.value) || steps[0]
})

const openPublishModal = () => {
  if (store.publishAccounts.length == 0) {
    store.setTab('connect')
    toastr.info('Please connect your social accounts first')
    return
  }

  let tiktokPlatform = store.findPublishAccountByName('tiktok') ?? null
  if (tiktokPlatform && !store.tiktokOptions.privacy_level) {
    toastr.danger('Please choose privacy setting for tiktok')
    return
  }

  modalStore.open('publishContent')
}
</script>
<template>
  <Modal
    :state="modalStore.states['publishContent']"
    :close-btn="!store.loading.publish"
    :header-state="true"
    :header-title="getActiveStep.title"
    :backdrop-close="false"
  >
    <!-- preview all publisher accounts -->
    <div class="mx-2 my-6 flex max-h-[600px] flex-col gap-2">
      <div class="styled-scrollbar space-y-2 overflow-y-auto">
        <div v-for="platform in publishAccounts" :key="platform">
          <button @click="store.togglePublishAccount(platform)" class="w-full">
            <div
              class="rounded-lg border border-dashed p-3"
              :class="{
                'border-red-600 bg-red-50 dark:bg-red-200':
                  store.findPostPlatformByName(platform.platform)?.status === 'failed',
                'border-green-600 bg-green-50 dark:bg-primary-200':
                  store.findPostPlatformByName(platform.platform)?.status === 'published',
                'cursor-not-allowed bg-primary-50 dark:bg-green-100 dark:text-dark-700':
                  store.findPostPlatformByName(platform.platform)
              }"
            >
              <div class="flex items-center justify-between">
                <span class="flex items-center justify-between gap-3">
                  <img
                    class="h-6"
                    :src="`/assets/svg/${platform.platform}.svg?v=1`"
                    :alt="platform.platform"
                  />
                  <img
                    :src="platform.picture ?? '/assets/images/no-image.jpg'"
                    @error="(e) => (e.target.src = '/assets/images/no-image.jpg')"
                    class="h-10 w-10 rounded-full"
                  />
                  <span class="text-nowrap">{{ platform.name }}</span>
                  <span v-if="platform.username" class="truncate text-sm text-gray-500"
                    >({{ platform.username }})</span
                  >
                </span>
                <div class="flex items-center justify-between gap-3">
                  <img
                    v-if="store.publishingPlatform?.id == platform.id"
                    class="h-8"
                    src="/assets/images/ajax_loading.svg"
                    alt="ajax_loading"
                  />

                  <i
                    v-if="store.findPostPlatformByName(platform.platform)?.status === 'draft'"
                    class="bx bx-circle text-2xl"
                  />

                  <i
                    v-if="store.findPostPlatformByName(platform.platform)?.status === 'published'"
                    class="bx bxs-check-circle text-2xl text-green-600"
                  />

                  <i
                    v-if="store.findPostPlatformByName(platform.platform)?.status === 'failed'"
                    class="bx bxs-x-circle text-2xl text-red-600"
                  />
                </div>
              </div>
              <div v-if="store.findPostPlatformByName(platform.platform)?.status === 'failed'">
                <table
                  v-if="
                    typeof store.findPostPlatformByName(platform.platform)?.data?.message ===
                    'object'
                  "
                  class="mt-3 text-start !text-sm text-red-600"
                >
                  <template v-if="store.findPostPlatformByName(platform.platform)?.data?.message">
                    <tr
                      v-for="(err, key) in store.findPostPlatformByName(platform.platform)?.data
                        ?.message"
                      :key="key"
                    >
                      <td class="border p-2 font-semibold">{{ key }}</td>
                      <td class="border p-2">{{ err }}</td>
                    </tr>
                  </template>
                </table>

                <p
                  class="mt-3 text-start !text-sm text-red-600"
                  v-else-if="store.findPostPlatformByName(platform.platform)?.status === 'failed'"
                >
                  <strong>Error:</strong>
                  {{
                    store.findPostPlatformByName(platform.platform)?.data?.message ||
                    'Unknown Error'
                  }}
                  ({{ store.findPostPlatformByName(platform.platform)?.data?.failed_at }})
                </p>
              </div>
            </div>
          </button>
        </div>
      </div>

      <template v-if="activeStep == 1">
        <button
          :disabled="store.loading.publish || store.publishAccounts.length == 0"
          @click="store.publishPost('publish')"
          class="flex items-center justify-center gap-2 rounded-md p-3 text-left text-lg dark:bg-gray-700 dark:hover:bg-slate-900"
          :class="
            store.loading.publish || store.publishAccounts.length == 0
              ? 'cursor-not-allowed bg-purple-200 hover:bg-purple-300'
              : 'bg-purple-600 text-white'
          "
        >
          <Icon v-if="!store.loading.publish" icon="mi:send" class="text-lg" />
          <span>
            {{ store.loading.publish ? trans('Publishing') : trans('Start Publish') }}
          </span>
          <img v-if="store.loading.publish" src="/assets/svg/loader.svg" class="h-8" alt="" />
        </button>
      </template>

      <!-- schedule post -->

      <template v-if="activeStep == 2">
        <div class="mb-2">
          <label>Date and Time</label>
          <input
            type="datetime-local"
            :min="moment().format('Y-M-DThh:mm')"
            v-model="brandContent.scheduled_at"
            class="input"
            required
          />
          <p class="mt-3 !text-[12px] text-xs text-blue-500">
            <strong>Note:</strong> Post will be schedule according to your current timezone
          </p>
        </div>

        <button
          :disabled="store.loading.publish || store.publishAccounts.length == 0"
          @click="store.schedulePost()"
          class="flex items-center justify-center gap-2 rounded-md p-3 text-left text-lg dark:bg-gray-700 dark:hover:bg-slate-900"
          :class="
            store.loading.publish || store.publishAccounts.length == 0
              ? 'cursor-not-allowed bg-purple-200 hover:bg-purple-300'
              : 'bg-purple-600 text-white'
          "
        >
          <Icon v-if="!store.loading.publish" icon="fe:clock" class="text-lg" />
          <span>
            {{ store.loading.publish ? trans('Scheduling') : trans('Schedule') }}
          </span>
          <img v-if="store.loading.publish" src="/assets/svg/loader.svg" class="h-8" alt="" />
        </button>
      </template>

      <div class="flex gap-1">
        <button
          v-if="activeStep == 1"
          @click="activeStep = 2"
          :disabled="store.loading.publish || store.publishAccounts.length == 0"
          class="btn btn-soft-primary w-full py-4 font-bold"
        >
          <Icon icon="fe:clock" class="text-lg" />
          <span>{{ trans('Schedule for later') }}</span>
        </button>
        <button
          v-else
          @click="activeStep = 1"
          :disabled="store.loading.publish || store.publishAccounts.length == 0"
          class="btn btn-soft-primary w-full py-4 font-bold"
        >
          <Icon icon="bx:rocket" class="text-lg" />
          <span>{{ trans('Instant Publish') }}</span>
        </button>

        <button
          @click="modalStore.close()"
          :disabled="store.loading.publish"
          class="btn btn-soft-secondary w-full py-4"
        >
          <Icon icon="bx:x-circle" class="text-lg" />
          <span>{{ trans('Close') }}</span>
        </button>
      </div>
    </div>
  </Modal>

  <div class="flex flex-col items-center justify-between gap-2 pb-2 pt-5 lg:flex-row">
    <div class="card max-w-max space-x-2 p-1">
      <template v-for="platform in platforms" :key="platform">
        <button
          class="btn py-3 hover:bg-primary-800 sm:px-8"
          :class="{ 'btn-soft-primary': getPlatformTabState(platform) }"
          @click="store.setPlatformTab(platform)"
          :disabled="platform == 'wordpress'"
        >
          <img class="w-4" :src="`/assets/svg/${platform}.svg?v=1`" :alt="platform" />
        </button>
      </template>
    </div>
    <div class="flex items-center justify-end gap-3">
      <SpinnerBtn
        :processing="store.loading.draft"
        @click="store.draftPost()"
        :btn-text="trans('Save Changes')"
        icon="bx bx-save"
        class="btn-success"
      />
      <SpinnerBtn
        :processing="store.loading.publish"
        @click="openPublishModal"
        :btn-text="trans('Publish')"
        icon="bx bx-paper-plane"
        class="btn-primary"
      />
    </div>
  </div>
</template>
