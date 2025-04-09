<script setup>
import { computed, onMounted, ref } from 'vue'

import moment from 'moment'

import NoDataFound from '@/Components/Admin/NoDataFound.vue'
import Overview from '@/Components/Admin/OverviewGrid.vue'
import Paginate from '@/Components/Admin/Paginate.vue'
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
import InputFieldError from '@/Components/InputFieldError.vue'
import sharedComposable from '@/Composables/sharedComposable'
import trans from '@/Composables/transComposable'
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import drawer from '@/Plugins/Admin/drawer'
import notify from '@/Composables/toastComposable'
import { router, useForm } from '@inertiajs/vue3'

defineOptions({ layout: AdminLayout })
const { deleteRow } = sharedComposable()

onMounted(() => {
  drawer.init()
})

const props = defineProps(['jobs', 'total', 'active', 'inActive', 'buttons', 'segments'])
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

const store = () => {
  form.post(route('admin.jobs.store'), {
    onSuccess: () => {
      form.reset()
      drawer.of('#addNewItemDrawer').hide()
      notify.success(trans('Added Successfully'))
    }
  })
}

const editForm = ref({})

const openEditItemDrawer = (item) => {
  editForm.value = { ...item }
  drawer.of('#editItemDrawer').show()
}

const update = () => {
  editForm.value._method = 'put'
  if (!(editForm.value.preview instanceof File)) {
    editForm.value.preview = null
  }
  editForm.processing = true
  router.post(route('admin.jobs.update', editForm.value.id), editForm.value, {
    onSuccess: () => {
      editForm.value = {}
      notify.success(trans('Updated Successfully'))
      drawer.of('#editItemDrawer').hide()
      editForm.processing = false
    }
  })
}
</script>

<template>
  <main class="container p-4 sm:p-6">
    <PageHeader title="Jobs" :buttons="buttons" />
    <div class="space-y-6">
      <Overview :items="stats" grid="3" />

      <div class="table-responsive whitespace-nowrap rounded-primary">
        <table class="table">
          <thead>
            <tr>
              <th>{{ trans('Title') }}</th>
              <th>{{ trans('Location') }}</th>
              <th>{{ trans('Type') }}</th>
              <th>{{ trans('Expertise') }}</th>
              <th>{{ trans('Applications') }}</th>
              <th>{{ trans('Is Active') }}</th>
              <th>{{ trans('Created At') }}</th>
              <th>
                <p class="text-right">
                  {{ trans('Action') }}
                </p>
              </th>
            </tr>
          </thead>

          <tbody v-if="jobs.total">
            <tr v-for="item in jobs.data" :key="item.id">
              <td>{{ item.title }}</td>
              <td>{{ item.location }}</td>
              <td>{{ item.type }}</td>
              <td>{{ item.expert_level }}</td>
              <td>{{ item.applications_count }}</td>
              <td class="text-left">
                <span class="badge" :class="item.is_active ? 'badge-success' : 'badge-danger'">
                  {{ item.is_active ? trans('Active') : trans('Draft') }}
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
                        <Link :href="route('admin.jobs.show', item)" class="dropdown-link">
                        <Icon icon="fe:eye" />
                        <span>{{ trans('Applications') }}</span>
                        </Link>
                      </li>

                      <li class="dropdown-list-item">
                        <Link :href="route('admin.jobs.edit', item)" class="dropdown-link">
                        <Icon icon="fe:edit" />
                        <span>{{ trans('Edit') }}</span>
                        </Link>
                      </li>

                      <li class="dropdown-list-item">
                        <button as="button" class="dropdown-link"
                          @click="deleteRow(route('admin.jobs.destroy', item.slug))">
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
    </div>
  </main>
</template>
