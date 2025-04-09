<script setup>
import sharedComposable from '@/Composables/sharedComposable'
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
defineOptions({ layout: AdminLayout })
const props = defineProps(['buttons', 'posts'])

const { textExcerpt } = sharedComposable()
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader :title="trans('SEO Settings')" :buttons="buttons" />
    <div class="space-y-6">
      <div class="table-responsive table-hover whitespace-nowrap rounded-primary">
        <table class="table">
          <thead>
            <tr>
              <th>{{ trans('Page') }}</th>
              <th colspan="1">{{ trans('Meta Information') }}</th>
              <th>
                <p class="text-right">{{ trans('Action') }}</p>
              </th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="seo in posts" :key="seo">
              <td>
                {{ seo.key }}
              </td>
              <td>
                <div
                  class="mb-2 flex items-center gap-2"
                  v-for="key in Object.keys(seo.content)"
                  :key="key"
                >
                  <p class="w-32 text-sm font-semibold capitalize text-white">{{ key }}:</p>
                  <template v-if="key == 'preview'">
                    <img v-if="seo.content[key]" class="w-16" :src="seo.content[key]" />
                  </template>
                  <template v-else>
                    <span> {{ textExcerpt(seo.content[key], 120) }}</span>
                  </template>
                </div>
              </td>

              <td>
                <div class="flex justify-end">
                  <Link :href="route('admin.seo.edit', seo.id)" class="btn btn-primary btn-sm">
                    <Icon icon="bx:pencil" />
                  </Link>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </main>
</template>
