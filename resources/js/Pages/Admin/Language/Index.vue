<script setup>
import { onMounted } from "vue"

import SpinnerBtn from "@/Components/Admin/SpinnerBtn.vue"
import sharedComposable from "@/Composables/sharedComposable"
import toast from "@/Composables/toastComposable"
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue"
import PageHeader from "@/Layouts/Admin/PageHeader.vue"
import drawer from "@/Plugins/Admin/drawer"
import {
  Link,
  useForm,
} from "@inertiajs/vue3"

defineOptions({ layout: AdminLayout })

const { deleteRow } = sharedComposable()

onMounted(() => {
  drawer.init()
})

const props = defineProps(['languageList', 'countries'])

const form = useForm({
  name: '',
  language_code: ''
})

const storeLanguage = () => {
  form.post(route('admin.language.store'), {
    onSuccess: () => {
      form.reset()
      toast.success(trans('Language has been added successfully'))
      drawer.of('#addNewLanguageDrawer').hide()
    }
  })
}
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader />
    <div class="space-y-6">
      <div class="table-responsive whitespace-nowrap rounded-primary">
        <table class="table">
          <thead>
            <tr>
              <th class="col-2">{{ trans('Language Name') }}</th>
              <th class="col-2">{{ trans('Language Key') }}</th>
              <th class="col-8">
                <div class="text-right">
                  {{ trans('Action') }}
                </div>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(language, key) in languageList" :key="key">
              <td class="text-left">
                {{ language }}
              </td>
              <td class="text-left">
                {{ key }}
              </td>
              <td class="flex justify-end gap-3">
                <Link :href="route('admin.language.show', key)" class="btn btn-primary">
                <Icon class="h-6" icon="material-symbols:edit-outline" />
                </Link>
                <a href="javascript:void(0)" class="delete-confirm btn btn-danger"
                  @click="deleteRow(route('admin.language.show', key))">
                  <Icon class="h-6" icon="material-symbols:delete-outline" />
                </a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </main>

  <div id="addNewLanguageDrawer" class="drawer drawer-right">
    <form @submit.prevent="storeLanguage()">
      <div class="drawer-header">
        <h5>{{ trans('Add New Language') }}</h5>
        <button type="button"
          class="btn btn-plain-secondary dark:text-slate-300 dark:hover:bg-slate-700 dark:focus:bg-slate-700"
          data-dismiss="drawer">
          <Icon class="text-xl" icon="mdi:close" />
        </button>
      </div>
      <div class="drawer-body">
        <div class="mb-2">
          <label>{{ trans('Language Name') }}</label>
          <input v-model="form.name" type="text" name="name" class="input" required placeholder="English" />
        </div>
        <div class="mb-2">
          <label>{{ trans('Select Language') }}</label>
          <select v-model="form.language_code" class="select" name="language_code">
            <option v-for="country in countries" :key="country" :value="country.code">
              {{ country.name }}
            </option>
          </select>
        </div>
      </div>
      <div class="drawer-footer">
        <div class="flex justify-between gap-2">
          <button type="button" class="btn btn-secondary w-full" data-dismiss="drawer">
            <span> {{ trans('Close') }}</span>
          </button>
          <SpinnerBtn classes="btn btn-primary w-full" :processing="form.processing" :btn-text="trans('Create')" />
        </div>
      </div>
    </form>
  </div>
</template>
