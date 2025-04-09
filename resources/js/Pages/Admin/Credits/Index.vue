<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import { useForm, router } from '@inertiajs/vue3'
import Paginate from '@/Components/Admin/Paginate.vue'
import moment from 'moment'
import { ref } from 'vue'
import trans from '@/Composables/transComposable'
import sharedComposable from '@/Composables/sharedComposable'
import Overview from '@/Components/Admin/OverviewGrid.vue'
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
import drawer from '@/Plugins/Admin/drawer'
import { computed, onMounted } from 'vue'
import NoDataFound from '@/Components/Admin/NoDataFound.vue'
onMounted(() => {
  drawer.init()
})
defineOptions({ layout: AdminLayout })
const { formatCurrency, textExcerpt } = sharedComposable()

const props = defineProps([
  'creditLogs',
  'per_credit_fee',
  'totalCreditLog',
  'activeCreditLog',
  'inactiveCreditLog',
  'request',
  'type'
])
const filterData = useForm({
  search: props.request.search,
  type: props.type
})
const stats = computed(() => {
  return [
    {
      value: props.totalCreditLog,
      title: trans('Total Credit Log'),
      iconClass: 'bx:badge'
    },
    {
      value: props.activeCreditLog,
      title: trans('Active Credit Log'),
      iconClass: 'bx:badge-check'
    },
    {
      value: props.inactiveCreditLog,
      title: trans('Pending Credit Log'),
      iconClass: 'bx:x-circle'
    }
  ]
})

const creditFeeForm = useForm({
  per_credit_fee: props.per_credit_fee
})

const creditFeeUpdate = () => {
  creditFeeForm.put(route('admin.update-credit-fee'))
}

const editCreditLogForm = ref({})
const openEditCreditDrawer = (creditLog) => {
  editCreditLogForm.value = { ...creditLog }
  drawer.of('#editCreditDrawer').show()
}
const updateCreditLog = () => {
  router.patch(
    route('admin.credit-logs.update', editCreditLogForm.value.id),
    editCreditLogForm.value
  )
}
</script>

<template>
  <main class="container p-4 sm:p-6">
    <PageHeader />
    <div class="space-y-6">
      <Overview :items="stats" grid="3" />
      <div class="flex items-center justify-end gap-x-2">
        <div class="dropdown" data-placement="bottom-end">
          <div class="dropdown-toggle">
            <button type="button" class="btn bg-white font-medium shadow-sm dark:bg-slate-800">
              <Icon icon="fe:filter" />
              <span>{{ trans('Filter') }}</span>
              <Icon icon="bx:chevron-down" />
            </button>
          </div>

          <div class="dropdown-content w-72 !overflow-visible">
            <form @submit.prevent="filterData.get('/admin/credit-logs')">
              <ul class="dropdown-list space-y-4 p-4">
                <li class="dropdown-list-item">
                  <h2 class="my-1 text-sm font-medium">{{ trans('Status') }}</h2>
                  <div class="mb-2">
                    <input type="text" name="search" v-model="filterData.search" class="input"
                      placeholder="Search......" />
                  </div>
                </li>
                <li class="dropdown-list-item">
                  <div class="mb-2">
                    <select class="select" name="type" v-model="filterData.type">
                      <option value="email">{{ trans('User Email') }}</option>
                      <option value="invoice_no">{{ trans('Invoice No') }}</option>
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
              <th>{{ trans('Invoice') }}</th>
              <th>{{ trans('User Name') }}</th>
              <th>{{ trans('Credits') }}</th>

              <th>
                {{ trans('Price') }}
              </th>
              <th>
                {{ trans('Status') }}
              </th>
              <th>
                {{ trans('Gateway') }}
              </th>
              <th>
                {{ trans('Comment') }}
              </th>
              <th>
                {{ trans('Attachment') }}
              </th>
              <th>{{ trans('Date') }}</th>
              <th class="flex justify-end">{{ trans('Action') }}</th>
            </tr>
          </thead>

          <tbody v-if="creditLogs.total > 0">
            <tr v-for="creditLog in creditLogs.data" :key="creditLog.id">
              <td>
                <p class="text-primary-500">{{ creditLog.invoice_no }}</p>
              </td>
              <td>
                <Link :href="route('admin.users.show', creditLog.user_id)">
                {{ textExcerpt(creditLog.user.name, 30) }}
                </Link>
              </td>
              <td>
                {{ creditLog.credits }}
              </td>
              <td>
                {{ formatCurrency(creditLog.price) }}
              </td>
              <td>
                <span :class="creditLog.status == 1 ? 'badge badge-success' : 'badge badge-warning'">
                  {{ creditLog.status == 1 ? 'Complete' : 'Pending' }}
                </span>
              </td>
              <td>
                {{ creditLog.gateway.name }}
              </td>
              <td>
                <span v-if="creditLog?.meta">
                  {{ JSON.parse(creditLog.meta).comment }}
                </span>
                <span v-else>{{ trans('None') }}</span>
              </td>
              <td>
                <template v-if="creditLog?.meta">
                  <a :href="sanitizeHtml(JSON.parse(creditLog.meta).screenshot)" target="_blank">{{
                    trans('View Attachment')
                    }}</a>
                </template>
                <span v-else>{{ trans('None') }}</span>
              </td>
              <td class="text-left">
                {{ moment(creditLog.updated_at).format('DD MMM, YYYY') }}
              </td>
              <td>
                <div class="flex justify-end">
                  <div class="dropdown" data-placement="bottom-start">
                    <div class="dropdown-toggle">
                      <Icon class="text-2xl" icon="bx:dots-horizontal-rounded" />
                    </div>
                    <div class="dropdown-content w-40">
                      <ul class="dropdown-list">
                        <li class="dropdown-list-item">
                          <button @click="openEditCreditDrawer(creditLog)" class="dropdown-link">
                            <Icon icon="fe:edit" />
                            <span>{{ trans('Edit') }}</span>
                          </button>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
          <NoDataFound v-else for-table="true" />
        </table>
      </div>
      <Paginate :links="creditLogs.links" />
    </div>
  </main>

  <div id="updateCreditFeeDrawer" class="drawer drawer-right">
    <form @submit.prevent="creditFeeUpdate">
      <div class="drawer-header">
        <h5>{{ trans('Edit Credit Fee') }}</h5>
        <button type="button"
          class="btn btn-plain-secondary dark:text-slate-300 dark:hover:bg-slate-700 dark:focus:bg-slate-700"
          data-dismiss="drawer">
          <Icon class="text-xl" icon="mdi:close" />
        </button>
      </div>
      <div class="drawer-body">
        <div class="mb-2">
          <label class="label mb-2">{{ trans('Per Credit Fee') }}</label>
          <input v-model="creditFeeForm.per_credit_fee" type="number" step="any" required class="input" />
        </div>
      </div>
      <div class="drawer-footer">
        <div class="flex justify-end gap-2">
          <button type="button" class="btn btn-secondary" data-dismiss="drawer">
            <span> {{ trans('Close') }}</span>
          </button>
          <SpinnerBtn classes="btn btn-primary" :processing="creditFeeForm.processing"
            :btn-text="trans('Save Changes')" />
        </div>
      </div>
    </form>
  </div>

  <div id="editCreditDrawer" class="drawer drawer-right">
    <form @submit.prevent="updateCreditLog">
      <div class="drawer-header">
        <h5>{{ trans('Edit Order') }}</h5>
        <button type="button"
          class="btn btn-plain-secondary dark:text-slate-300 dark:hover:bg-slate-700 dark:focus:bg-slate-700"
          data-dismiss="drawer">
          <Icon class="text-xl" icon="mdi:close" />
        </button>
      </div>
      <div class="drawer-body">
        <div class="mb-2">
          <label class="label mb-2">{{ trans('Status') }}</label>
          <select v-model="editCreditLogForm.status" class="select" name="status">
            <option value="1">
              {{ trans('Approved') }}
            </option>
            <option value="0">
              {{ trans('Pending') }}
            </option>
          </select>
        </div>
        <div class="mb-2">
          <label class="label mb-2">{{ trans('Credits') }}</label>
          <input v-model="editCreditLogForm.credits" type="number" maxlength="500" class="input" required />
        </div>
        <div class="mb-2">
          <label class="label mb-2">{{ trans('Payment ID') }}</label>
          <input :value="editCreditLogForm.payment_id" type="text" class="input read-only:cursor-not-allowed"
            readonly />
        </div>
      </div>
      <div class="drawer-footer">
        <div class="flex justify-end gap-2">
          <button type="button" class="btn btn-secondary" data-dismiss="drawer">
            <span> {{ trans('Close') }}</span>
          </button>
          <SpinnerBtn classes="btn btn-primary" :processing="editCreditLogForm.processing"
            :btn-text="trans('Save Changes')" />
        </div>
      </div>
    </form>
  </div>
</template>
