<script setup>
import {
  computed,
  ref,
} from "vue";

import moment from "moment";

import NoDataFound from "@/Components/Admin/NoDataFound.vue";
import Paginate from "@/Components/Admin/Paginate.vue";
import sharedComposable from "@/Composables/sharedComposable";
import PageHeader from "@/Layouts/Admin/PageHeader.vue";
import UserLayout from "@/Layouts/User/UserLayout.vue";

defineOptions({ layout: UserLayout })

const props = defineProps(['user', 'plans', 'orders', 'segments', 'planByDays'])
const { formatCurrency } = sharedComposable()

const isNearExpiry = computed(() => {
  if (props.user.will_expire) {
    const userWillExpireDate = moment(props.user.will_expire)
    const daysDifference = userWillExpireDate.diff(moment(), 'days')
    return daysDifference < 7
  }
  return false
})
const hasExpired = computed(() => {
  if (props.user.will_expire) {
    const userWillExpireDate = moment(props.user.will_expire)
    return userWillExpireDate.isBefore(moment())
  }
  return false
})
const activeTab = ref('monthly')

const filteredPlans = computed(() => {
  return props.plans.filter((p) => {
    if (activeTab.value === 'monthly') return p.days === 30
    if (activeTab.value === 'yearly') return p.days === 365
    return p.days > 365
  })
})
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <div class="flex items-center justify-between">
      <PageHeader title="Subscription" :buttons="[]" />
      <div class="mb-4 flex items-center justify-between">
        <div class="card max-w-max p-1">
          <button
            v-for="plan in planByDays"
            :key="plan.days"
            class="btn w-full px-14 py-2 md:w-auto"
            :class="{ 'btn-primary': activeTab === plan.duration }"
            @click="activeTab = plan.duration"
          >
            <span class="capitalize"> {{ plan.duration }}</span>
          </button>
        </div>
      </div>
    </div>

    <div
      class="alert alert-danger text-base"
      v-if="!user.will_expire || !user.plan || !user.plan_id"
    >
      <p>{{ trans("You haven't purchased any subscription plans yet.") }}</p>
    </div>
    <div class="alert alert-danger text-base" v-if="hasExpired">
      <p>{{ trans('Your subscription has already expired') }}</p>
    </div>
    <div class="alert alert-warning text-base" v-else-if="isNearExpiry">
      <p>
        {{ trans('Your current subscription plan is about to expire in less than 7 days') }}
      </p>
    </div>

    <div
      class="mt-3 grid grid-cols-1 rounded-xl border border-primary-400 lg:grid-cols-12"
      v-if="user.will_expire != null"
    >
      <div class="col-span-1 flex flex-col justify-center gap-2 p-4 lg:col-span-7 lg:p-8">
        <h4>{{ trans('Current Plan') }} ({{ user.plan.title }})</h4>
        <p class="text-gray-400">
          {{
            trans(`Unlimited access to our legal document library and online rental application tool,
          billed monthly.`)
          }}
        </p>
      </div>
      <div class="col-span-1 flex gap-3 border-l border-primary-400 p-4 lg:col-span-5 lg:p-8">
        <p class="mt-3 whitespace-nowrap text-3xl text-primary-500 lg:text-5xl">
          {{ formatCurrency(user.plan.price) }}
        </p>
        <div class="px-2">
          <p class="text-primary-500">
            {{ user.plan.days === 30 ? 'Monthly' : user.plan.days === 365 ? 'Yearly' : 'Lifetime' }}

            {{ trans('Plan') }}
          </p>
          <span>
            {{ trans('Your subscription will expire') }}

            <span>
              {{ moment(user.will_expire).format('MMM DD, YYYY') }}
            </span>
          </span>
        </div>
      </div>
    </div>

    <div class="my-8 grid grid-cols-1 gap-14 lg:grid-cols-3">
      <template v-for="plan in filteredPlans" :key="plan.id">
        <div
          class="flex flex-col justify-between overflow-hidden rounded-xl px-12 py-8 shadow-md"
          :class="{
            'card relative border-2 border-primary-500 ': plan.is_recommended,
            'border border-gray-200 dark:border-gray-700': plan.is_recommended === 0
          }"
        >
          <div
            class="absolute -left-1 top-9 max-w-max rounded-r-xl bg-primary-600 px-4 capitalize text-primary-50"
            v-if="plan.is_recommended"
          >
            {{ trans('popular') }}
          </div>
          <div class="text-center text-2xl text-gray-400">{{ plan.title }}</div>
          <div class="my-8 flex justify-center gap-2">
            <span class="text-3xl">{{ formatCurrency(plan.price)[0] }}</span>
            <span class="text-4xl">{{ plan.price }}</span>
            <span>
              {{ plan.days === 30 ? 'Monthly' : plan.days === 365 ? 'Yearly' : 'Lifetime' }}
            </span>
          </div>
          <ul class="flex flex-col gap-2">
            <template v-for="data in plan.data" :key="data.value">
              <li class="text-capitalize flex items-center">
                <span class="ml-2 text-sm">
                  {{ data.overview }}
                </span>
              </li>
            </template>
            <template v-for="data in plan.extra_data" :key="data.value">
              <li class="text-capitalize flex items-center">
                <span class="ml-2 text-sm">
                  {{ data.value }}
                </span>
              </li>
            </template>
          </ul>
          <a
            :href="route('user.subscription.payment', plan.id)"
            class="btn btn-soft-primary mt-6 w-full"
          >
            {{ trans('Choose Plan') }}
          </a>
        </div>
      </template>
    </div>
    <NoDataFound v-if="filteredPlans?.length < 1" />

    <h5 class="mb-2">{{ trans('Subscription History') }}</h5>

    <div v-if="orders.total" class="table-responsive whitespace-nowrap rounded-primary">
      <table class="ert-table table">
        <thead>
          <tr>
            <th>{{ trans('Invoice No') }}</th>
            <th>{{ trans('Plan') }}</th>
            <th>{{ trans('Amount') }}</th>
            <th>{{ trans('Tax') }}</th>
            <th>{{ trans('Status') }}</th>
            <th>{{ trans('Expire Date') }}</th>
            <th class="text-center">{{ trans('Created Date') }}</th>
          </tr>
        </thead>
        <tbody class="border-0">
          <tr v-for="order in orders.data" :key="order.id">
            <td>{{ order.invoice_no }}</td>

            <td>{{ order.plan?.title }}</td>
            <td>{{ formatCurrency(order.amount) }}</td>
            <td>{{ formatCurrency(order.tax) }}</td>
            <td>{{ order.status }}</td>
            <td>{{ moment(order.will_expire).format('DD MMM, YYYY') }}</td>
            <td class="text-center">
              {{ moment(order.created_at).format('DD MMM, YYYY') }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <NoDataFound v-else />
    <Paginate :links="orders.links" />
  </main>
</template>
