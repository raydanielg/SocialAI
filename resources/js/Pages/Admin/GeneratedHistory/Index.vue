<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import { useForm } from '@inertiajs/vue3'
import Paginate from '@/Components/Admin/Paginate.vue'
import moment from 'moment'
import trans from '@/Composables/transComposable'
import sharedComposable from '@/Composables/sharedComposable'
import Overview from '@/Components/Admin/OverviewGrid.vue'
import NoDataFound from '@/Components/Admin/NoDataFound.vue'

defineOptions({ layout: AdminLayout })
const { formatCurrency, textExcerpt, trim } = sharedComposable()

const props = defineProps([
  'aiGenerated',
  'total',
  'totalCharges',
  'totalResults',
  'buttons',
  'segments',
  'request',
  'type'
])

const stats = [
  {
    value: props.total,
    title: trans('Total Records'),
    iconClass: 'bx:badge'
  },
  {
    value: props.totalCharges,
    title: trans('Total Charges'),
    iconClass: 'bx:badge-check'
  },
  {
    value: props.totalResults,
    title: trans('Total Results'),
    iconClass: 'bx:bullseye'
  }
]
</script>

<template>
  <main class="container p-4 sm:p-6">
    <PageHeader title="Generated History" :buttons="buttons" />
    <div class="space-y-6">
      <Overview :items="stats" grid="3" />

      <div class="table-responsive whitespace-nowrap rounded-primary">
        <table class="table">
          <thead>
            <tr>
              <th>{{ trans('Generated For') }}</th>
              <th>{{ trans('Title/Name') }}</th>
              <th>{{ trans('User Name') }}</th>
              <th>{{ trans('Charge') }}</th>

              <th>
                {{ trans('Result') }}
              </th>
              <th>
                {{ trans('Length') }}
              </th>
              <th>
                {{ trans('Content') }}
              </th>

              <th>
                <p class="text-end">{{ trans('Date') }}</p>
              </th>
            </tr>
          </thead>

          <tbody v-if="aiGenerated.total > 0">
            <tr v-for="generated in aiGenerated.data" :key="generated.id">
              <td class="capitalize">
                {{ trim(generated.type ?? 'N/A') }}
              </td>
              <td>
                <Link :href="route('admin.users.show', generated.user_id)">
                {{
                  textExcerpt(
                    generated?.generatable?.title || generated?.generatable?.name || 'N/A',
                    30
                  )
                }}
                </Link>
              </td>

              <td>
                {{ generated.user?.name }}
              </td>
              <td>
                {{ formatCurrency(generated.charge) }}
              </td>
              <td>
                {{ generated.result }}
              </td>

              <td>
                {{ generated.length }}
              </td>
              <td>
                {{ textExcerpt(generated.content, 100) }}
              </td>

              <td class="text-left">
                <p class="text-end">{{ moment(generated.updated_at).format('DD MMM, YYYY') }}</p>
              </td>
            </tr>
          </tbody>
          <NoDataFound v-else for-table="true" />
        </table>
      </div>
      <Paginate :links="aiGenerated.links" />
    </div>
  </main>
</template>
