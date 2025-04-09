<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import { useForm, router } from '@inertiajs/vue3'
import sharedComposable from '@/Composables/sharedComposable'
import toast from '@/Composables/toastComposable'
import trans from '@/Composables/transComposable'
import drawer from '@/Plugins/Admin/drawer'

import { onMounted, ref } from 'vue'
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
import NoDataFound from '@/Components/Admin/NoDataFound.vue'
defineOptions({ layout: AdminLayout })

const { deleteRow } = sharedComposable()

onMounted(() => {
  drawer.init()
})

const props = defineProps(['languages', 'buttons', 'segments'])

const form = useForm({
  name: ''
})
const editForm = ref({})
const isProcessing = ref(false)
const storeCurrency = () => {
  form.post(route('admin.ai-language.store'), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset()
      toast.success(trans('Language has been added successfully'))
      drawer.of('#addNewCurrencyDrawer').hide()
    }
  })
}
const updateCurrency = () => {
  isProcessing.value = true
  router.patch(route('admin.ai-language.update', editForm.value.id), editForm.value, {
    preserveScroll: true,
    onSuccess: () => {
      editForm.value = {}
      toast.success(trans('Language has been updated successfully'))
      drawer.of('#editCurrencyDrawer').hide()
    },
    onFinish: () => (isProcessing.value = false)
  })
}
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader title="Create a Language" :buttons="buttons" />
    <div class="space-y-6">
      <div class="table-responsive whitespace-nowrap rounded-primary">
        <table class="table">
          <thead>
            <tr>
              <th class="col-2">{{ trans('Name') }}</th>
              <th class="flex justify-end">{{ trans('Action') }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="language in languages" :key="language.code">
              <td class="text-left">
                {{ language.name }}
              </td>
              <td class="flex justify-end gap-3">
                <button
                  type="button"
                  class="btn btn-dark"
                  @click="
                    () => {
                      editForm = { ...language }
                      drawer.of('#editCurrencyDrawer').show()
                    }
                  "
                >
                  <Icon icon="fe:edit" />
                </button>
                <button
                  type="button"
                  class="btn btn-danger"
                  @click="deleteRow(route('admin.ai-language.destroy', language.id))"
                >
                  <Icon icon="fe:trash" />
                </button>
              </td>
            </tr>
          </tbody>
          <NoDataFound v-if="languages.length < 1" for-table="true" />
        </table>
      </div>
    </div>
  </main>

  <div id="addNewCurrencyDrawer" class="drawer drawer-right">
    <form @submit.prevent="storeCurrency()">
      <div class="drawer-header">
        <h5>{{ trans('Add New language') }}</h5>
        <button
          type="button"
          class="btn btn-plain-secondary dark:text-slate-300 dark:hover:bg-slate-700 dark:focus:bg-slate-700"
          data-dismiss="drawer"
        >
          <Icon class="text-xl" icon="mdi:close" />
        </button>
      </div>
      <div class="drawer-body">
        <div class="mb-2">
          <label>{{ trans('Name') }}</label>
          <input
            v-model="form.name"
            type="text"
            name="name"
            class="input"
            required
            placeholder="English"
          />
        </div>
      </div>
      <div class="drawer-footer">
        <div class="flex justify-between gap-2">
          <button type="button" class="btn btn-secondary w-full" data-dismiss="drawer">
            <span> {{ trans('Close') }}</span>
          </button>
          <SpinnerBtn
            classes="btn w-full btn-primary"
            :processing="form.processing"
            :btn-text="trans('Create')"
          />
        </div>
      </div>
    </form>
  </div>
  <div id="editCurrencyDrawer" class="drawer drawer-right">
    <form @submit.prevent="updateCurrency">
      <div class="drawer-header">
        <h5>{{ trans('Edit language') }}</h5>
        <button
          type="button"
          class="btn btn-plain-secondary dark:text-slate-300 dark:hover:bg-slate-700 dark:focus:bg-slate-700"
          data-dismiss="drawer"
        >
          <Icon class="text-xl" icon="mdi:close" />
        </button>
      </div>
      <div class="drawer-body">
        <div class="mb-2">
          <label class="label mb-2">{{ trans('Name') }}</label>
          <input v-model="editForm.name" type="text" name="name" class="input" required />
        </div>
      </div>
      <div class="drawer-footer">
        <div class="flex justify-between gap-2">
          <button type="button" class="btn btn-secondary w-full" data-dismiss="drawer">
            <span> {{ trans('Close') }}</span>
          </button>
          <SpinnerBtn
            :processing="isProcessing"
            classes="btn w-full btn-primary"
            :btn-text="trans('Save Changes')"
          />
        </div>
      </div>
    </form>
  </div>
</template>
