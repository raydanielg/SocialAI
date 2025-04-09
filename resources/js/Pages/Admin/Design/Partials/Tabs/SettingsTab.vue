<script setup>
import { useDesignStore } from '@/Store/Admin/designStore'
import { ref } from 'vue'
import toast from '@/Composables/toastComposable'
const store = useDesignStore()

const title = ref(store.form.title || '')
const save = () => {
  store.$patch({
    form: { title: title.value }
  })
  toast.success('Title Saved')
}
</script>
<template>
  <h3>Settings</h3>

  <div class="mt-4 space-y-4">
    <div>
      <label class="label mb-1">Title</label>
      <div class="flex gap-2">
        <input type="text" class="input" v-model="title" />
        <button type="button" class="btn btn-soft-primary" @click="save">Save</button>
      </div>
    </div>
    <button
      @click="
        () => {
          store.canvasStyles.backgroundColor = 'transparent'
          store.changeCanvasStyle()
        }
      "
      class="btn btn-soft-primary"
    >
      Remove Background
    </button>
    <div class="flex items-center justify-between gap-2">
      <span class="text-lg">BG Color </span>

      <div class="flex items-center gap-3">
        <div class="h-10 w-10 overflow-hidden rounded-full">
          <input
            v-model="store.canvasStyles.backgroundColor"
            @input="store.changeCanvasStyle"
            class="h-14 w-12 -translate-x-1 -translate-y-2 rounded-xl bg-transparent text-sm text-slate-700 outline-none placeholder:text-slate-400 focus:ring-0 focus:ring-primary-500 dark:text-slate-200"
            type="color"
            name="file"
          />
        </div>
        <p class="w-16">
          {{ store.canvasStyles.backgroundColor }}
        </p>
      </div>
    </div>
  </div>
</template>
