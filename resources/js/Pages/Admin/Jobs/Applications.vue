<script setup>
import { computed, onMounted, ref } from 'vue'

import moment from 'moment'

import NoDataFound from '@/Components/Admin/NoDataFound.vue'
import Overview from '@/Components/Admin/OverviewGrid.vue'
import Paginate from '@/Components/Admin/Paginate.vue'
import sharedComposable from '@/Composables/sharedComposable'
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import drawer from '@/Plugins/Admin/drawer'
import notify from '@/Composables/toastComposable'
import { router, useForm } from '@inertiajs/vue3'

defineOptions({ layout: AdminLayout })
const { deleteRow } = sharedComposable()
const props = defineProps(['applications', 'job', 'buttons', 'segments'])
</script>

<template>
  <main class="container p-4 sm:p-6">
    <PageHeader title="Job Applications" :buttons="buttons" />
    <div class="space-y-6">
      <div class="flex justify-between">
        <h6 class="mb-0 pb-0">{{ trans('Job') }}: {{ job.title }}</h6>
        <h6>{{ trans('Total Applications') }}: {{ applications.total }}</h6>
      </div>
      <div class="table-responsive whitespace-nowrap rounded-primary">
        <table class="table">
          <thead>
            <tr>
              <th>{{ trans('Name') }}</th>
              <th>{{ trans('Email') }}</th>
              <th>{{ trans('Phone') }}</th>
              <th>{{ trans('Address') }}</th>
              <th>{{ trans('Experience') }}</th>
              <th>{{ trans('Salary Expect') }}</th>
              <th>{{ trans('Resume') }}</th>
              <th>{{ trans('Submitted At') }}</th>
            </tr>
          </thead>

          <tbody v-if="applications.total">
            <tr v-for="item in applications.data" :key="item.id">
              <td>{{ item.name }}</td>
              <td>{{ item.email }}</td>
              <td>{{ item.phone }}</td>
              <td>{{ item.address }}</td>
              <td>{{ item.experience }}</td>
              <td>{{ item.expected_salary }}</td>
              <td>
                <a v-if="item.cv" target="_blank" class="btn btn-primary btn-sm" :href="item.cv">{{
                  trans('View')
                }}</a>
              </td>
              <td>
                {{ moment(item.created_at).format('D-MMM-Y') }}
              </td>
            </tr>
          </tbody>
          <NoDataFound v-else for-table="true" />
        </table>
      </div>
      <Paginate :links="applications.links" />
    </div>
  </main>
</template>
