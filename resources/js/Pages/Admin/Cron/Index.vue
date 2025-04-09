<template>
  <Head title="Cron Jobs" />
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader :title="trans('Cron Jobs')" />
    <div class="space-y-6">
      <div class="row" v-for="job in jobs" :key="job.key">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="flex items-center space-x-5">
                <h6 class="card-title">{{ job.title }}</h6>
                <p class="text-green-900 dark:text-primary-50">
                  ({{ job.time }})
                </p>
              </div>
              <div class="code-viewer mt-4 rounded-lg p-4">
                <code> {{ job.url }}</code>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
export default {
  layout: AdminLayout
}
</script>

<script setup>
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import { Head } from '@inertiajs/vue3'

const props = defineProps(['segments', 'buttons', 'jobs'])
</script>
