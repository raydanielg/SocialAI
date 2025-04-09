<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader :title="trans('Payment Gateways')" :buttons="buttons" />
    <div class="space-y-6">
      <Overview :items="gatewayStats" grid="3" />

      <div class="table-responsive whitespace-nowrap rounded-primary">
        <table class="table">
          <thead>
            <tr>
              <th scope="col" class="w-[30%]">{{ trans("Name") }}</th>

              <th scope="col" class="w-[10%]">{{ trans("Charge") }}</th>
              <th scope="col" class="w-[10%]">{{ trans("Currency") }}</th>
              <th scope="col" class="w-[10%]">{{ trans("Gateway Status") }}</th>
              <th scope="col" class="w-[20%]">{{ trans("Payment Mode") }}</th>
              <th scope="col" class="w-[20%]">
                <div class="text-right">
                  {{ trans("Action") }}
                </div>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="gateway in gateways" :key="gateways.id">
              <th>
                <div class="flex gap-2">
                  <div class="avatar avatar-squire">
                    <img class="avatar-img" :src="gateway.logo" alt="" />
                  </div>

                  <div>
                    <Link v-if="gateway.logo != null" :href="'/admin/gateways/' + gateway.id + '/edit'">
                    <h6 class="text-sm font-medium whitespace-nowrap text-slate-700 dark:text-slate-100">
                      {{ gateway.name }}
                    </h6>
                    </Link>
                    <p class="text-xs truncate text-slate-500 dark:text-slate-400">
                      {{ trans("Limit : ") }} {{ number_format(gateway.min_amount, 2) }} -
                      {{ number_format(gateway.max_amount, 2) }}
                    </p>
                  </div>
                </div>
              </th>

              <td class="text-right">
                {{ gateway.charge }}
                {{ gateway.currency != null ? gateway.currency : "" }}
              </td>
              <td class="text-center">{{ gateway.currency }}</td>
              <td class="text-center">
                <div class="badge" :class="gateway.status == 1 ? 'badge-soft-success' : 'badge-soft-danger'
                  ">
                  <span class="status">{{
                    gateway.status == 1 ? "Active" : "Disabled"
                  }}</span>
                </div>
              </td>

              <td class="text-right">
                <span class="badge" :class="gateway.test_mode == 1 ? 'badge-soft-primary' : 'badge-soft-success'
                  ">
                  <span class="status">{{
                    gateway.test_mode == 1 ? "Sandbox" : "Production"
                  }}</span>
                </span>
              </td>
              <td>
                <div class="text-right">
                  <Link class="btn btn-sm btn-primary" :href="'/admin/gateways/' + gateway.id + '/edit'">
                  <Icon icon="bx:edit" /> {{ trans("Edit") }}
                  </Link>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </main>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue"
export default {
  layout: AdminLayout,
  components: { Link },
}
</script>

<script setup>
import PageHeader from "@/Layouts/Admin/PageHeader.vue"
import { Head, Link } from "@inertiajs/vue3"
import NoDataFound from "@/Components/Admin/NoDataFound.vue"
import Overview from "@/Components/Admin/OverviewGrid.vue"
import trans from "@/Composables/transComposable"
const props = defineProps([
  "gateways",
  "active_gateway",
  "totalGateways",
  "inactive_gateway",

  "buttons",
])

const gatewayStats = [
  {
    value: props.totalGateways,
    title: trans("Total Gateways"),
    iconClass: "bx:bar-chart",
  },
  {
    value: props.active_gateway,
    title: trans("Active Gateways"),
    iconClass: "bx:check",
  },
  {
    value: props.inactive_gateway,
    title: trans("Inactive Gateways"),
    iconClass: "bx:x-circle",
  },
]

function number_format(number, decimals, dec_point, thousands_point) {
  if (number == null || !isFinite(number)) {
    throw new TypeError("number is not valid")
  }

  if (!decimals) {
    var len = number.toString().split(".").length
    decimals = len > 1 ? len : 0
  }

  if (!dec_point) {
    dec_point = "."
  }

  if (!thousands_point) {
    thousands_point = ","
  }

  number = parseFloat(number).toFixed(decimals)

  number = number.replace(".", dec_point)

  var splitNum = number.split(dec_point)
  splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_point)
  number = splitNum.join(dec_point)

  return number
}
</script>
