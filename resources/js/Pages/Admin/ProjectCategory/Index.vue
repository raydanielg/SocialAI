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
import notify from '@/Composables/toastComposable'
import NoDataFound from '@/Components/Admin/NoDataFound.vue'

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
const stats = computed(() => {
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
  status: 'active',
  icon: null,
  preview: null,
  is_featured: 0
})

const editForm = ref({})

const storeCategory = () => {
  categoryForm.post(route('admin.project-categories.store'), {
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
  if (!(editForm.value.preview instanceof File)) {
    editForm.value.preview = null
  }
  router.post(
    route('admin.project-categories.update', editForm.value.id),
    {
      _method: 'PATCH',
      category: editForm.value
    },
    {
      onSuccess: () => {
        editForm.value = {}
        notify.success(trans('Category has been updated successfully'))
        drawer.of('#editCategoryDrawer').hide()
      }
    }
  )
}
</script>

<template>
  <main class="container p-4 sm:p-6">
    <PageHeader title="Project Categories" :buttons="buttons" />
    <div class="space-y-6">
      <Overview :items="stats" grid="3" />

      <div class="table-responsive whitespace-nowrap rounded-primary">
        <table class="table">
          <thead>
            <tr>
              <th class="">{{ trans('Name') }}</th>
              <th class="">{{ trans('Slug') }}</th>
              <th class="">{{ trans('Status') }}</th>
              <th class="">{{ trans('Featured') }}</th>
              <th class="">{{ trans('Created At') }}</th>
              <th class="flex justify-end">{{ trans('Action') }}</th>
            </tr>
          </thead>

          <tbody v-if="categories.total > 0">
            <tr v-for="category in categories.data" :key="category.id">
              <td class="text-left">
                <img class="mr-1 inline w-12 rounded-full" :src="category.preview" alt="preview" />
                {{ category.title }}
              </td>
              <td class="text-left">
                {{ category.slug }}
              </td>

              <td class="text-left">
                <span class="badge" :class="category.status == 1 ? 'badge-primary' : 'badge-danger'">
                  {{ category.status == 1 ? trans('Active') : trans('Inactive') }}
                </span>
              </td>
              <td class="text-left">
                <span class="badge" :class="category.is_featured == 1 ? 'badge-success' : 'badge-danger'">
                  {{ category.is_featured == 1 ? trans('Featured') : trans('Not Featured') }}
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
                          <button as="button" class="dropdown-link" @click="
                            deleteRow(route('admin.project-categories.destroy', category.id))
                            ">
                            <Icon icon="fe:trash" />
                            <span>{{ trans('Delete') }}</span>
                          </button>
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
      <Paginate :links="categories.links" />
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
          <input v-model="categoryForm.title" type="text" class="input" required />
        </div>
        <div class="mb-2">
          <label class="label mb-2">{{ trans('Icon') }}</label>
          <input @input="(e) => (categoryForm.icon = e.target.files[0])" type="file" class="input" />
        </div>
        <div class="mb-2">
          <label class="label mb-2">{{ trans('Preview') }}</label>
          <input @input="(e) => (categoryForm.preview = e.target.files[0])" type="file" class="input" required />
        </div>
        <div class="mb-2">
          <label class="label mb-2">{{ trans('Status') }}</label>
          <select required v-model="categoryForm.status" class="select" name="status">
            <option value="1">{{ trans('Active') }}</option>
            <option value="0">{{ trans('Deactive') }}</option>
          </select>
        </div>
        <div class="mb-2">
          <label class="label mb-2">{{ trans('IsFeatured') }}</label>
          <select required v-model="categoryForm.is_featured" class="select" name="IsFeatured">
            <option value="1">{{ trans('Active') }}</option>
            <option value="0">{{ trans('Deactive') }}</option>
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
          <label class="label mb-2">{{ trans('Title') }}</label>
          <input v-model="editForm.title" type="text" class="input" required />
        </div>

        <div class="mb-2">
          <label class="label mb-2">{{ trans('Preview') }}</label>
          <input @input="(e) => (editForm.preview = e.target.files[0])" type="file" class="input" />
        </div>
        <div class="mb-2">
          <label class="label mb-2">{{ trans('Status') }}</label>
          <select v-model="editForm.status" class="select" name="status">
            <option value="1">{{ trans('Active') }}</option>
            <option value="0">{{ trans('Inactive') }}</option>
          </select>
        </div>
        <div class="mb-2">
          <label class="label mb-2">{{ trans('IsFeatured') }}</label>
          <select v-model="editForm.is_featured" class="select" name="is_featured">
            <option value="1">{{ trans('Active') }}</option>
            <option value="0">{{ trans('Inactive') }}</option>
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
