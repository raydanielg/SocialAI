<script setup>
import sharedComposable from '@/Composables/sharedComposable'
import BlankLayout from '@/Layouts/BlankLayout.vue'
import { Head } from '@inertiajs/vue3'
const props = defineProps(['brand'])
defineOptions({ layout: BlankLayout })

const { copyToClipboard } = sharedComposable()

const location = window.location.href
</script>

<template>
  <Head :title="trans('Share Brand')" />

  <main class="container flex-grow p-4 sm:p-6">
    <div class="space-y-8">
      <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
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
          </div>

          <div class="flex h-52 items-center justify-center">
            <p class="text-3xl font-semibold md:text-5xl">{{ brand.name }}</p>
          </div>
        </div>
        <!-- slogan -->
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
              <h5 class="mr-1 text-center">{{ trans('Tagline') }}</h5>
            </div>
          </div>

          <div class="flex h-48 items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24">
              <path
                fill="currentColor"
                d="M9.135 9h3L10 14.607H7L9.135 9Zm5 0h3L15 14.607h-3L14.135 9Z"
              />
            </svg>
            <p class="break-all text-2xl font-semibold md:text-3xl">{{ brand.slogan }}</p>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="mt-4"
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
        </div>

        <div class="grid h-64 grid-cols-1 gap-8 px-5 md:grid-cols-2">
          <div class="flex items-center">
            <div
              class="flex h-full w-9/12 flex-col items-start justify-center rounded-l-2xl pl-20"
              :style="{ backgroundColor: brand.color.primary }"
            >
              <p class="font-semibold">{{ trans('Primary Color') }}</p>
              <p class="text-gray-300">{{ brand.color.primary }}</p>
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
              <p class="font-semibold">{{ trans('Secondary Color') }}</p>
              <p class="text-gray-300">{{ brand.color.secondary }}</p>
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
        </div>

        <div class="grid grid-cols-1 gap-3 px-5 md:grid-cols-2 md:gap-0">
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
        </div>

        <div class="space-y-8">
          <div class="px-5">
            <p class="mb-2 text-xl font-semibold">{{ trans('Expressing Message') }}</p>
            <p>
              {{ brand.voices.message }}
            </p>
          </div>
          <div class="flex flex-col px-5 md:flex-row">
            <p class="mb-2 w-48 text-xl font-semibold">Tone</p>
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
      <div class="flex justify-end">
        <button @click="copyToClipboard(location)" class="btn btn-primary btn-sm">
          <i class="bx bx-clipboard text-xl"></i>
          <span>{{ trans('Copy Url') }}</span>
        </button>
      </div>
    </div>
  </main>
</template>
