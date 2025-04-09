<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader :title="trans('Customers')" :buttons="buttons" />
    <div class="space-y-6">
      <Overview :items="customerStats" />

      <Filter :request="request" />

      <!-- Blog Table Starts -->
      <div class="table-responsive whitespace-nowrap rounded-primary">
        <table class="table">
          <thead>
            <tr>
              <th>{{ trans('Customer') }}</th>
              <th>{{ trans('Plan') }}</th>
              <th>{{ trans('Orders') }}</th>
              <th>{{ trans('Expire Date') }}</th>
              <th>{{ trans('Status') }}</th>
              <th class="text-left">{{ trans('Created At') }}</th>
              <th class="text-left">{{ trans('Action') }}</th>
            </tr>
          </thead>
          <tbody class="list" v-if="customers.length != 0">
            <tr v-for="customer in customers.data" :key="customer.id">
              <td>
                <div class="flex items-center gap-3">
                  <div class="avatar avatar-circle">
                    <img class="avatar-img" :src="customer.avatar" onerror="this.src = '/images/avatar1.png'" />
                  </div>
                  <div>
                    <h6 class="whitespace-nowrap text-sm font-medium text-slate-700 dark:text-slate-100">
                      <Link :href="route('admin.customer.show', customer)" class="text-dark">
                      {{ customer.name }}
                      </Link>
                    </h6>
                    <p class="truncate text-xs text-slate-500 dark:text-slate-400">
                      {{ customer.email }}
                    </p>
                  </div>
                </div>
              </td>

              <td>
                {{ customer.subscription?.title ?? 'NA' }}
              </td>

              <td class="text-center">
                {{ customer.orders_count }}
              </td>
              <td class="text-center">
                {{ customer.will_expire }}
              </td>
              <td>
                <span :class="customer.status == 1 ? 'badge badge-success' : 'badge badge-danger'">
                  {{ customer.status == 1 ? 'Active' : 'Suspended' }}
                </span>
              </td>

              <td class="text-center">
                {{ customer.created_at_date }}
              </td>
              <td>
                <div class="dropdown" data-placement="bottom-start">
                  <div class="dropdown-toggle">
                    <Icon class="text-2xl" icon="bx:dots-horizontal-rounded" />
                  </div>
                  <div class="dropdown-content w-40">
                    <ul class="dropdown-list">
                      <li class="dropdown-list-item">
                        <Link :href="route('admin.customer.show', customer.id)" class="dropdown-link">
                        <Icon icon="fe:external-link" />
                        <span>{{ trans('View') }}</span>
                        </Link>
                      </li>

                      <li class="dropdown-list-item">
                        <Link :href="`/admin/customer/${customer.id}/edit`" class="dropdown-link">
                        <Icon icon="fe:edit" />
                        <span>{{ trans('Edit') }}</span>
                        </Link>
                      </li>

                      <li class="dropdown-list-item">
                        <Link as="button" href="#" @click="deleteRow('/admin/customer/' + customer.id)"
                          class="dropdown-link">
                        <Icon icon="fe:trash" />
                        {{ trans('Delete') }}
                        </Link>
                      </li>
                    </ul>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>

        <Alert v-if="customers.length == 0" type="info" :text="trans('Opps you have not created any plan....')" />

        <Paginate v-if="customers.length != 0" :links="customers.links" :currentPage="customers.current_page"
          :from="customers.from" :lastPage="customers.last_page" :lastPageUrl="customers.last_page_url"
          :nextpageurl="customers.next_page_url" :perPage="customers.per_page" :prevPageUrl="customers.prev_page_url"
          :to="customers.to" :total="customers.total" />
      </div>
      <!-- Blog Table Ends -->
    </div>
  </main>
</template>

<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import Paginate from '@/Components/Admin/Paginate.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import trans from '@/Composables/transComposable'
import Alert from '@/Components/Admin/NoDataFound.vue'
import Filter from '@/Components/Admin/Filter.vue'
import Overview from '@/Components/Admin/OverviewGrid.vue'
import sharedComposable from '@/Composables/sharedComposable'

defineOptions({ layout: AdminLayout })
const { deleteRow } = sharedComposable()
const props = defineProps([
  'segments',
  'buttons',
  'customers',
  'request',
  'type',
  'totalCustomers',
  'totalActiveCustomers',
  'totalSuspendedCustomers',
  'totalExpiredCustomers'
])

const customerStats = [
  {
    value: props.totalCustomers,
    title: trans('Total Customers'),
    iconClass: 'bx:box'
  },
  {
    value: props.totalActiveCustomers,
    title: trans('Active Customers'),
    iconClass: 'bx:dollar-circle'
  },
  {
    value: props.totalExpiredCustomers,
    title: trans('Expired Customers'),
    iconClass: 'ti ti-thumb-up'
  },
  {
    value: props.totalSuspendedCustomers,
    title: trans('Suspended Customers'),
    iconClass: 'ti ti-message-2-cog'
  }
]
</script>
