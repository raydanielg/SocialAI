<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import Pagination from '@/Components/Admin/Paginate.vue'
import NoDataFound from '@/Components/Admin/NoDataFound.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import Overview from '@/Components/Admin/OverviewGrid.vue'
import sharedComposable from '@/Composables/sharedComposable'
import trans from '@/Composables/transComposable'
import FilterDropdown from '@/Components/Admin/FilterDropdown.vue'

defineOptions({ layout: AdminLayout })
const props = defineProps([
  'brands',
  'totalBrandCount',
  'todaysBrandCount',
  'lastThirtyDaysBrandCount'
])

const { deleteRow, textExcerpt, uiAvatar } = sharedComposable()
const stats = [
  { value: props.totalBrandCount, title: trans('Total'), iconClass: 'bx:bar-chart' },
  { value: props.todaysBrandCount, title: trans('Today'), iconClass: 'bx:calendar' },
  {
    value: props.lastThirtyDaysBrandCount,
    title: trans('Last 30 Days'),
    iconClass: 'bx:calendar'
  }
]

const filterOptions = [
  {
    label: 'Name',
    value: 'name'
  }
]
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader />
    <div class="space-y-4">
      <Overview :items="stats" grid="3" />

      <FilterDropdown :options="filterOptions" />

      <div class="table-responsive whitespace-nowrap rounded-primary">
        <table class="table">
          <thead>
            <tr>
              <th>{{ trans('Logo') }}</th>
              <th>{{ trans('Brand Name') }}</th>
              <th>{{ trans('Brand User') }}</th>
              <th>
                <p class="text-right">{{ trans('Action') }}</p>
              </th>
            </tr>
          </thead>
          <tbody v-if="brands.total">
            <tr v-for="(brand, key) in brands.data" :key="key">
              <td>
                <img :src="brand.logo" class="h-12 rounded-lg" alt="logo" />
              </td>
              <td>{{ brand.name }}</td>
              <td>
                <div class="flex items-center gap-3" v-if="brand.user">
                  <img class="h-10 rounded-full" :src="uiAvatar(brand.user?.name, brand.user?.avatar)" />
                  <div>
                    <Link :href="route('admin.users.show', brand.user.id)" class="font-bold">
                    {{ brand.user?.name }}
                    </Link>
                    <p>
                      {{ brand.user?.email }}
                    </p>
                  </div>
                </div>
              </td>

              <td>
                <div class="dropdown" data-placement="bottom-start">
                  <div class="dropdown-toggle">
                    <Icon class="text-2xl" icon="bx:dots-horizontal-rounded" />
                  </div>
                  <div class="dropdown-content w-40">
                    <ul class="dropdown-list">
                      <li class="dropdown-list-item">
                        <button @click="deleteRow(route('admin.user-logs.brands.destroy', brand))"
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
        <Pagination :links="brands.links" />
      </div>
    </div>
  </main>
</template>
