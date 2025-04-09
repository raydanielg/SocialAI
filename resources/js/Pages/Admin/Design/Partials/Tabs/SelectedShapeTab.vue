<script setup>
import { useDesignStore } from '@/Store/Admin/designStore'

const store = useDesignStore()
</script>
<template>
  <div class="mt-6 space-y-6">
    <label class="label mb-1">Change Colors</label>
    <div class="flex items-center gap-3" v-if="store.shapeStyles.fill">
      <div class="h-10 w-10 overflow-hidden rounded-full">
        <input
          v-model="store.shapeStyles.fill"
          @input="store.changeShapeStyle"
          class="h-14 w-12 -translate-x-1 -translate-y-2 rounded-xl bg-transparent text-sm text-slate-700 outline-none placeholder:text-slate-400 focus:ring-0 focus:ring-primary-500 dark:text-slate-200"
          type="color"
          name="file"
        />
      </div>
      <p class="w-16">
        {{ store.shapeStyles.fill }}
      </p>
    </div>

    <div class="flex items-center gap-3" v-if="store.shapeStyles.stroke">
      <div class="h-10 w-10 overflow-hidden rounded-full">
        <input
          v-model="store.shapeStyles.stroke"
          @input="store.changeShapeStyle"
          class="h-14 w-12 -translate-x-1 -translate-y-2 rounded-xl bg-transparent text-sm text-slate-700 outline-none placeholder:text-slate-400 focus:ring-0 focus:ring-primary-500 dark:text-slate-200"
          type="color"
          name="file"
        />
      </div>
      <p class="w-16">
        {{ store.shapeStyles.stroke }}
      </p>
    </div>
  </div>
</template>
