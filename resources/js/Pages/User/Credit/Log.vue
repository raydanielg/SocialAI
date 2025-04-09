<script setup>
import UserLayout from '@/Layouts/User/UserLayout.vue'
import Paginate from '@/Components/WebPaginate.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import moment from 'moment'
import { computed } from 'vue'
import sharedComposable from '@/Composables/sharedComposable'
import NoDataFound from '@/Components/Admin/NoDataFound.vue'
const { formatCurrency } = sharedComposable()
defineOptions({ layout: UserLayout })
const props = defineProps([
  'creditLogs',
  'credit_fee',
  'gateways',
  'totalCosts',
  'totalCredits',

  'buttons'
])

const primaryOverview = computed(() => {
  return [
    {
      title: 'Total Purchase',
      value: props.creditLogs.total,
      icon: 'bx bx-box',
      classes: 'bg-primary-500 text-primary-500'
    },
    {
      title: 'Total Costs',
      value: formatCurrency(props.totalCosts),
      icon: 'bx bx-dollar-circle',
      classes: 'text-success-500 bg-success-500'
    },
    {
      title: 'Total Credits',
      value: props.totalCredits,
      icon: 'bx bxs-receipt',
      classes: 'text-warning-500 bg-warning-500'
    }
  ]
})
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader title="Credit Logs" :buttons="buttons" />

    <section class="mb-5 grid grid-cols-1 gap-8 sm:grid-cols-2 xl:grid-cols-3">
      <!-- primary Overview -->
      <template v-for="(item, index) in primaryOverview" :key="index">
        <div class="card rounded-2xl">
          <div class="flex items-center gap-3 p-5">
            <div
              class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-opacity-10"
              :class="item.classes"
            >
              <i class="text-2xl" :class="item.icon"></i>
            </div>
            <div class="flex flex-1 flex-col">
              <p class="text-sm tracking-wide text-slate-500">
                {{ item.title }}
              </p>
              <h5>{{ item.value }}</h5>
            </div>
          </div>
        </div>
      </template>
    </section>

    <div class="card card-body">
      <div v-if="creditLogs.total" class="table-responsive">
        <table class="job-alert-table table">
          <thead>
            <tr>
              <th scope="col">{{ trans('Transaction No') }}</th>
              <th scope="col">{{ trans('Credits') }}</th>
              <th scope="col">{{ trans('Price') }}</th>
              <th scope="col">{{ trans('Status') }}</th>
              <th scope="col">{{ trans('Gateway') }}</th>
              <th scope="col">{{ trans('Date') }}</th>
            </tr>
          </thead>
          <tbody class="border-0">
            <tr
              :class="{
                active: creditLog.status == 1,
                pending: creditLog.status != 1
              }"
              v-for="creditLog in creditLogs.data"
              :key="creditLog.id"
            >
              <td>
                {{ creditLog.invoice_no }}
              </td>
              <td>
                {{ creditLog.credits }}
              </td>
              <td>
                {{ formatCurrency(creditLog.price) }}
              </td>
              <td>
                <span v-if="creditLog.status == 1" class="badge badge-primary">
                  {{ trans('Complete') }}
                </span>
                <span v-else-if="creditLog.status == 0" class="badge badge-warning">
                  {{ trans('Pending') }}
                </span>
              </td>
              <td>
                {{ creditLog.gateway.name }}
              </td>
              <td>
                <p>
                  {{ moment(creditLog.updated_at).format('DD MMM Y') }}
                </p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <NoDataFound v-else />

      <Paginate :links="creditLogs.links" />
    </div>
  </main>
</template>
