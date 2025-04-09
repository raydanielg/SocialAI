<script setup>
import sharedComposable from '@/Composables/sharedComposable'
import { usePublishStore } from '@/Store/publishStore'
const store = usePublishStore()

const { copyToClipboard, countWordsAndChars } = sharedComposable()
</script>

<template>
  <label class="label mb-3 text-lg">Title </label>
  <input type="text" v-model="store.form.title" class="input mb-2" placeholder="Title" />
  <label class="label mb-3 text-lg">Original Input </label>
  <textarea
    v-model="store.form.input"
    class="textarea min-h-[20rem]"
    placeholder="Original Input"
  ></textarea>
  <p class="text-end text-xs">
    Characters: {{ countWordsAndChars(store.form.input).characters }} / Words:
    {{ countWordsAndChars(store.form.input).words }}
  </p>
  <div class="mt-4 flex justify-end gap-3">
    <button class="btn btn-outline-primary" @click="copyToClipboard(store.form.input)">
      Copy Input
    </button>
    <button class="btn btn-soft-primary" @click="store.draftPost()">Update</button>
  </div>
</template>
