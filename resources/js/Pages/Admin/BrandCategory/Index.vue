<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import { useForm, router } from '@inertiajs/vue3'
import Paginate from '@/Components/Admin/Paginate.vue'
import moment from 'moment'
import { ref } from 'vue'
import trans from '@/Composables/transComposable'
import sharedComposable from '@/Composables/sharedComposable'
import Overview from '@/Components/Admin/OverviewGrid.vue'
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
import drawer from '@/Plugins/Admin/drawer'
import { onMounted, computed } from 'vue'
import NoDataFound from '@/Components/Admin/NoDataFound.vue'
import InputFieldError from '@/Components/InputFieldError.vue'

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
  'languages'
])
const categoryStats = computed(() => {
  return [
    {
      value: props.totalCategories,
      title: trans('Total'),
      iconClass: 'bx:badge'
    },
    {
      value: props.activeCategories,
      title: trans('Active'),
      iconClass: 'bx:badge-check'
    },
    {
      value: props.inActiveCategories,
      title: trans('Inactive'),
      iconClass: 'bx:x-circle'
    }
  ]
})

const categoryForm = useForm({
  title: '',
  status: 1,
  icon: null,
  preview: null,
  is_featured: 0
})

const storeCategory = () => {
  categoryForm.post(route('admin.brand-categories.store'), {
    onSuccess: () => {
      categoryForm.reset()
      drawer.of('#addNewCategoryDrawer').hide()
    }
  })
}

const editForm = ref({})

const openEditCategoryDrawer = (category) => {
  editForm.value = { ...category }
  drawer.of('#editCategoryDrawer').show()
}

const updateCategory = () => {
  if (!(editForm.value.preview instanceof File)) {
    editForm.value.preview = null
  }
  router.post(
    route('admin.brand-categories.update', editForm.value.id),
    {
      _method: 'PATCH',
      category: editForm.value
    },
    {
      onSuccess: () => {
        editForm.value = {}
        drawer.of('#editCategoryDrawer').hide()
      }
    }
  )
}
</script>

<template>
  <main class="container p-4 sm:p-6">
    <PageHeader />
    <div class="space-y-6">
      <Overview :items="categoryStats" grid="3" />

      <div class="table-responsive whitespace-nowrap rounded-primary">
        <table class="table">
          <thead>
            <tr>
              <th>{{ trans('Name') }}</th>
              <th>{{ trans('Slug') }}</th>
              <th>{{ trans('Status') }}</th>

              <th>{{ trans('Created At') }}</th>
              <th>
                <p class="text-right">
                  {{ trans('Action') }}
                </p>
              </th>
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

              <td class="text-left">
                <span class="badge" :class="category.status == 1 ? 'badge-success' : 'badge-danger'">
                  {{ category.status == 1 ? trans('Active') : trans('Draft') }}
                </span>
              </td>

              <td>
                {{ moment(category.created_at).format('D-MMM-Y') }}
              </td>
              <td class="">
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
                        <button as="button" class="dropdown-link"
                          @click="deleteRow(route('admin.brand-categories.destroy', category.id))">
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
        <Paginate :links="categories.links" />
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
          <label class="label mb-2">{{ trans('Title') }}</label>
          <input v-model="categoryForm.title" type="text" name="title" class="input" />
          <InputFieldError :message="categoryForm.errors.title" />
        </div>

        <div class="mb-2">
          <label class="label mb-2">{{ trans('Preview') }}</label>
          <input @input="(e) => (categoryForm.preview = e.target.files[0])" type="file" name="preview" class="input" />
          <InputFieldError :message="categoryForm.errors.preview" />
        </div>
        <div class="mb-2">
          <label class="label mb-2">{{ trans('Status') }}</label>
          <select required v-model="categoryForm.status" class="select" name="status">
            <option value="1">{{ trans('Active') }}</option>
            <option value="0">{{ trans('Draft') }}</option>
          </select>
        </div>
      </div>
      <div class="drawer-footer">
        <div class="flex gap-2">
          <button type="button" class="btn btn-secondary w-full" data-dismiss="drawer">
            <span> {{ trans('Close') }}</span>
          </button>
          <SpinnerBtn classes="btn btn-primary w-full" :processing="categoryForm.processing"
            :btn-text="trans('Create')" />
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
          <label class="label mb-2">{{ trans('Title') }}</label>
          <input v-model="editForm.title" type="text" class="input" />

        </div>

        <div class="mb-2">
          <label class="label mb-2">{{ trans('Preview') }}</label>
          <input @input="(e) => (editForm.preview = e.target.files[0])" type="file" name="preview" class="input" />

        </div>
        <div class="mb-2">
          <label class="label mb-2">{{ trans('Status') }}</label>
          <select required v-model="editForm.status" class="select" name="status">
            <option value="1">{{ trans('Active') }}</option>
            <option value="0">{{ trans('Draft') }}</option>
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
