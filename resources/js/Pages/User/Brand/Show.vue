<script setup>
import UserLayout from '@/Layouts/User/UserLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import InputFieldError from '@/Components/InputFieldError.vue'
import Modal from '@/Components/Modal.vue'
import { useModalStore } from '@/Store/modalStore'
import { storeToRefs } from 'pinia'
import { useForm } from '@inertiajs/vue3'
const props = defineProps(['brand'])
defineOptions({ layout: UserLayout })
const modal = useModalStore()
const { getState } = storeToRefs(modal)

const form = useForm({ ...props.brand, _method: 'PATCH' })

const submit = () => {
  form.post(route('user.brand.update', props.brand.id), {
    preserveScroll: true,
    onSuccess: () => {
      modal.close()
    }
  })
}
</script>

<template>
  <Modal
    @action="submit"
    :action-processing="form.processing"
    :state="getState('brandName')"
    :header-state="true"
    header-title="Edit Brand Name"
    :action-btn-state="true"
  >
    <div class="my-3">
      <label class="label mb-1">{{ trans('Name') }}</label>
      <input type="text" v-model="form.name" class="input" />
      <InputFieldError :message="form.errors.name" />
    </div>
  </Modal>
  <!-- slogan -->
  <Modal
    @action="submit"
    :action-processing="form.processing"
    :state="getState('brandTagline')"
    :header-state="true"
    header-title="Edit Brand Tagline"
    :action-btn-state="true"
  >
    <div class="my-3">
      <label class="label mb-1">{{ trans('Tagline') }}</label>
      <input type="text" v-model="form.slogan" class="input" />
      <InputFieldError :message="form.errors.slogan" />
    </div>
  </Modal>
  <!-- description -->
  <Modal
    @action="submit"
    :action-processing="form.processing"
    :state="getState('brandDescription')"
    :header-state="true"
    header-title="Edit Brand Description"
    :action-btn-state="true"
  >
    <div class="my-3">
      <label class="label mb-1">{{ trans('Description') }}</label>
      <textarea
        v-model="form.description"
        class="textarea h-56"
        placeholder="Write something"
      ></textarea>
      <InputFieldError :message="form.errors.description" />
    </div>
  </Modal>
  <!-- color -->
  <Modal
    @action="submit"
    :action-processing="form.processing"
    :state="getState('brandColor')"
    :header-state="true"
    header-title="Edit Brand Tagline"
    :action-btn-state="true"
  >
    <div class="mt-4 flex items-center gap-4">
      <label class="label mb-1 w-20">{{ trans('Primary') }}</label>

      <div class="h-9 w-10 overflow-hidden rounded-md">
        <input
          v-model="form.color.primary"
          class="h-24 w-24 -translate-x-5 -translate-y-4 rounded-xl bg-transparent text-sm text-slate-700 outline-none placeholder:text-slate-400 focus:ring-0 focus:ring-primary-500 dark:text-slate-200"
          type="color"
          name="file"
        />
      </div>
    </div>
    <InputFieldError :message="form.errors['color']" />
    <div class="mt-8 flex items-center gap-4">
      <label class="label mb-1 w-20">{{ trans('Secondary') }}</label>
      <div class="h-9 w-10 overflow-hidden rounded-md">
        <input
          v-model="form.color.secondary"
          class="h-24 w-24 -translate-x-5 -translate-y-4 rounded-xl bg-transparent text-sm text-slate-700 outline-none placeholder:text-slate-400 focus:ring-0 focus:ring-primary-500 dark:text-slate-200"
          type="color"
          name="file"
        />
      </div>
    </div>
    <InputFieldError :message="form.errors['color']" />
  </Modal>
  <!-- logo -->
  <Modal
    @action="submit"
    :action-processing="form.processing"
    :state="getState('brandLogo')"
    :header-state="true"
    header-title="Edit Brand Logo"
    :action-btn-state="true"
  >
    <div class="my-3">
      <label class="label mb-1">{{ trans('Logo') }}</label>
      <input
        type="file"
        accept="image/*"
        @input="(e) => (form.logo = e.target.files[0])"
        class="input"
      />
      <InputFieldError :message="form.errors.logo" />
    </div>
  </Modal>
  <!-- Identity -->
  <Modal
    @action="submit"
    :action-processing="form.processing"
    :state="getState('brandIdentity')"
    :header-state="true"
    header-title="Edit Brand Identity"
    :action-btn-state="true"
  >
    <div class="my-3">
      <label class="label mb-1">{{ trans('Mission') }}</label>
      <textarea
        v-model="form.identities.mission"
        class="textarea"
        placeholder="Write something"
      ></textarea>
      <InputFieldError :message="form.errors['identities.mission']" />
    </div>
    <div class="my-3">
      <label class="label mb-1">{{ trans('Vision') }}</label>
      <textarea
        v-model="form.identities.vision"
        class="textarea"
        placeholder="Write something"
      ></textarea>
      <InputFieldError :message="form.errors['identities.vision']" />
    </div>
    <div class="my-3">
      <label class="label mb-1">{{ trans('Values') }}</label>
      <textarea
        v-model="form.identities.values"
        class="textarea"
        placeholder="Write something"
      ></textarea>
      <InputFieldError :message="form.errors['identities.values']" />
    </div>
  </Modal>
  <!-- Audience -->
  <Modal
    @action="submit"
    :action-processing="form.processing"
    :state="getState('brandAudience')"
    :header-state="true"
    header-title="Edit Brand Audience"
    :action-btn-state="true"
  >
    <template v-for="(audience, i) in form.audiences" :key="i">
      <div class="my-3">
        <label class="label mb-1">{{ trans('Segment') }} {{ i + 1 }}</label>
        <textarea v-model="audience.text" class="textarea" placeholder="Write something"></textarea>
        <InputFieldError :message="form.errors[`audiences.${i}.text`]" />
      </div>
    </template>
  </Modal>
  <!-- Strategy -->
  <Modal
    @action="submit"
    :action-processing="form.processing"
    :state="getState('brandStrategy')"
    :header-state="true"
    header-title="Edit Brand Strategy"
    :action-btn-state="true"
  >
    <div class="my-3">
      <label class="label mb-1">{{ trans('Strategy') }}</label>
      <textarea v-model="form.strategy" class="textarea" placeholder="Write something"></textarea>
      <InputFieldError :message="form.errors.strategy" />
    </div>
  </Modal>
  <!-- Voice -->
  <Modal
    @action="submit"
    :action-processing="form.processing"
    :state="getState('brandVoice')"
    :header-state="true"
    header-title="Edit Brand Voice"
    :action-btn-state="true"
  >
    <div class="my-3">
      <label class="label mb-1">{{ trans('Message') }}</label>
      <textarea
        v-model="form.voices.message"
        class="textarea"
        placeholder="Write something"
      ></textarea>
      <InputFieldError :message="form.errors['voices.message']" />
    </div>
    <label class="label mb-1">{{ trans('Tones') }}</label>
    <template v-for="(tone, i) in form.voices.tones" :key="i">
      <div class="my-3">
        <input v-model="tone.text" type="text" class="input" placeholder="Write something" />
        <InputFieldError :message="form.errors[`voices.tones.${i}.text`]" />
      </div>
    </template>
  </Modal>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader :title="'Brand - ' + brand.name" />
    <div class="space-y-8">
      <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
        <div class="card rounded-2xl p-4 md:p-8">
          <Link
            :href="route('user.brand.create')"
            class="flex h-32 w-full flex-col items-center justify-center rounded-2xl border-primary-50 bg-primary-700 bg-opacity-50"
          >
            <div
              class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-full bg-secondary-50"
            >
              <i class="bx bx-refresh text-2xl text-primary-600"></i>
            </div>
            <p class="mt-2 text-lg font-semibold text-white">{{ trans('Create New Brand') }}</p>
          </Link>
          <div class="mt-6 grid grid-cols-2 gap-4 md:gap-8">
            <Link
              :href="route('user.brand-posts.index', { brand: brand.uuid })"
              class="flex h-32 w-full flex-col items-center justify-center rounded-2xl border-emerald-50 bg-secondary-300 bg-opacity-50 dark:bg-secondary-900"
            >
              <div
                class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-full bg-secondary-300 text-secondary-50 dark:bg-secondary-800"
              >
                <i class="bx bx-plus text-2xl text-primary-600"></i>
              </div>
              <p class="mt-2 text-lg font-semibold">{{ trans('Create Post') }}</p>
            </Link>
            <Link
              :href="route('brand.share', brand.uuid)"
              class="flex h-32 w-full flex-col items-center justify-center rounded-2xl border-emerald-50 bg-secondary-300 bg-opacity-50 dark:bg-secondary-900"
            >
              <div
                class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-full bg-secondary-300 text-secondary-50 dark:bg-secondary-800"
              >
                <i class="bx bx-share text-2xl text-primary-600"></i>
              </div>
              <p class="mt-2 text-lg font-semibold">{{ trans('Share Branding') }}</p>
            </Link>
          </div>
        </div>
        <!-- cards -->
        <div class="card rounded-2xl pb-2">
          <div
            class="mb-4 flex items-center justify-between border-b border-gray-200 p-5 dark:border-gray-700"
          >
            <div class="flex items-center">
              <div
                class="mr-4 flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-primary-300 bg-opacity-10 text-primary-400"
              >
                <i class="bx bx-layout text-2xl"></i>
              </div>
              <h5 class="mr-1">{{ trans('Brand Name') }}</h5>
            </div>

            <button type="button" @click="modal.open('brandName')">
              <i class="bx bx-edit text-2xl"></i>
            </button>
          </div>

          <div class="flex h-52 items-center justify-center">
            <p class="text-3xl font-semibold md:text-5xl">{{ brand.name }}</p>
          </div>
        </div>
      </div>
      <!-- tagline -->
      <div class="card rounded-2xl pb-2">
        <div
          class="mb-4 flex items-center justify-between border-b border-gray-200 p-5 dark:border-gray-700"
        >
          <div class="flex items-center">
            <div
              class="mr-4 flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-primary-200 bg-opacity-10 text-primary-400"
            >
              <i class="bx bx-label text-2xl"></i>
            </div>
            <h5 class="mr-1">{{ trans('Tagline') }}</h5>
          </div>

          <button type="button" @click="modal.open('brandTagline')">
            <i class="bx bx-edit text-2xl"></i>
          </button>
        </div>

        <div class="flex h-48 items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24">
            <path
              fill="currentColor"
              d="M9.135 9h3L10 14.607H7L9.135 9Zm5 0h3L15 14.607h-3L14.135 9Z"
            />
          </svg>
          <p class="text-2xl font-semibold md:text-3xl">{{ brand.slogan }}</p>
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="mt-10"
            width="60"
            height="60"
            viewBox="0 0 24 24"
          >
            <path
              fill="currentColor"
              d="M9.135 9h3L10 14.607H7L9.135 9Zm5 0h3L15 14.607h-3L14.135 9Z"
            />
          </svg>
        </div>
      </div>
      <!-- Description -->

      <div class="card rounded-2xl pb-6">
        <div
          class="mb-5 flex items-center justify-between border-b border-gray-200 p-5 dark:border-gray-700"
        >
          <div class="flex items-center">
            <div
              class="mr-4 flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-primary-200 bg-opacity-10 text-primary-400"
            >
              <i class="bx bx-book-content text-2xl"></i>
            </div>
            <h5 class="mr-1">{{ trans('Brand Description') }}</h5>
          </div>

          <button type="button" @click="modal.open('brandDescription')">
            <i class="bx bx-edit text-2xl"></i>
          </button>
        </div>

        <div class="p-8">
          <p>
            {{ brand.description }}
          </p>
        </div>
      </div>
      <!-- colors -->
      <div class="card rounded-2xl pb-6">
        <div
          class="mb-5 flex items-center justify-between border-b border-gray-200 p-5 dark:border-gray-700"
        >
          <div class="flex items-center">
            <div
              class="mr-4 flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-primary-200 bg-opacity-10 text-primary-400"
            >
              <i class="bx bx-palette text-2xl"></i>
            </div>
            <h5 class="mr-1">{{ trans('Colors') }}</h5>
          </div>
          <button type="button" @click="modal.open('brandColor')">
            <i class="bx bx-edit text-2xl"></i>
          </button>
        </div>

        <div class="grid h-64 grid-cols-1 gap-8 px-5 md:grid-cols-2">
          <div class="flex items-center">
            <div
              class="flex h-full w-9/12 flex-col items-start justify-center rounded-l-2xl pl-20"
              :style="{ backgroundColor: brand.color.primary }"
            >
              <div class="rounded-md bg-gray-200 px-3 py-1 text-sm text-gray-500">
                <p class="font-semibold">{{ trans('Primary Color') }}</p>
                <p>{{ brand.color.primary }}</p>
              </div>
            </div>
            <div class="flex h-full w-3/12 flex-col">
              <div
                class="h-1/2 rounded-tr-2xl"
                :style="{ backgroundColor: brand.color.primary }"
              ></div>
              <div
                class="h-1/2 rounded-br-2xl"
                :style="{ backgroundColor: brand.color.primary }"
              ></div>
            </div>
          </div>
          <div class="flex items-center">
            <div
              class="flex h-full w-9/12 flex-col items-start justify-center rounded-l-2xl pl-20"
              :style="{ backgroundColor: brand.color.secondary }"
            >
              <div class="rounded-md bg-gray-200 px-3 py-1 text-sm text-gray-500">
                <p class="font-semibold">{{ trans('Secondary Color') }}</p>
                <p>{{ brand.color.secondary }}</p>
              </div>
            </div>
            <div class="flex h-full w-3/12 flex-col">
              <div
                class="h-1/2 rounded-tr-2xl"
                :style="{ backgroundColor: brand.color.secondary }"
              ></div>
              <div
                class="h-1/2 rounded-br-2xl"
                :style="{ backgroundColor: brand.color.secondary }"
              ></div>
            </div>
          </div>
        </div>
      </div>
      <!-- logo -->
      <div class="card rounded-2xl pb-6">
        <div
          class="mb-5 flex items-center justify-between border-b border-gray-200 p-5 dark:border-gray-700"
        >
          <div class="flex items-center">
            <div
              class="mr-4 flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-orange-200 bg-opacity-10 text-orange-400"
            >
              <i class="bx bx-flag text-2xl"></i>
            </div>
            <h5 class="mr-1">{{ trans('Logo') }}</h5>
          </div>

          <button type="button" @click="modal.open('brandLogo')">
            <i class="bx bx-edit text-2xl"></i>
          </button>
        </div>

        <div class="grid grid-cols-1 gap-4 px-5 md:grid-cols-2 md:gap-0">
          <div
            class="flex h-96 w-full flex-col items-start justify-center rounded-l-2xl border bg-[#ECF5F9]"
          >
            <img class="h-full w-full object-contain" :src="brand.logo" alt="brand" />
          </div>
          <div
            class="flex h-96 w-full flex-col items-start justify-center rounded-r-2xl border border-gray-600 bg-[#1C1C1E]"
          >
            <img class="h-full w-full object-contain" :src="brand.logo" alt="brand" />
          </div>
        </div>
      </div>
      <!-- Identity -->
      <div class="card rounded-2xl pb-6">
        <div
          class="mb-5 flex items-center justify-between border-b border-gray-200 p-5 dark:border-gray-700"
        >
          <div class="flex items-center">
            <div
              class="mr-4 flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-primary-200 bg-opacity-10 text-primary-400"
            >
              <i class="bx bx-fingerprint text-2xl"></i>
            </div>
            <h5 class="mr-1">{{ trans('Brand Identity') }}</h5>
          </div>

          <button type="button" @click="modal.open('brandIdentity')">
            <i class="bx bx-edit text-2xl"></i>
          </button>
        </div>

        <section class="p-8">
          <div class="space-y-4 px-6">
            <div>
              <p class="text-xl font-semibold text-primary-600">{{ trans('Mission') }}</p>
              <p class="ml-14">
                {{ brand.identities.mission }}
              </p>
            </div>

            <div>
              <p class="text-xl font-semibold text-primary-600">{{ trans('Vision') }}</p>
              <p class="ml-14">
                {{ brand.identities.vision }}
              </p>
            </div>

            <div>
              <p class="text-xl font-semibold text-primary-600">{{ trans('Values') }}</p>
              <p class="ml-14">{{ brand.identities.values }}</p>
            </div>
          </div>
        </section>
      </div>
      <!-- Audience,Strategy -->
      <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
        <div class="card rounded-2xl pb-6">
          <div
            class="mb-5 flex items-center justify-between border-b border-gray-200 p-5 dark:border-gray-700"
          >
            <div class="flex items-center">
              <div
                class="mr-4 flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-primary-200 bg-opacity-10 text-primary-400"
              >
                <i class="bx bx-group text-2xl"></i>
              </div>
              <h5 class="mr-1">{{ trans('Audience') }}</h5>
            </div>

            <button type="button" @click="modal.open('brandAudience')">
              <i class="bx bx-edit text-2xl"></i>
            </button>
          </div>

          <div class="space-y-4 px-5">
            <template v-for="(audience, i) in brand.audiences" :key="i">
              <div>
                <p class="font-semibold">{{ trans('Segment') }} {{ i + 1 }}</p>
                <p class="text-sm">
                  {{ audience.text }}
                </p>
              </div>
            </template>
          </div>
        </div>
        <div class="card rounded-2xl pb-6">
          <div
            class="mb-5 flex items-center justify-between border-b border-gray-200 p-5 dark:border-gray-700"
          >
            <div class="flex items-center">
              <div
                class="mr-4 flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-primary-200 bg-opacity-10 text-primary-400"
              >
                <i class="bx bx-bulb text-2xl"></i>
              </div>
              <h5 class="mr-1">{{ trans('Brand Strategy') }}</h5>
            </div>

            <button type="button" @click="modal.open('brandStrategy')">
              <i class="bx bx-edit text-2xl"></i>
            </button>
          </div>

          <div class="px-5">
            <p class="mb-2 text-xl font-semibold">{{ trans('Brand Promise') }}</p>
            <p class="text-sm">
              {{ brand.strategy }}
            </p>
          </div>
        </div>
      </div>
      <!-- Voice -->

      <div class="card rounded-2xl pb-6">
        <div
          class="mb-5 flex items-center justify-between border-b border-gray-200 p-5 dark:border-gray-700"
        >
          <div class="flex items-center">
            <div
              class="mr-4 flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-primary-200 bg-opacity-10 text-primary-400"
            >
              <i class="bx bx-user-voice text-2xl"></i>
            </div>
            <h5 class="mr-1">{{ trans('Brand Voice') }}</h5>
          </div>

          <button type="button" @click="modal.open('brandVoice')">
            <i class="bx bx-edit text-2xl"></i>
          </button>
        </div>

        <div class="space-y-8">
          <div class="px-5">
            <p class="mb-2 text-xl font-semibold">{{ trans('Expressing Message') }}</p>
            <p>
              {{ brand.voices.message }}
            </p>
          </div>
          <div class="flex flex-col px-5 md:flex-row">
            <p class="mb-2 w-48 text-xl font-semibold">{{ trans('Tone') }}</p>
            <div class="flex flex-col items-start gap-y-5">
              <template v-for="tone in brand.voices.tones" :key="tone">
                <div class="flex items-start">
                  <i class="bx bxs-checkbox text-3xl text-primary-700"></i>
                  <p class="ml-5 text-lg font-semibold uppercase">
                    {{ tone.text }}
                  </p>
                </div>
              </template>
            </div>
          </div>
        </div>
      </div>
      <!-- btn -->
      <div class="flex flex-col justify-end gap-5 md:flex-row">
        <Link :href="route('user.brand.create')" class="btn btn-primary">
          <i class="bx bx-refresh text-2xl"></i>
          <span>{{ trans('Create New Brand') }}</span>
        </Link>
        <Link
          :href="route('user.brand-posts.index', { brand: brand.uuid })"
          class="btn bg-secondary-200 text-secondary-950 hover:bg-secondary-300"
        >
          <i class="bx bx-plus text-2xl"></i>
          <span>{{ trans('Create Post') }}</span>
        </Link>
        <Link
          :href="route('brand.share', brand.uuid)"
          class="btn bg-secondary-200 text-secondary-950 hover:bg-secondary-300"
        >
          <i class="bx bx-share text-2xl"></i>
          <span>{{ trans('Share') }}</span>
        </Link>
      </div>
    </div>
  </main>
</template>
