<script setup>
import sharedComposable from '@/Composables/sharedComposable'
import FloatingDropdown from '@/Components/Admin/FloatingDropdown.vue'

defineProps({
  assets: [Object, Array]
})

const { deleteRow } = sharedComposable()
</script>

<template>
  <div
    v-for="(asset, i) in assets"
    :key="i"
    class="relative h-60 overflow-hidden rounded-lg border border-gray-200 dark:border-gray-800"
  >
    <div class="absolute right-1 top-1 z-10">
      <FloatingDropdown
        btn-type="icon"
        icon-name="bx:dots-vertical-rounded"
        btnClass="p-1 bg-dark-100 dark:bg-dark-800 rounded-full"
      >
        <div class="flex h-full flex-col">
          <Link
            v-if="asset.mime_type === 'image'"
            :href="route('user.image-editor.edit', asset.uuid)"
            class="dropdown-link py-1.5"
          >
            <Icon icon="fe:edit" />
            <span class="text-sm">{{ trans('Edit') }}</span>
          </Link>
          <Link
            as="button"
            class="dropdown-link py-1.5"
            @click="deleteRow(route('user.assets.destroy', asset.id))"
          >
            <Icon icon="fe:trash" />
            <span class="text-sm">{{ trans('Delete') }}</span>
          </Link>
        </div>
      </FloatingDropdown>
    </div>

    <template v-if="asset.mime_type === 'image'">
      <img v-lazy="asset.path" class="h-52 w-full object-cover" alt="image" />
    </template>
    <template v-if="asset.mime_type === 'video'">
      <video controls class="h-52 w-full">
        <source :src="asset.path" type="video/mp4" />
      </video>
    </template>
    <template v-if="asset.mime_type === 'voice'">
      <audio controls class="h-52 w-full">
        <source :src="asset.path" type="audio/wav" />
        <source :src="asset.path" type="audio/mp3" />
      </audio>
    </template>
    <div class="ml-auto mt-1 flex max-w-max items-center rounded-md px-1">
      <i class="bx bx-file-blank mr-1 text-base"></i>

      <span class="text-xs font-semibold capitalize">{{ asset.file_size }} MB</span>
    </div>
  </div>
</template>
