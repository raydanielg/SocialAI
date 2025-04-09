<script setup>
import { useDesignStore } from '@/Store/Admin/designStore'

const store = useDesignStore()
</script>
<template>
  <div class="mb-6 flex flex-col gap-y-3">
    <template v-for="obj in store.objectStyles" :key="obj">
      <div class="flex items-center gap-3">
        <div class="h-10 w-10 overflow-hidden rounded-full">
          <input
            v-model="obj.fill"
            class="h-14 w-12 -translate-x-1 -translate-y-2 rounded-xl bg-transparent text-sm text-slate-700 outline-none placeholder:text-slate-400 focus:ring-0 focus:ring-primary-500 dark:text-slate-200"
            type="color"
            name="file"
          />
        </div>
        <p class="w-16">
          {{ obj.fill }}
        </p>
      </div>
    </template>
  </div>
  <button class="btn btn-soft-primary w-full" type="button" @click="store.changeGroupObjectStyle()">
    Update Changes
  </button>
</template>
