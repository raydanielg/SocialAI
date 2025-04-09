<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import { useForm, router } from '@inertiajs/vue3'
import Paginate from '@/Components/Admin/Paginate.vue'
import moment from 'moment'
import { ref } from 'vue'
import sharedComposable from '@/Composables/sharedComposable'
import Overview from '@/Components/Admin/OverviewGrid.vue'
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
import drawer from '@/Plugins/Admin/drawer'
import { onMounted, computed } from 'vue'
import NoDataFound from '@/Components/Admin/NoDataFound.vue'
import InputFieldError from '@/Components/InputFieldError.vue'
import trans from '@/Composables/transComposable'
defineOptions({ layout: AdminLayout })
const { deleteRow } = sharedComposable()

onMounted(() => {
  drawer.init()
})

const props = defineProps(['slogans', 'categories', 'total', 'active', 'inActive', 'buttons'])

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
  category_id: '',
  status: 'active'
})

const store = () => {
  form.post(route('admin.brand-slogans.store'), {
    onSuccess: () => {
      form.reset()
      drawer.of('#addNewItemDrawer').hide()
    }
  })
}

const editForm = ref({})

const openEditItemDrawer = (item) => {
  editForm.value = { ...item }
  drawer.of('#editItemDrawer').show()
}

const update = () => {
  // modifiers
  editForm.value._method = 'PUT'
  if (!(editForm.value.preview instanceof File)) {
    editForm.value.preview = null
  }

  router.post(route('admin.brand-slogans.update', editForm.value.id), editForm.value, {
    onSuccess: () => {
      editForm.value = {}
      drawer.of('#editItemDrawer').hide()
    }
  })
}
</script>

<template>
  <main class="container p-4 sm:p-6">
    <PageHeader title="Brand Slogans" :buttons="buttons" />
    <div class="space-y-6">
      <Overview :items="stats" grid="3" />

      <div class="table-responsive whitespace-nowrap rounded-primary">
        <table class="table">
          <thead>
            <tr>
              <th>{{ trans('Slogan') }}</th>
              <th>{{ trans('Category') }}</th>
              <th>{{ trans('Status') }}</th>
              <th>{{ trans('Created At') }}</th>
              <th>
                <p class="text-right">
                  {{ trans('Action') }}
                </p>
              </th>
            </tr>
          </thead>

          <tbody v-if="slogans.total">
            <tr v-for="slogan in slogans.data" :key="slogan.id">
              <td class="text-left">
                {{ slogan.title }}
              </td>
              <td>
                {{ slogan.category?.title }}
              </td>

              <td class="text-left">
                <span class="badge" :class="slogan.status == 'active' ? 'badge-success' : 'badge-danger'">
                  {{ slogan.status == 'active' ? trans('Active') : trans('Draft') }}
                </span>
              </td>
              <td>
                {{ moment(slogan.created_at).format('D-MMM-Y') }}
              </td>
              <td class="">
                <div class="dropdown" data-placement="bottom-start">
                  <div class="dropdown-toggle">
                    <Icon class="text-2xl" icon="bx:dots-horizontal-rounded" />
                  </div>
                  <div class="dropdown-content w-40">
                    <ul class="dropdown-list">
                      <li class="dropdown-list-item">
                        <button @click="openEditItemDrawer(slogan)" class="dropdown-link">
                          <Icon icon="fe:edit" />
                          <span>{{ trans('Edit') }}</span>
                        </button>
                      </li>

                      <li class="dropdown-list-item">
                        <button as="button" class="dropdown-link"
                          @click="deleteRow(route('admin.brand-slogans.destroy', slogan.id))">
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
        <Paginate :links="slogans.links" />
      </div>
    </div>
  </main>

  <div id="addNewItemDrawer" class="drawer drawer-right">
    <form @submit.prevent="store">
      <div class="drawer-header">
        <h5>{{ trans('Add New Slogan') }}</h5>
        <button type="button"
          class="btn btn-plain-secondary dark:text-slate-300 dark:hover:bg-slate-700 dark:focus:bg-slate-700"
          data-dismiss="drawer">
          <Icon class="text-xl" icon="mdi:close" />
        </button>
      </div>
      <div class="drawer-body">
        <div class="mb-2">
          <label for="">{{ trans('Category') }}</label>
          <select v-model="form.category_id" class="select">
            <option value="">{{ trans('SELECT') }}</option>
            <option v-for="category in categories" :value="category.id" :key="category.id">
              {{ category.title }}
            </option>
          </select>
        </div>

        <div class="mb-2">
          <label class="label mb-2">{{ trans('Slogan Title') }}</label>
          <input v-model="form.title" type="text" name="title" class="input" />
          <InputFieldError :message="form.errors.title" />
        </div>

        <div class="mb-2">
          <label class="label mb-2">{{ trans('Status') }}</label>
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
        <h5>{{ trans('Edit Slogan') }}</h5>
        <button type="button"
          class="btn btn-plain-secondary dark:text-slate-300 dark:hover:bg-slate-700 dark:focus:bg-slate-700"
          data-dismiss="drawer">
          <Icon class="text-xl" icon="mdi:close" />
        </button>
      </div>
      <div class="drawer-body">
        <div class="mb-2">
          <label for="">{{ trans('Category') }}</label>
          <select v-model="editForm.category_id" class="select">
            <option value="">{{ trans('SELECT') }}</option>
            <option v-for="category in categories" :value="category.id" :key="category.id">
              {{ category.title }}
            </option>
          </select>
        </div>

        <div class="mb-2">
          <label class="label mb-2">{{ trans('Slogan Title') }}</label>
          <input v-model="editForm.title" type="text" class="input" required />
        </div>

        <div class="mb-2">
          <label class="label mb-2">{{ trans('Status') }}</label>
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
