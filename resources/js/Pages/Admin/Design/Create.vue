<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import { useDesignStore } from '@/Store/Admin/designStore'
import { onMounted, ref, defineAsyncComponent, onUnmounted } from 'vue'
import { Head } from '@inertiajs/vue3'
import { storeToRefs } from 'pinia'

defineOptions({ layout: AdminLayout })
defineProps(['shapes'])
const store = useDesignStore()
const { getTabState, getSelectedObjectState } = storeToRefs(store)
const canvasEl = ref(null)

onMounted(() => store.initializeCanvas(canvasEl.value))
const SettingsTab = defineAsyncComponent(() => import('./Partials/Tabs/SettingsTab.vue'))
const TextTab = defineAsyncComponent(() => import('./Partials/Tabs/TextTab.vue'))
const ShapeTab = defineAsyncComponent(() => import('./Partials/Tabs/ShapeTab.vue'))
const ImageTab = defineAsyncComponent(() => import('./Partials/Tabs/ImageTab.vue'))
const PlaceholderTab = defineAsyncComponent(() => import('./Partials/Tabs/PlaceholderTab.vue'))
const SelectedTextTab = defineAsyncComponent(() => import('./Partials/Tabs/SelectedTextTab.vue'))
const SelectedShapeTab = defineAsyncComponent(() => import('./Partials/Tabs/SelectedShapeTab.vue'))
const SelectedGroupTab = defineAsyncComponent(() => import('./Partials/Tabs/SelectedGroupTab.vue'))
const SelectedImageTab = defineAsyncComponent(() => import('./Partials/Tabs/SelectedImageTab.vue'))

onUnmounted(() => store.$reset())
</script>

<template>
  <Head title="Design Create" />

  <div class="mt-4 flex h-20 flex-col items-start justify-between gap-2 px-6 lg:flex-row">
    <Link :href="route('admin.design.index')" class="btn btn-dark btn-md">
      <i class="bx bx-chevron-left"></i>
      <span>Back</span>
    </Link>

    <div class="card max-w-max space-x-2 rounded-md p-2">
      <template v-for="tab in store.tabLists" :key="tab.label">
        <button
          class="btn px-2 py-1 transition-colors hover:bg-primary-800/60 hover:text-white"
          @click="store.setTab(tab.label)"
          :class="{ 'btn-soft-primary': getTabState(tab.label) }"
        >
          <i class="bx text-xl" :class="`${tab.icon}`"></i>
        </button>
      </template>
    </div>

    <div class="flex justify-end gap-3">
      <button
        @click="store.submit('inactive')"
        class="btn bg-secondary-100 py-1 text-secondary-950 hover:bg-secondary-300"
      >
        <i class="bx bx-memory-card text-2xl"></i>
        <span>Save </span>
      </button>
      <button @click="store.submit('active')" class="btn btn-soft-primary py-1">
        <i class="bx bx-paper-plane text-2xl"></i>
        <span>Publish</span>
      </button>
    </div>
  </div>

  <div class="mt-2 flex min-h-[calc(100vh-12rem)]">
    <div class="w-full overflow-y-auto px-3 lg:px-6">
      <!-- content -->
      <div class="mt-2 grid grid-cols-1 gap-y-8 lg:grid-cols-12 lg:gap-x-8">
        <div
          class="card styled-scrollbar col-span-3 overflow-y-auto overflow-x-hidden rounded-2xl p-5 lg:h-[calc(100vh-13rem)]"
        >
          <SettingsTab v-if="getTabState('settings')" />
          <TextTab v-if="getTabState('text')" />
          <ShapeTab v-if="getTabState('shapes')" :shapes="shapes" />
          <ImageTab v-if="getTabState('image')" />
          <PlaceholderTab v-if="getTabState('placeholder')" />
          <SelectedTextTab v-if="getSelectedObjectState('i-text')" />
          <SelectedShapeTab v-if="getSelectedObjectState('shape')" />
          <SelectedGroupTab v-if="getSelectedObjectState('group')" />
          <SelectedImageTab v-if="getSelectedObjectState('image')" />
        </div>

        <div class="col-span-9 ml-24">
          {{ store.canvasLoading ? 'loading...' : '' }}
          <div
            class="card mb-5 mt-3 flex max-w-max items-center gap-1 rounded-md p-2"
            :class="store.selectedObject ? 'visible opacity-100' : 'invisible opacity-0'"
          >
            <div class="flex items-center gap-1">
              <label class="label">Opacity</label>
              <input
                step="5"
                @input="store.changeObjectOpacity"
                v-model="store.objectOpacity"
                class="cursor-pointer accent-primary-600"
                type="range"
                min="0"
                max="100"
              />
              <span class="label card w-10 rounded-md px-2 py-1 text-center">
                {{ store.objectOpacity }}
              </span>
            </div>
            <button
              @click="store.bringToFront"
              class="btn px-2 py-1 hover:bg-primary-800/60 hover:text-white"
            >
              <i class="bx bxs-arrow-from-bottom text-xl"></i>
            </button>
            <button
              @click="store.sendToBack"
              class="btn px-2 py-1 hover:bg-primary-800/60 hover:text-white"
            >
              <i class="bx bxs-arrow-from-top text-xl"></i>
            </button>
            <button @click="store.remove" class="btn p-2 hover:bg-primary-800/60 hover:text-white">
              <i class="bx bxs-trash-alt"></i>
            </button>
          </div>
          <canvas
            ref="canvasEl"
            class="rounded border border-secondary-200 shadow dark:border-secondary-800"
          ></canvas>
        </div>
      </div>
    </div>
  </div>
</template>
