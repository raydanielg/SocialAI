<script setup>
import {
  computed,
  ref,
} from "vue"

import moment from "moment"

import NoDataFound from "@/Components/Admin/NoDataFound.vue"
import OverviewGrid from "@/Components/Admin/OverviewGrid.vue"
import Paginate from "@/Components/Admin/Paginate.vue"
import sharedComposable from "@/Composables/sharedComposable"
import trans from "@/Composables/transComposable"
import PageHeader from "@/Layouts/Admin/PageHeader.vue"
import UserLayout from "@/Layouts/User/UserLayout.vue"
import { router } from "@inertiajs/vue3"

defineOptions({ layout: UserLayout })

const props = defineProps(['aiGenerated', 'total', 'totalCharges', 'totalResults', 'segments'])
const stats = computed(() => {
  return [
    {
      value: props.total,
      title: trans('Total'),
      iconClass: 'bx:receipt'
    },
    {
      value: props.totalCharges,
      title: trans('Total Charges'),
      iconClass: 'bx:dollar'
    },
    {
      value: props.totalResults,
      title: trans('Total Results'),
      iconClass: 'bx:food-menu'
    }
  ]
})
const { pickBy, textExcerpt, trim } = sharedComposable()
const filterForm = ref({
  order: 'active'
})
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader title="AI History" :buttons="[]" />
    <OverviewGrid :items="stats" grid="3" />
    <div class="my-3 flex items-center justify-end gap-x-2">
      <div class="dropdown" data-placement="bottom-end">
        <div class="dropdown-toggle">
          <button type="button" class="btn bg-white font-medium shadow-sm dark:bg-slate-800">
            <Icon icon="fe:filter" />
            <span>{{ trans('Filter') }}</span>
            <Icon icon="bx:chevron-down" />
          </button>
        </div>

        <div class="dropdown-content w-72 !overflow-visible">
          <form @submit.prevent="filterData.get(route('user.ai-generated-history.index'))">
            <ul class="dropdown-list space-y-4 p-4">
              <li class="dropdown-list-item">
                <h2 class="my-1 text-sm font-medium">{{ trans('Status') }}</h2>
                <div class="mb-2">
                  <select class="select" name="type" v-model="filterForm.order">
                    <option value="active">{{ trans('Active') }}</option>
                    <option value="inactive">{{ trans('Inactive') }}</option>
                  </select>
                </div>
              </li>

              <li class="dropdown-list-item">
                <button type="submit" class="btn btn-primary w-full">
                  {{ trans('Filter') }}
                </button>
              </li>
            </ul>
          </form>
        </div>
      </div>
    </div>
    <div class="table-responsive whitespace-nowrap rounded-primary">
      <table class="table">
        <thead>
          <tr>
            <th>{{ trans('Generated For') }}</th>
            <th>{{ trans('Title/Name') }}</th>
            <th>{{ trans('Charge') }}</th>

            <th>
              {{ trans('Total Words') }}
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
              <Link class="underline" :href="route('user.ai-generated-history.edit', generated.uuid)">
              {{
                textExcerpt(
                  generated?.generatable?.title || generated?.generatable?.name || 'N/A',
                  30
                )
              }}
              </Link>
            </td>
            <td>
              {{ generated.charge }}
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
        <NoDataFound v-else :for-table="true" />
      </table>
    </div>
    <Paginate :links="aiGenerated.links" />
  </main>
</template>
