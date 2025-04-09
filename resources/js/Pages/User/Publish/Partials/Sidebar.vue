<script setup>
import { usePublishStore } from '@/Store/publishStore'

import TabButton from './TabButton.vue'

const store = usePublishStore()
</script>

<template>
  <div class="card flex h-screen w-16 flex-col justify-between p-1 lg:w-2/12 lg:p-6">
    <div>
      <Link
        :href="route('user.brand-posts.index')"
        class="mb-7 flex max-w-max items-center gap-1 rounded-md pr-2 hover:bg-gray-200 dark:hover:bg-gray-900"
      >
        <i class="bx bx-chevron-left text-2xl"></i>
        <span class="mb-1 hidden text-lg lg:inline">Back</span>
      </Link>
      <p class="my-4 hidden text-xl lg:block">{{ store.form.title }}</p>

      <TabButton title="input" icon="bx-file" />
    </div>

    <div class="flex flex-col gap-y-3">
      <TabButton title="designs" icon="bx-palette" />
      <TabButton title="text" icon="bx-text" />
      <TabButton title="images" icon="bx-image" />
      <TabButton title="videos" icon="bx-video" />
    </div>
    <TabButton title="connect" text="Connected Accounts" icon="bx-share-alt" />
  </div>
</template>
