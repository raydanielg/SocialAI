<script setup>
import { Head, usePage } from '@inertiajs/vue3'
import { defineAsyncComponent } from 'vue'
const props = defineProps(['title', 'buttons', 'segments', 'classes', 'overviews', 'overviewGrid'])
const pageHeader = usePage().props.pageHeader ?? {}

const title = props.title ?? pageHeader.title ?? ''
const buttons = props.buttons ?? pageHeader.buttons ?? []
const segments = props.segments ?? pageHeader.segments ?? []
const overviews = props.overviews?.length || (pageHeader.overviews ?? [])
const OverviewGrid = defineAsyncComponent(() => import('@root/Components/Admin/OverviewGrid.vue'))
</script>

<template>
  <Head :title="title" />

  <div :class="classes" class="mb-4 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <ol class="breadcrumb">
      <template v-if="segments.length">
        <li v-for="segment in segments" :key="segment.index" class="breadcrumb-item capitalize">
          {{ segment }}
        </li>
      </template>
    </ol>
    <template v-if="segments.length">
      <div class="space-y-1 text-right">
        <template v-for="button in buttons" :key="button.index">
          <Link
            v-if="button.url != '#' && button.url"
            :href="button.url || '#'"
            class="btn btn-sm btn-primary mx-2"
          >
            <div v-html="sanitizeHtml(button.name)"></div>
          </Link>
          <button
            v-else
            @click="(e) => e.preventDefault()"
            data-toggle="drawer"
            :data-target="button.target"
            class="btn btn-sm btn-primary mx-2 text-center"
          >
            <div v-html="sanitizeHtml(button.name)"></div>
          </button>
        </template>
      </div>
    </template>
  </div>
  <OverviewGrid v-if="overviews" :items="overviews" :grid="overviews?.length ?? 1" />
</template>