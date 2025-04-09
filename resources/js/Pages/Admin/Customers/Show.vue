<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader title="Customer details" :buttons="buttons" />
    <div class="space-y-6">
      <!-- User Profile Start  -->
      <div class="grid grid-cols-1 gap-6 lg:grid-cols-4">
        <!-- Left Section Start  -->
        <section class="col-span-1 flex h-min w-full flex-col gap-6 lg:sticky lg:top-20">
          <!-- User Avatar & Status  -->
          <div class="card">
            <div class="card-body flex flex-col items-center">
              <div class="relative my-2 h-24 w-24 rounded-full">
                <img
                  :src="customer.avatar"
                  onerror="this.src = '/images/avatar1.png'"
                  alt="avatar-img"
                  class="h-full w-full rounded-full"
                />
              </div>
              <div>
                <h2 class="mb-4 text-[16px] font-medium text-slate-700 dark:text-slate-200">
                  {{ customer.name }}
                </h2>
                <span class="description">{{ trans('Status') }}: </span>
                <span
                  :class="
                    customer.status == 1
                      ? 'badge badge-success badge-sm'
                      : 'badge badge-danger badge-sm'
                  "
                  ><small>{{ customer.status == 1 ? 'Active' : 'Suspended' }}</small></span
                >
              </div>

              <div class="flex gap-3">
                <span class="description">{{ trans('Orders') }}: </span>
                <span class="heading">{{ customer.orders_count ?? 0 }}</span>
              </div>
              <div class="flex gap-3">
                <span class="description">{{ trans('Transactions') }}: </span>
                <span class="heading">{{ customer.smstransaction_count ?? 0 }}</span>
              </div>
              <div class="text-center">
                <div class="">
                  <i class="mr-2"></i>{{ trans('Join Date: ') }} {{ customer.created_at_date
                  }}<br />
                  <i class="mr-2"></i>{{ trans('Will Expire: ') }} {{ customer.will_expire }}
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- Left Section End  -->
        <!-- Right Section Start  -->
        <section class="col-span-3">
          <div class="flex h-full flex-wrap gap-4">
            <div class="flex-grow">
              <div class="card h-full">
                <div class="card-body">
                  <small class="text-muted font-bold">{{ trans('Bio') }}</small>
                  <p>{{ trans('Name : ') }} {{ customer.name }}</p>
                  <p>{{ trans('Email : ') }} {{ customer.email }}</p>
                  <p>{{ trans('Phone : ') }} {{ customer.phone }}</p>
                  <p>{{ trans('Address : ') }} {{ customer.address }}</p>
                </div>
              </div>
            </div>
            <div class="flex-grow">
              <div class="card h-full">
                <div class="card-body">
                  <small class="text-muted font-weight-bold">{{ trans('Other Info') }}</small>
                  <p>
                    {{ trans('Plan:') }} <strong>{{ customer.subscription.title }}</strong>
                  </p>
                  <p>{{ trans('Plan Expire Date:') }} {{ customer.will_expire }}</p>
                  <p>{{ trans('Total Spended:') }} {{ customer.orders_sum_amount }}</p>
                  <p>{{ trans('Total Devices:') }} {{ customer.device_count }}</p>
                  <p>{{ trans('Total Messages:') }} {{ customer.smstransaction_count }}</p>
                  <p>{{ trans('Total Contacts:') }} {{ customer.contact_count }}</p>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- Right Section End -->
      </div>

      <div>
        <h5 class="mb-2">{{ trans('Customer Orders') }}</h5>
        <div class="table-responsive whitespace-nowrap rounded-primary">
          <table class="table">
            <thead>
              <tr>
                <th class="w-[5%] uppercase">{{ trans('Order No') }}</th>
                <th class="w-[15%] uppercase">{{ trans('Plan Name') }}</th>
                <th class="w-[10%] uppercase">{{ trans('Payment Mode') }}</th>
                <th class="w-[10%] uppercase">{{ trans('Amount') }}</th>
                <th class="w-[10%] uppercase">{{ trans('Status') }}</th>
                <th class="w-[10%] uppercase">{{ trans('Created At') }}</th>
                <th class="w-[5%] !text-right uppercase">{{ trans('Actions') }}</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="order in orders.data" :key="order.id">
                <td>
                  <Link
                    :href="'/admin/order/' + order.id"
                    class="text-sm font-medium text-primary-500 transition duration-150 ease-in-out hover:underline"
                  >
                    {{ order.invoice_no }}
                  </Link>
                </td>
                <td>{{ order.plan.title }}</td>
                <td>{{ order.gateway.name }}</td>
                <td>{{ order.amount }}</td>
                <td>
                  <div class="badge badge-soft-primary capitalize">
                    {{
                      trans(
                        order.status == 2 ? 'pending' : order.status == 1 ? 'approved' : 'declined'
                      )
                    }}
                  </div>
                </td>
                <td class="text-center">
                  {{ order.created_at_diff }}
                </td>
                <td>
                  <div class="flex justify-center">
                    <div class="dropdown" data-placement="bottom-start">
                      <div class="dropdown-toggle">
                        <Icon class="text-2xl" icon="bx:dots-horizontal-rounded" />
                      </div>
                      <div class="dropdown-content w-40">
                        <ul class="dropdown-list">
                          <li class="dropdown-list-item">
                            <Link :href="'/admin/order/' + order.id" class="dropdown-link">
                              <Icon icon="fe:eye" />
                              <span>View</span>
                            </Link>
                          </li>
                          
                        </ul>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
          <Alert
            v-if="orders.data.length == 0"
            type="info"
            :text="trans('Opps you have not created any plan....')"
          />
        </div>
      </div>
    </div>
  </main>
</template>

<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'

defineOptions({ layout: AdminLayout })
const props = defineProps(['customer', 'orders', 'buttons', 'segments'])
</script>
