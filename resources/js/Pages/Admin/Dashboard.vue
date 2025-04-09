<script setup>
import sharedComposable from '@/Composables/sharedComposable'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import Alert from '@/Components/Admin/NoDataFound.vue'
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import VueApexCharts from 'vue3-apexcharts'
import { router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import moment from 'moment'
defineOptions({ layout: AdminLayout })

const props = defineProps([
  'totalOrders',
  'totalSales',
  'mostOrderedPlans',
  'recentPosts',
  'popularPlans',
  'recentOrders',
  'salesOverview',
  'totalBrands',
  'totalPosts',
  'recentOrders',
  'totalCustomers',
  'totalStorage',
  'socialAccounts',
  'totalCredits',
  'request',
  'recentCreditLogs'
])
const { formatCurrency, textExcerpt, pickBy } = sharedComposable()

const primaryOverview = computed(() => {
  return [
    {
      title: 'Total Orders',
      value: props.totalOrders,
      url: route('admin.order.index'),
      icon: 'bx bx-cart',
      classes: 'bg-primary-500 text-primary-500'
    },
    {
      title: 'Total Sales',
      value: props.totalSales,
      url: route('admin.order.index'),
      icon: 'bx bx-dollar-circle',
      classes: 'text-success-500 bg-success-500'
    },
    {
      title: 'Total Brands',
      value: props.totalBrands,
      url: '#',
      icon: 'bx bx-box',
      classes: 'bg-primary-500 text-primary-500'
    },
    {
      title: 'Total Post',
      value: props.totalPosts,
      url: '#',
      icon: 'bx bx-receipt',
      classes: 'text-success-500 bg-success-500'
    },
    {
      title: 'Storage Used',
      value: props?.totalStorage.toFixed(2) + ' MB',
      url: '#',
      icon: 'bx bx-memory-card',
      classes: 'text-warning-500 bg-warning-500'
    },
    {
      title: 'Social Accounts',
      value: props.socialAccounts,
      url: '#',
      icon: 'bx bx-group',
      classes: 'text-info-500 bg-info-500'
    },
    {
      title: 'Total Customers',
      value: props.totalCustomers,
      url: '/admin/users',
      icon: 'bx bx-user',
      classes: 'text-lime-500 bg-lime-500'
    },
    {
      title: 'Recent Orders',
      value: props.recentOrders,
      url: '/admin/orders',
      icon: 'bx bx-cart-download',
      classes: 'text-sky-500 bg-sky-500'
    }
  ]
})

const filterForm = ref({
  plan: props.request.plan || '',
  sales: props.request.sales || ''
})

const filter = () => {
  router.get(route('admin.dashboard'), pickBy(filterForm.value), {
    preserveState: true,
    replace: true
  })
}
const salesChart = computed(() => {
  return {
    series: [
      {
        name: 'Sales',
        data: props.salesOverview.map((item) => item.sales)
      }
    ],
    chartOptions: {
      colors: ['#69ae84', '#69ae84', '#69ae84'],
      chart: {
        height: 350,
        type: 'area',
        toolbar: {
          show: false
        }
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'smooth'
      },
      xaxis: {
        type: 'string',
        categories: props.salesOverview.map((item) => item.date)
      }
    }
  }
})
const mostSorts = [
  { label: 'Today', value: 'today' },
  { label: 'Month', value: 'month' },
  { label: 'All', value: '' }
]
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader :title="trans('Dashboard')" />

    <div class="space-y-6">
      <!-- Overview Section Start -->
      <section class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
        <!-- Product Views  -->
        <template v-for="(item, index) in primaryOverview" :key="index">
          <Link :href="item.url">
          <div class="card">
            <div class="card-body flex items-center gap-4">
              <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-opacity-20"
                :class="item.classes">
                <i class="text-3xl" :class="item.icon"></i>
              </div>
              <div class="flex flex-1 flex-col gap-1">
                <p class="text-sm tracking-wide text-slate-500">{{ item.title }}</p>
                <div class="flex flex-wrap items-baseline justify-between gap-2">
                  <h4>{{ item.value }}</h4>
                </div>
              </div>
            </div>
          </div>
          </Link>
        </template>
      </section>
      <!-- Overview Section End -->

      <!-- Sales Chart  -->
      <section class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
        <div class="card order-2 col-span-1 md:col-span-2 xl:order-3">
          <div class="card-body flex h-full flex-col justify-between gap-4">
            <div class="flex flex-wrap justify-between gap-2">
              <h6>{{ trans('Overview Of Sales') }}</h6>
              <select v-model="filterForm.sales" @change="filter" class="select select-xl w-full capitalize md:w-40">
                <option value="" selected>{{ trans('Filter By') }}</option>
                <option :value="item" v-for="item in ['day', 'week', 'month', 'year']" :key="item"
                  :selected="filterForm.sales === item">
                  {{ item }}
                </option>
              </select>
            </div>
            <div class="min-h-min">
              <!-- Sales Location Chart  -->
              <VueApexCharts type="area" height="350" :options="salesChart.chartOptions" :series="salesChart.series" />
            </div>
          </div>
        </div>

        <!-- Most Ordered Plan  -->
        <div class="order-4 col-span-1 space-y-6">
          <div class="card">
            <div class="card-body">
              <div class="flex flex-wrap items-center justify-between">
                <h6>{{ trans('Most Ordered Plan') }}</h6>
                <div class="flex items-center gap-2">
                  <template v-for="(sort, i) in mostSorts" :key="sort.label">
                    <button type="button" @click="() => {
                        filterForm.plan = sort.value
                        filter()
                      }
                      ">
                      <span class="text-xs capitalize" :class="{
                        'font-medium text-primary-500': filterForm.plan == sort.value
                      }">
                        {{ trans(sort.label) }}
                      </span>
                    </button>
                    <span v-if="i < 2" class="text-sm text-slate-200 dark:text-slate-600">|</span>
                  </template>
                </div>
              </div>
              <template v-if="mostOrderedPlans.length">
                <div v-for="mostOrderedPlan in mostOrderedPlans"
                  class="mt-4 flex items-center gap-4 rounded-primary bg-slate-50 p-4 dark:bg-slate-900">
                  <Link :href="route('admin.plan.index')">
                  <div class="flex flex-1 flex-col gap-1">
                    <h3 class="text-sm font-semibold">{{ mostOrderedPlan.title }}</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                      {{ trans('Price') }}: {{ formatCurrency(mostOrderedPlan.price) }},
                      {{ mostOrderedPlan.days == 30 ? 'Monthly' : 'Yearly' }},
                      {{ trans('Total Order') }}:
                      {{ mostOrderedPlan.orders_count }}
                    </p>
                  </div>
                  </Link>
                </div>
              </template>
              <Alert v-else text="Nothing found..." />
            </div>
          </div>
        </div>
      </section>
      <!-- Store Analytics, Active Users, Sales By Location, Top & Most Viewed Product Section End  -->

      <!-- Top Sellers Section start  -->
      <section class="grid grid-cols-12 place-items-start gap-6">
        <div class="card col-span-8">
          <div class="card-body space-y-2">
            <h6>{{ trans('Popular Plans') }}</h6>
            <!-- Seller Table  -->
            <div v-if="popularPlans?.length > 0" class="table-responsive whitespace-nowrap rounded-primary">
              <table class="table min-w-[43rem]">
                <thead>
                  <tr>
                    <th>{{ trans('Plan') }}</th>
                    <th>{{ trans('Active Users') }}</th>
                    <th>{{ trans('Sales') }}</th>
                    <th>{{ trans('Total Amount') }}</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="plan in popularPlans" :key="plan.id">
                    <td class="whitespace-nowrap">
                      <Link :href="route('admin.plan.index')">
                      {{ plan.name }}
                      </Link>
                    </td>
                    <td class="whitespace-nowrap">{{ plan.activeuser }}</td>
                    <td class="whitespace-nowrap">
                      <p>{{ plan.orders_count }}</p>
                    </td>
                    <td>{{ plan.total_amount }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <Alert v-else text="Nothing found..." />
          </div>
        </div>
        <div class="card col-span-4">
          <div class="card-body flex h-full flex-col">
            <!-- Header  -->
            <h6>{{ trans('Recent Orders') }}</h6>

            <div v-if="recentOrders?.length > 0" class="mt-auto divide-y dark:divide-slate-600">
              <template v-for="order in recentOrders" :key="order.id">
                <Link :href="route('admin.order.index')">
                <div class="flex items-center gap-4 py-2">
                  <div class="flex h-12 w-12 min-w-12 items-center justify-center">
                    <img :src="order.avatar" v-lazy="order.avatar == null
                        ? `https://ui-avatars.com/api/?name=${order?.name}`
                        : `${order.avatar}`
                      " class="rounded-primary" alt="avatar" />
                  </div>
                  <div class="flex w-full items-center justify-between">
                    <div>
                      <h6 class="text-sm font-medium text-slate-600 dark:text-slate-300">
                        {{ order.invoice }}
                      </h6>
                      <p class="text-sm text-slate-400">{{ order.plan }}</p>
                      <p class="text-xs text-slate-200">By {{ order.name }}</p>
                    </div>

                    <div>
                      <h6 class="text-sm font-medium text-slate-600 dark:text-slate-300">
                        {{ order.amount }}
                      </h6>
                      <p class="text-sm text-slate-400">{{ order.created_at }}</p>
                    </div>
                  </div>
                </div>
                </Link>
              </template>
            </div>
            <Alert v-else text="Nothing found..." />
          </div>
        </div>
      </section>
      <!-- Top Sellers Section End  -->

      <!-- Recent Posts -->
      <section class="grid grid-cols-1 place-items-start gap-6 lg:grid-cols-12">
        <div class="card lg:col-span-5">
          <div class="card-body">
            <!-- Header  -->
            <h6>{{ trans('Recent Posts') }}</h6>
            <div class="table-responsive whitespace-nowrap rounded-primary">
              <table class="table">
                <thead>
                  <tr>
                    <th>{{ trans('Brand') }}</th>
                    <th>{{ trans('User Name') }}</th>
                    <th>{{ trans('Title') }}</th>
                    <th>{{ trans('Status') }}</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in recentPosts" :key="index">
                    <td>
                      {{ item.brand?.name }}
                    </td>
                    <td class="whitespace-nowrap">
                      {{ item.user?.name }}
                    </td>

                    <td>{{ item.note || 'None' }}</td>
                    <td>
                      <span class="badge badge-dark capitalize">
                        {{ item.status }}
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- jobs  -->
        <div class="card lg:col-span-7">
          <div class="card-body">
            <h6>{{ trans('Recent Credits') }}</h6>

            <!-- jobs Table  -->
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
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="creditLog in recentCreditLogs" :key="creditLog.id">
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
                      <span :class="creditLog.status == 1 ? 'badge badge-success' : 'badge badge-warning'
                        ">
                        {{ creditLog.status == 1 ? 'Complete' : 'Pending' }}
                      </span>
                    </td>
                    <td>
                      {{ creditLog.gateway.name }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </section>
    </div>
  </main>
</template>
