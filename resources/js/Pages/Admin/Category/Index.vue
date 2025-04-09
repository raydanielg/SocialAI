<template>
  <main class="container p-4 sm:p-6">
    <PageHeader title="Categories" :buttons="buttons" />
    <div class="space-y-6">
      <Overview :items="categorieStats" grid="3" />

      <div class="table-responsive whitespace-nowrap rounded-primary">
        <table class="table">
          <thead>
            <tr>
              <th class="">{{ trans('Name') }}</th>
              <th class="">{{ trans('Slug') }}</th>
              <th class="text-center">{{ trans('Language') }}</th>
              <th class="">{{ trans('Status') }}</th>
              <th class="">{{ trans('Created At') }}</th>
              <th class="flex justify-end">{{ trans('Action') }}</th>
            </tr>
          </thead>

          <tbody v-if="categories.total">
            <tr v-for="category in categories.data" :key="category.id">
              <td class="text-left">
                {{ category.title }}
              </td>
              <td class="text-left">
                {{ category.slug }}
              </td>
              <td class="text-center">
                {{ category.lang }}
              </td>
              <td class="text-left">
                <span class="badge" :class="category.status == 1 ? 'badge-success' : 'badge-danger'">
                  {{ category.status == 1 ? trans('Active') : trans('Draft') }}
                </span>
              </td>
              <td>
                {{ moment(category.created_at).format('D-MMM-Y') }}
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
                          <button @click="openEditCategoryDrawer(category)" class="dropdown-link">
                            <Icon icon="fe:edit" />
                            <span>{{ trans('Edit') }}</span>
                          </button>
                        </li>

                        <li class="dropdown-list-item">
                          <Link as="button" class="dropdown-link" @click="deleteRow('/admin/category/' + category.id)">
                          <Icon icon="fe:trash" />
                          <span>{{ trans('Delete') }}</span>
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
      </div>
    </div>
  </main>

  <div id="addNewCategoryDrawer" class="drawer drawer-right">
    <form @submit.prevent="storeCategory()">
      <div class="drawer-header">
        <h5>{{ trans('Add New Category') }}</h5>
        <button type="button"
          class="btn btn-plain-secondary dark:text-slate-300 dark:hover:bg-slate-700 dark:focus:bg-slate-700"
          data-dismiss="drawer">
          <Icon class="text-xl" icon="mdi:close" />
        </button>
      </div>
      <div class="drawer-body">
        <div class="mb-2">
          <label>{{ trans('Title') }}</label>
          <input v-model="categoryForm.title" type="text" name="title" class="input" required />
        </div>
        <div class="mb-2">
          <label>{{ trans('Status') }}</label>
          <select required v-model="categoryForm.status" class="select" name="status">
            <option value="1">{{ trans('Active') }}</option>
            <option value="0">{{ trans('Deactive') }}</option>
          </select>
        </div>
        <div class="mb-2">
          <label>{{ trans('Language') }}</label>
          <select required v-model="categoryForm.language" class="select" name="language">
            <template v-for="(language, key) in languages" :key="key">
              <option :value="key">{{ language }}</option>
            </template>
          </select>
        </div>
      </div>
      <div class="drawer-footer">
        <div class="flex justify-end gap-2">
          <button type="button" class="btn btn-secondary" data-dismiss="drawer">
            <span> {{ trans('Close') }}</span>
          </button>
          <SpinnerBtn classes="btn btn-primary" :processing="categoryForm.processing"
            :btn-text="trans('Save Changes')" />
        </div>
      </div>
    </form>
  </div>

  <div id="editCategoryDrawer" class="drawer drawer-right">
    <form @submit.prevent="updateCategory()">
      <div class="drawer-header">
        <h5>{{ trans('Edit Category') }}</h5>
        <button type="button"
          class="btn btn-plain-secondary dark:text-slate-300 dark:hover:bg-slate-700 dark:focus:bg-slate-700"
          data-dismiss="drawer">
          <Icon class="text-xl" icon="mdi:close" />
        </button>
      </div>
      <div class="drawer-body">
        <div class="mb-2">
          <label>{{ trans('Title') }}</label>
          <input v-model="editForm.title" type="text" name="title" class="input" required />
        </div>

        <div class="mb-2">
          <label>{{ trans('Status') }}</label>
          <select v-model="editForm.status" class="select" name="status">
            <option value="1">{{ trans('Active') }}</option>
            <option value="0">{{ trans('Draft') }}</option>
          </select>
        </div>
        <div class="mb-2">
          <label>{{ trans('Language') }}</label>
          <select v-model="editForm.lang" class="select" name="language">
            <template v-for="(language, key) in languages" :key="key">
              <option :value="key">{{ language }}</option>
            </template>
          </select>
        </div>
      </div>
      <div class="drawer-footer">
        <div class="flex justify-end gap-2">
          <button type="button" class="btn btn-secondary" data-dismiss="drawer">
            <span> {{ trans('Close') }}</span>
          </button>
          <SpinnerBtn classes="btn btn-primary" :processing="editForm.processing" :btn-text="trans('Save Changes')" />
        </div>
      </div>
    </form>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'

import moment from 'moment'

import Alert from '@/Components/Admin/NoDataFound.vue'
import NoDataFound from '@/Components/Admin/NoDataFound.vue'
import Overview from '@/Components/Admin/OverviewGrid.vue'
import Paginate from '@/Components/Admin/Paginate.vue'
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
import sharedComposable from '@/Composables/sharedComposable'
import trans from '@/Composables/transComposable'
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import drawer from '@/Plugins/Admin/drawer'
import notify from '@/Composables/toastComposable'
import { Link, router, useForm } from '@inertiajs/vue3'

defineOptions({ layout: AdminLayout })
const { deleteRow } = sharedComposable()

onMounted(() => {
  drawer.init()
})

const props = defineProps([
  'categories',
  'totalCategories',
  'activeCategories',
  'inActiveCategories',
  'languages',
  'buttons',
  'segments'
])

const categorieStats = [
  {
    value: props.totalCategories,
    title: trans('Total Categories'),
    iconClass: 'bx:bar-chart'
  },
  {
    value: props.activeCategories,
    title: trans('Active Categories'),
    iconClass: 'bx:check-circle'
  },
  {
    value: props.inActiveCategories,
    title: trans('Inactive Categories'),
    iconClass: 'bx:x-circle'
  }
]

const categoryForm = useForm({
  title: '',
  status: 'active',
  language: ''
})

const editForm = ref({})

const storeCategory = () => {
  categoryForm.post(route('admin.category.store'), {
    onSuccess: () => {
      categoryForm.reset()
      notify.success(trans('Category has been added successfully'))
      drawer.of('#addNewCategoryDrawer').hide()
    }
  })
}

const openEditCategoryDrawer = (category) => {
  editForm.value = { ...category }
  drawer.of('#editCategoryDrawer').show()
}

const updateCategory = () => {
  router.patch(route('admin.category.update', editForm.value.id), editForm.value, {
    onSuccess: () => {
      editForm.value = {}
      notify.success(trans('Category has been updated successfully'))
      drawer.of('#editCategoryDrawer').hide()
    }
  })
}
</script>
