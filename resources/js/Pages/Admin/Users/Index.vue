<script setup>
import {
  computed,
  onMounted,
} from "vue"

import moment from "moment"

import NoDataFound from "@/Components/Admin/NoDataFound.vue"
import Overview from "@/Components/Admin/OverviewGrid.vue"
import Pagination from "@/Components/Admin/Paginate.vue"
import SpinnerBtn from "@/Components/Admin/SpinnerBtn.vue"
import sharedComposable from "@/Composables/sharedComposable"
import trans from "@/Composables/transComposable"
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue"
import PageHeader from "@/Layouts/Admin/PageHeader.vue"
import drawer from "@/Plugins/Admin/drawer"
import {
  router,
  useForm,
} from "@inertiajs/vue3"

defineOptions({ layout: AdminLayout })
const { deleteRow, formatCurrency, uiAvatar } = sharedComposable()

onMounted(() => {
  drawer.init()
})

const props = defineProps([
  'users',
  'plans',
  'gateways',
  'segments',
  'activeUsers',
  'inactiveUsers',
  'totalUsers'
])
const userStats = computed(() => {
  return [
    {
      value: props.totalUsers,
      title: trans('Total Users'),
      iconClass: 'bx:badge'
    },
    {
      value: props.activeUsers,
      title: trans('Active Users'),
      iconClass: 'bx:badge-check'
    },
    {
      value: props.inactiveUsers,
      title: trans('Inactive Users'),
      iconClass: 'bx:x-circle'
    }
  ]
})

const editForm = useForm({
  user_id: null,
  name: '',
  email: '',
  plan_id: '',
  gateway_id: '',
  payment_status: 1,
  password: '',
  provider_id: ''
})

const openEditUserDrawer = (user) => {
  editForm.reset()

  editForm.user_id = user.id
  editForm.name = user.name
  editForm.email = user.email
  editForm.plan_id = user.plan_id ?? ''
  editForm.password = ''
  editForm.provider_id = user.provider_id ?? ''

  if (user.plan_id) {
    editForm.gateway_id = user.gateway_id
    editForm.payment_status = user.payment_status
  }

  drawer.of('#editUserDrawer').show()
}

const updateUser = () => {
  editForm.put(route('admin.users.update', editForm.user_id), {
    onSuccess: () => {
      editForm.reset()
      drawer.of('#editUserDrawer').hide()
    }
  })
}
</script>

<template>
  <main class="container p-4 sm:p-6">
    <PageHeader title="Users" />
    <div class="space-y-6">
      <Overview :items="userStats" grid="3" />

      <div class="table-responsive whitespace-nowrap rounded-primary">
        <table class="table">
          <thead>
            <tr>
              <th>{{ trans('User') }}</th>
              <th>{{ trans('Credits') }}</th>
              <th>{{ trans('Plan') }}</th>
              <th>{{ trans('Expire At') }}</th>
              <th>{{ trans('Status') }}</th>
              <th>{{ trans('Created At') }}</th>
              <th>
                <div class="text-end">{{ trans('Action') }}</div>
              </th>
            </tr>
          </thead>

          <tbody v-if="users.total">
            <tr v-for="user in users.data" :key="user.id">
              <td class="text-left">
                <div class="flex gap-2">
                  <img class="mr-1 inline w-12 rounded-full" :src="uiAvatar(user.name, user.avatar)" alt="preview" />
                  <a :href="route('admin.users.show', user.id)">
                    <p class="font-bold">
                      {{ user.name }}
                    </p>
                    <p>
                      {{ user.email }}
                    </p>
                  </a>
                </div>
              </td>
              <td>{{ user.credits }}</td>
              <td>
                <span v-if="user.plan" class="badge badge-primary"> {{ user.plan.title }}</span>
                <template v-else> N/A </template>
              </td>
              <td>
                {{
                  user.will_expire ? moment(user.will_expire).format('D MMM, YYYY h:mm A') : 'N/A'
                }}
              </td>

              <td class="text-left">
                <span class="badge" :class="user.status == 1 ? 'badge-success' : 'badge-danger'">
                  {{ user.status == 1 ? trans('Active') : trans('Inactive') }}
                </span>
              </td>

              <td>
                {{ moment(user.created_at).format('D MMM, YYYY h:mm A') }}
              </td>
              <td class="">
                <div class="dropdown" data-placement="bottom-start">
                  <div class="dropdown-toggle">
                    <Icon class="text-2xl" icon="bx:dots-horizontal-rounded" />
                  </div>
                  <div class="dropdown-content w-40">
                    <ul class="dropdown-list">
                      <li class="dropdown-list-item">
                        <Link :href="route('admin.users.show', user)" class="dropdown-link">
                        <Icon icon="fe:eye" />
                        <span>{{ trans('View') }}</span>
                        </Link>
                      </li>

                      <li class="dropdown-list-item">
                        <button @click="openEditUserDrawer(user)" class="dropdown-link">
                          <Icon icon="fe:edit" />
                          <span>{{ trans('Edit') }}</span>
                        </button>
                      </li>

                      <li class="dropdown-list-item">
                        <button as="button" class="dropdown-link"
                          @click="deleteRow(route('admin.users.destroy', user.id))">
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

        <Pagination :links="users.links" />
      </div>
    </div>
  </main>

  <div id="editUserDrawer" class="drawer drawer-right">
    <form @submit.prevent="updateUser()">
      <div class="drawer-header">
        <h5>{{ trans('Edit User Information') }}</h5>
        <button type="button"
          class="btn btn-plain-secondary dark:text-slate-300 dark:hover:bg-slate-700 dark:focus:bg-slate-700"
          data-dismiss="drawer">
          <Icon class="text-xl" icon="mdi:close" />
        </button>
      </div>
      <div class="drawer-body">
        <div class="mb-2">
          <label>Name</label>
          <input type="text" class="input" disabled v-model="editForm.name" />
        </div>
        <div class="mb-2">
          <label>
            Email
            <span class="text-xs" v-if="editForm.provider_id">
              ( {{ trans('Social Login') }})
            </span></label>
          <input type="email" class="input" :disabled="editForm.provider_id ? true : false" v-model="editForm.email" />
        </div>
        <div class="mb-2">
          <label>
            Password
            <span class="text-xs" v-if="editForm.provider_id">
              ({{ trans('Social Login') }})
            </span></label>
          <input type="password" class="input" :disabled="editForm.provider_id ? true : false"
            v-model="editForm.password" />
        </div>

        <div class="mb-2">
          <label class="label mb-2">{{ trans('Plan') }}</label>
          <select v-model="editForm.plan_id" class="select">
            <option value="">Select Plan</option>
            <option v-for="plan in plans" :value="plan.id" :key="plan.id">
              {{ plan.title }} {{ formatCurrency(plan.price) }}
            </option>
          </select>
        </div>

        <div class="mb-2">
          <label class="label mb-2">{{ trans('Payment Gateway') }}</label>
          <select v-model="editForm.gateway_id" class="select">
            <option value="">Select Payment Gateway</option>
            <option v-for="gateway in gateways" :value="gateway.id" :key="gateway.id">
              {{ gateway.name }}
            </option>
          </select>
        </div>

        <div class="mb-2" v-if="editForm.gateway_id">
          <label class="label mb-2">{{ trans('Payment Status') }}</label>
          <select v-model="editForm.payment_status" class="select">
            <option v-for="paid in [1, 2, 0]" :value="paid" :key="paid">
              {{ paid == 1 ? 'Paid' : paid == 2 ? 'Pending' : 'Rejected' }}
            </option>
          </select>
        </div>
      </div>
      <div class="drawer-footer">
        <div class="flex gap-2">
          <button type="button" class="btn btn-secondary w-full" data-dismiss="drawer">
            <span> {{ trans('Close') }}</span>
          </button>
          <SpinnerBtn classes="btn btn-primary w-full" :processing="editForm.processing"
            :btn-text="trans('Save Changes')" />
        </div>
      </div>
    </form>
  </div>
</template>
