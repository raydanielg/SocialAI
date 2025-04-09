<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import { useForm, router } from '@inertiajs/vue3'
import Paginate from '@/Components/Admin/Paginate.vue'
import moment from 'moment'
import sharedComposable from '@/Composables/sharedComposable'
import Overview from '@/Components/Admin/OverviewGrid.vue'
import drawer from '@/Plugins/Admin/drawer'
import { onMounted, computed } from 'vue'
import NoDataFound from '@/Components/Admin/NoDataFound.vue'
import trans from '@/Composables/transComposable'
defineOptions({ layout: AdminLayout })
const { deleteRow } = sharedComposable()

onMounted(() => {
  drawer.init()
})

const props = defineProps(['services', 'total', 'active', 'inActive', 'buttons'])
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

const form = useForm({
  title: '',
  preview: '',
  short_description: '',
  description: '',
  is_featured: '',
  meta: {
    seo: {
      title: '',
      image: '',
      description: '',
      tags: ''
    }
  },
  status: 'active'
})
</script>

<template>
  <main class="container p-4 sm:p-6">
    <PageHeader title="Services" :buttons="buttons" />
    <div class="space-y-6">
      <Overview :items="stats" grid="3" />

      <div class="table-responsive whitespace-nowrap rounded-primary">
        <table class="table">
          <thead>
            <tr>
              <th>{{ trans('Icon') }}</th>
              <th>{{ trans('Title') }}</th>
              <th>{{ trans('Category') }}</th>
              <th>{{ trans('Is Active') }}</th>
              <th>{{ trans('Is Featured') }}</th>
              <th>{{ trans('Created At') }}</th>
              <th>
                <p class="text-right">
                  {{ trans('Action') }}
                </p>
              </th>
            </tr>
          </thead>

          <tbody v-if="services.total">
            <tr v-for="item in services.data" :key="item.id">
              <td class="text-left">
                <img :src="item.icon" class="h-12 rounded" alt="icon" />
              </td>
              <td>{{ item.title }}</td>
              <td>{{ item.category?.title }}</td>

              <td class="text-left">
                <span class="badge" :class="item.is_active ? 'badge-success' : 'badge-danger'">
                  {{ item.is_active ? trans('Active') : trans('Draft') }}
                </span>
              </td>
              <td class="text-left">
                <span class="badge" :class="item.is_featured ? 'badge-success' : ''">
                  {{ item.is_featured ? trans('Featured') : '-' }}
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
                        <Link :href="route('admin.services.edit', item)" class="dropdown-link">
                        <Icon icon="fe:edit" />
                        <span>{{ trans('Edit') }}</span>
                        </Link>
                      </li>

                      <li class="dropdown-list-item">
                        <button as="button" class="dropdown-link"
                          @click="deleteRow(route('admin.services.destroy', item.id))">
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
      </div>

      <Paginate :links="services.links" />
    </div>
  </main>
</template>
