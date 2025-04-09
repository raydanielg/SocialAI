<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import Paginate from '@/Components/Admin/Paginate.vue'
import moment from 'moment'
import trans from '@/Composables/transComposable'
import sharedComposable from '@/Composables/sharedComposable'
import Overview from '@/Components/Admin/OverviewGrid.vue'
import { computed } from 'vue'
import NoDataFound from '@/Components/Admin/NoDataFound.vue'

defineOptions({ layout: AdminLayout })
const { deleteRow } = sharedComposable()

const props = defineProps([
  'logos',
  'categories',
  'total',
  'active',
  'inActive',
  'buttons',
  'segments'
])
const stats = computed(() => {
  return [
    {
      value: props.total,
      title: trans('Total'),
      iconClass: 'bx:badge'
    },
    {
      value: props.active,
      title: trans('Active'),
      iconClass: 'bx:badge-check'
    },
    {
      value: props.inActive,
      title: trans('Inactive'),
      iconClass: 'bx:x-circle'
    }
  ]
})
</script>

<template>
  <main class="container p-4 sm:p-6">
    <PageHeader title="Brand Logos" :buttons="buttons" />
    <div class="space-y-6">
      <Overview :items="stats" grid="3" />

      <div class="table-responsive whitespace-nowrap rounded-primary">
        <table class="table">
          <thead>
            <tr>
              <th>{{ trans('Logo') }}</th>
              <th>{{ trans('Category') }}</th>
              <th>{{ trans('Status') }}</th>
              <th>{{ trans('Created At') }}</th>
              <th>
                <p class="text-right">
                  {{ trans('Action') }}
                </p>
              </th>
            </tr>
          </thead>

          <tbody v-if="logos.total">
            <tr v-for="item in logos.data" :key="item.id">
              <td class="text-left">
                <img :src="item.preview" class="h-12" alt="" />
              </td>
              <td>
                {{ item.category?.title }}
              </td>

              <td class="text-left">
                <span class="badge" :class="item.status == 'active' ? 'badge-success' : 'badge-danger'">
                  {{ item.status == 'active' ? trans('Active') : trans('Draft') }}
                </span>
              </td>
              <td>
                {{ moment(item.created_at).format('D-MMM-Y') }}
              </td>
              <td class="">
                <div class="dropdown" data-placement="bottom-start">
                  <div class="dropdown-toggle">
                    <Icon class="text-2xl" icon="bx:dots-horizontal-rounded" />
                  </div>
                  <div class="dropdown-content w-40">
                    <ul class="dropdown-list">
                      <li class="dropdown-list-item">
                        <Link :href="route('admin.brand-logos.edit', item.id)" class="dropdown-link">
                        <Icon icon="fe:edit" />
                        <span>{{ trans('Edit') }}</span>
                        </Link>
                      </li>

                      <li class="dropdown-list-item">
                        <button as="button" class="dropdown-link"
                          @click="deleteRow(route('admin.brand-logos.destroy', item.id))">
                          <Icon icon="fe:trash" />
                          <span>{{ trans('Delete') }}</span>
                        </button>
                      </li>
                    </ul>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
          <NoDataFound v-else for-table="true" />
        </table>
        <Paginate :links="logos.links" />
      </div>
    </div>
  </main>
</template>
