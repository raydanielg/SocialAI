<script setup>
import { computed } from "vue";

import moment from "moment";

import NoDataFound from "@/Components/Admin/NoDataFound.vue";
import Paginate from "@/Components/Admin/Paginate.vue";
import sharedComposable from "@/Composables/sharedComposable";
import PageHeader from "@/Layouts/Admin/PageHeader.vue";
import UserLayout from "@/Layouts/User/UserLayout.vue";

const { textExcerpt } = sharedComposable()
defineOptions({ layout: UserLayout })
const props = defineProps(['creditHistory', 'totalCharge', 'total', 'totalToday', 'buttons'])

const primaryOverview = computed(() => {
  return [
    {
      title: 'Total',
      value: props.total,
      icon: 'bx bx-box',
      classes: 'bg-primary-500 text-primary-500'
    },
    {
      title: 'Total Credits',
      value: props.totalCharge,
      icon: 'bx bx-dollar-circle',
      classes: 'text-success-500 bg-success-500'
    },
    {
      title: 'Total Credits',
      value: props.totalToday,
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
      <div v-if="creditHistory.total" class="table-responsive">
        <table class="job-alert-table table">
          <thead>
            <tr>
              <th>{{ trans('Description') }}</th>
              <th>{{ trans('Credits') }}</th>
              <th>{{ trans('Date') }}</th>
            </tr>
          </thead>
          <tbody class="border-0">
            <tr v-for="history in creditHistory.data" :key="history.id">
              <td>
                {{ textExcerpt(history?.description, 50) }}
              </td>
              <td>
                {{ history.charge }}
              </td>

              <td>
                <p>
                  {{ moment(history.updated_at).format('DD MMM Y') }}
                </p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <NoDataFound v-else />

      <Paginate :links="creditHistory.links" />
    </div>
  </main>
</template>
