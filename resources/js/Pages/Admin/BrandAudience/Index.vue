<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import { useForm } from '@inertiajs/vue3'
import Paginate from '@/Components/Admin/Paginate.vue'
import moment from 'moment'
import sharedComposable from '@/Composables/sharedComposable'
import Overview from '@/Components/Admin/OverviewGrid.vue'
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
import drawer from '@/Plugins/Admin/drawer'
import { onMounted, computed } from 'vue'
import NoDataFound from '@/Components/Admin/NoDataFound.vue'
import InputFieldError from '@/Components/InputFieldError.vue'
import trans from '@/Composables/transComposable'
defineOptions({ layout: AdminLayout })
const { deleteRow, textExcerpt } = sharedComposable()

onMounted(() => {
  drawer.init()
})

const props = defineProps([
  'brandAudiences',
  'categories',
  'total',
  'active',
  'inActive',
  'buttons'
])

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
  category_id: '',
  segments: [
    {
      id: 1,
      text: ''
    },
    {
      id: 2,
      text: ''
    },
    {
      id: 3,
      text: ''
    }
  ],
  status: 'active'
})

const store = () => {
  form.post(route('admin.brand-audiences.store'), {
    onSuccess: () => {
      form.reset()
      drawer.of('#addNewItemDrawer').hide()
    }
  })
}

const editForm = useForm({
  category_id: '',
  segments: [
    {
      id: 1,
      text: ''
    },
    {
      id: 2,
      text: ''
    },
    {
      id: 3,
      text: ''
    }
  ],
  status: 'active'
})

const openEditItemDrawer = (item) => {
  editForm.id = item.id
  editForm.category_id = item.category_id
  editForm.segments = item.segments
  editForm.status = item.status
  drawer.of('#editItemDrawer').show()
}

const update = () => {
  editForm.put(route('admin.brand-audiences.update', editForm.id), {
    onSuccess: () => {
      editForm.value = {}
      drawer.of('#editItemDrawer').hide()
    }
  })
}
</script>

<template>
  <main class="container p-4 sm:p-6">
    <PageHeader title="Brand Identities" :buttons="buttons" />
    <div class="space-y-6">
      <Overview :items="stats" grid="3" />

      <div class="table-responsive whitespace-nowrap rounded-primary">
        <table class="table">
          <thead>
            <tr>
              <th>{{ trans('Category') }}</th>
              <th>{{ trans('Segment 1') }}</th>
              <th>{{ trans('Segment 2') }}</th>
              <th>{{ trans('Segment 3') }}</th>
              <th>{{ trans('Status') }}</th>
              <th>{{ trans('Created At') }}</th>
              <th>
                <p class="text-right">
                  {{ trans('Action') }}
                </p>
              </th>
            </tr>
          </thead>

          <tbody v-if="brandAudiences.total">
            <tr v-for="audience in brandAudiences.data" :key="audience.id">
              <td>
                {{ audience.category?.title }}
              </td>

              <td class="text-left">
                {{ textExcerpt(audience.segments?.[0]?.text, 30) }}
              </td>
              <td class="text-left">
                {{ textExcerpt(audience.segments?.[1]?.text, 30) }}
              </td>
              <td class="text-left">
                {{ textExcerpt(audience.segments?.[2]?.text, 30) }}
              </td>

              <td class="text-left">
                <span class="badge" :class="audience.status == 'active' ? 'badge-success' : 'badge-danger'">
                  {{ audience.status == 'active' ? trans('Active') : trans('Draft') }}
                </span>
              </td>
              <td>
                {{ moment(audience.created_at).format('D-MMM-Y') }}
              </td>
              <td class="">
                <div class="dropdown" data-placement="bottom-start">
                  <div class="dropdown-toggle">
                    <Icon class="text-2xl" icon="bx:dots-horizontal-rounded" />
                  </div>
                  <div class="dropdown-content w-40">
                    <ul class="dropdown-list">
                      <li class="dropdown-list-item">
                        <button @click="openEditItemDrawer(audience)" class="dropdown-link">
                          <Icon icon="fe:edit" />
                          <span>{{ trans('Edit') }}</span>
                        </button>
                      </li>

                      <li class="dropdown-list-item">
                        <button as="button" class="dropdown-link"
                          @click="deleteRow(route('admin.brand-audiences.destroy', audience.id))">
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
        <Paginate :links="brandAudiences.links" />
      </div>
    </div>
  </main>

  <div id="addNewItemDrawer" class="drawer drawer-right w-[600px]">
    <form @submit.prevent="store">
      <div class="drawer-header">
        <h5>{{ trans('Add New Audience') }}</h5>
        <button type="button"
          class="btn btn-plain-secondary dark:text-slate-300 dark:hover:bg-slate-700 dark:focus:bg-slate-700"
          data-dismiss="drawer">
          <Icon class="text-xl" icon="mdi:close" />
        </button>
      </div>
      <div class="drawer-body">
        <div class="mb-2">
          <label class="label mb-1">{{ trans('Category') }}</label>
          <select v-model="form.category_id" class="select">
            <option value="">{{ trans('SELECT') }}</option>
            <option v-for="category in categories" :value="category.id" :key="category.id">
              {{ category.title }}
            </option>
          </select>
          <InputFieldError :message="form.errors.category_id" />
        </div>

        <div class="mb-2" v-for="(segment, index) in form.segments" :key="index">
          <label class="label mb-1">{{ trans(`Segment ${index + 1}`) }}</label>
          <input v-model="segment.text" type="text" class="input" />
          <InputFieldError :message="form.errors[`segments.${index}.text`]" />
        </div>

        <div class="mb-2">
          <label class="label mb-1">{{ trans('Status') }}</label>
          <select required v-model="form.status" class="select" name="status">
            <option value="active">{{ trans('Active') }}</option>
            <option value="inactive">{{ trans('Draft') }}</option>
          </select>
        </div>
      </div>
      <div class="drawer-footer">
        <div class="flex gap-2">
          <button type="button" class="btn btn-secondary w-full" data-dismiss="drawer">
            <span> {{ trans('Close') }}</span>
          </button>
          <SpinnerBtn classes="btn btn-primary w-full" :processing="form.processing" :btn-text="trans('Create')" />
        </div>
      </div>
    </form>
  </div>

  <div id="editItemDrawer" class="drawer drawer-right">
    <form @submit.prevent="update">
      <div class="drawer-header">
        <h5>{{ trans('Edit Audience') }}</h5>
        <button type="button"
          class="btn btn-plain-secondary dark:text-slate-300 dark:hover:bg-slate-700 dark:focus:bg-slate-700"
          data-dismiss="drawer">
          <Icon class="text-xl" icon="mdi:close" />
        </button>
      </div>
      <div class="drawer-body">
        <div class="mb-2">
          <label class="label mb-1">{{ trans('Category') }}</label>
          <select v-model="editForm.category_id" class="select">
            <option value="">{{ trans('SELECT') }}</option>
            <option v-for="category in categories" :value="category.id" :key="category.id">
              {{ category.title }}
            </option>
          </select>
          <InputFieldError :message="editForm.errors.category_id" />
        </div>

        <div class="mb-2" v-for="(segment, index) in editForm.segments" :key="index">
          <label class="label mb-1">{{ trans(`Segment ${index + 1}`) }}</label>
          <input v-model="segment.text" type="text" class="input" />
          <InputFieldError :message="editForm.errors[`segments.${index}.text`]" />
        </div>

        <div class="mb-2">
          <label class="label mb-1">{{ trans('Status') }}</label>
          <select required v-model="editForm.status" class="select" name="status">
            <option value="active">{{ trans('Active') }}</option>
            <option value="inactive">{{ trans('Draft') }}</option>
          </select>
        </div>
      </div>
      <div class="drawer-footer">
        <div class="flex gap-2">
          <button type="button" class="btn btn-secondary w-full" data-dismiss="drawer">
            <span> {{ trans('Close') }}</span>
          </button>
          <SpinnerBtn classes="btn btn-primary w-full" :processing="editForm.processing" :btn-text="trans('Update')" />
        </div>
      </div>
    </form>
  </div>
</template>
