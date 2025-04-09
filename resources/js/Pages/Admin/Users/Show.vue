<script setup>
import NoDataFound from "@/Components/Admin/NoDataFound.vue"
import Overview from "@/Components/Admin/OverviewGrid.vue"
import Pagination from "@/Components/Admin/Paginate.vue"
import sharedComposable from "@/Composables/sharedComposable"
import trans from "@/Composables/transComposable"
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue"
import PageHeader from "@/Layouts/Admin/PageHeader.vue"

const { deleteRow, formatCurrency, textExcerpt, uiAvatar } = sharedComposable()

defineOptions({ layout: AdminLayout })
const props = defineProps([
  'platforms',
  'brandPosts',
  'assets',
  'showUser',
  'orders',
  'brands',
  'totalOrders',
  'totalPendingOrders',
  'totalCompleteOrders',
  'totalDeclinedOrders'
])

const userStats = [
  {
    value: props.totalOrders,
    title: trans('Total Orders'),
    iconClass: 'bx:badge-check'
  },
  {
    value: props.totalPendingOrders,
    title: trans('Pending Orders'),
    iconClass: 'bx:badge'
  },
  {
    value: props.totalCompleteOrders,
    title: trans('Completed Orders'),
    iconClass: 'bx:check'
  },
  {
    value: props.totalDeclinedOrders,
    title: trans('Declined Orders'),
    iconClass: 'bx:x-circle'
  }
]
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader title="User details" />
    <div class="space-y-6">
      <Overview :items="userStats" />
      <div class="grid grid-cols-1 gap-6 lg:grid-cols-4">
        <!-- Left Section Start  -->
        <section class="col-span-1 flex h-min w-full flex-col gap-6 lg:sticky lg:top-20">
          <!-- User Avatar & Status  -->
          <div class="card">
            <div class="card-body flex flex-col items-center">
              <div class="relative my-2 h-24 w-24 rounded-full">
                <img :src="uiAvatar(showUser.name, showUser.avatar)" alt="avatar-img"
                  class="h-full w-full rounded-full" />
              </div>
              <div>
                <h2 class="mb-4 text-[16px] font-medium text-slate-700 dark:text-slate-200">
                  {{ showUser.name }}
                </h2>
                <span class="description">{{ trans('Status') }}: </span>
                <span :class="showUser.status == 1
                  ? 'badge badge-success badge-sm'
                  : 'badge badge-danger badge-sm'
                  "><small>{{ showUser.status == 1 ? 'Active' : 'Suspended' }}</small></span>
              </div>

              <div class="text-center">
                <div class="">
                  <i class="mr-2"></i>{{ trans('Join Date: ') }}
                  {{ showUser.created_at_date }}
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
                <div class="card-body space-y-2">
                  <small class="text-muted font-bold">{{ trans('Bio') }}</small>
                  <p>{{ trans('Name : ') }} {{ showUser.name }}</p>
                  <p>{{ trans('Email : ') }} {{ showUser.email }}</p>
                  <p>{{ trans('Phone : ') }} {{ showUser?.phone || 'None' }}</p>
                  <p>{{ trans('Address : ') }} {{ showUser?.address || 'None' }}</p>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- Right Section End -->
      </div>

      <div class="table-responsive whitespace-nowrap rounded-primary">
        <h5 class="p-2">{{ trans('Orders') }}</h5>
        <table class="table">
          <thead>
            <tr>
              <th>{{ trans('Order No') }}</th>
              <th>{{ trans('Plan Name') }}</th>
              <th>{{ trans('Payment Mode') }}</th>
              <th>{{ trans('Amount') }}</th>
              <th>{{ trans('Status') }}</th>
              <th>{{ trans('Created At') }}</th>
              <th class="!text-right">{{ trans('Actions') }}</th>
            </tr>
          </thead>
          <tbody v-if="orders.total">
            <tr v-for="order in orders.data" :key="order.id">
              <td>
                <Link :href="'/admin/order/' + order.id"
                  class="text-sm font-medium text-primary-500 transition duration-150 ease-in-out hover:underline">
                {{ order.invoice_no }}
                </Link>
              </td>
              <td>{{ order.plan.title }}</td>
              <td>{{ order.gateway.name }}</td>
              <td>{{ formatCurrency(order.amount) }}</td>
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
                <div class="flex justify-end">
                  <div class="dropdown" data-placement="bottom-start">
                    <div class="dropdown-toggle">
                      <Icon class="text-2xl" icon="bx:dots-horizontal-rounded" />
                    </div>
                    <div class="dropdown-content w-40">
                      <ul class="dropdown-list">
                        <li class="dropdown-list-item">
                          <Link :href="'/admin/order/' + order.id" class="dropdown-link">
                          <Icon icon="fe:eye" />
                          <span>{{ trans('View') }}</span>
                          </Link>
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
        <Pagination :links="orders.links" />
      </div>

      <div class="table-responsive whitespace-nowrap rounded-primary">
        <h5 class="p-2">{{ trans('Platforms') }}</h5>
        <table class="table">
          <thead>
            <tr>
              <th>{{ trans('Platform') }}</th>
              <th>{{ trans('Account') }}</th>
              <th>{{ trans('Connected As') }}</th>
              <th>{{ trans('Action') }}</th>
            </tr>
          </thead>

          <tbody v-if="platforms.total">
            <tr v-for="platform in platforms.data" :key="platform">
              <td>
                <div class="flex items-center gap-2 text-left">
                  <i class="bx text-2xl" :class="`bxl-${platform.platform}`"></i>
                  <span class="text-xs capitalize">{{ platform.platform }}</span>
                </div>
              </td>

              <td>
                <div class="flex items-center gap-2">
                  <img :src="platform.picture ?? '/assets/images/no-image.jpg'"
                    @error="(e) => (e.target.src = '/assets/images/no-image.jpg')" class="h-10" />
                  <span>
                    {{ platform.name }} <br />
                    <small v-if="platform.username">({{ platform.username }})</small>
                  </span>
                </div>
              </td>
              <td>{{ platform.type }}</td>
              <td>
                <button @click="disconnectPlatform(platform)" type="submit" class="btn btn-danger btn-sm">
                  {{ trans('Disconnect') }}
                </button>
              </td>
            </tr>
          </tbody>
          <NoDataFound v-else for-table="true" />
        </table>
        <Pagination :links="platforms.links" />
      </div>

      <div class="table-responsive whitespace-nowrap rounded-primary">
        <h5 class="p-2">{{ trans('Brands') }}</h5>
        <table class="table">
          <thead>
            <tr>
              <th>{{ trans('Name') }}</th>
              <th>{{ trans('Description') }}</th>

              <th>
                <p class="text-right">{{ trans('Action') }}</p>
              </th>
            </tr>
          </thead>
          <tbody v-if="brands.total">
            <tr v-for="(brand, key) in brands.data" :key="key">
              <td>{{ brand?.name }}</td>
              <td>{{ textExcerpt(brand?.description, 70) }}</td>

              <td>
                <div class="dropdown" data-placement="bottom-start">
                  <div class="dropdown-toggle">
                    <Icon class="text-2xl" icon="bx:dots-horizontal-rounded" />
                  </div>
                  <div class="dropdown-content w-40">
                    <ul class="dropdown-list">
                      <li class="dropdown-list-item">
                        <button @click="deleteRow(route('admin.user-logs.brands.destroy', post))" class="dropdown-link">
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
          <NoDataFound v-else :for-table="true" />
        </table>
        <Pagination :links="brands.links" />
      </div>

      <div class="table-responsive whitespace-nowrap rounded-primary">
        <h5 class="p-2">{{ trans('Assets') }}</h5>
        <table class="table">
          <thead>
            <tr>
              <th>{{ trans('Asset') }}</th>

              <th>{{ trans('Source') }}</th>
              <th>{{ trans('Type') }}</th>
              <th>{{ trans('Size') }}</th>
              <th>
                <p class="text-right">{{ trans('Action') }}</p>
              </th>
            </tr>
          </thead>
          <tbody v-if="assets.total">
            <tr v-for="(asset, key) in assets.data" :key="key">
              <td>
                <a v-if="asset.mime_type == 'image'" :href="asset.path" target="_blank">
                  <img :src="asset.path" class="h-14 rounded-lg" alt="" />
                </a>
                <a v-if="asset.mime_type == 'video'" :href="asset.path" target="_blank">
                  <video class="h-14 w-24">
                    <source :src="asset.path" type="video/mp4" />
                  </video>
                </a>
                <a v-if="asset.mime_type == 'audio'" :href="asset.path" target="_blank">
                  <audio class="w-full">
                    <source :src="asset.path" type="audio/wav" />
                    <source :src="asset.path" type="audio/mp3" />
                    Your browser does not support the audio element.
                  </audio>
                </a>
              </td>
              <td>{{ asset.type }}</td>
              <td>{{ asset.mime_type }}</td>
              <td>{{ asset.file_size }} MB</td>
              <td>
                <div class="dropdown" data-placement="bottom-start">
                  <div class="dropdown-toggle">
                    <Icon class="text-2xl" icon="bx:dots-horizontal-rounded" />
                  </div>
                  <div class="dropdown-content w-40">
                    <ul class="dropdown-list">
                      <li class="dropdown-list-item">
                        <button @click="deleteRow(route('admin.user-logs.assets.destroy', asset))"
                          class="dropdown-link">
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
          <NoDataFound v-else :for-table="true" />
        </table>
        <Pagination :links="assets.links" />
      </div>
    </div>
  </main>
</template>
