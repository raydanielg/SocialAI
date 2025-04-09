<template>
  <main class="sm:p6 container flex-grow p-4">
    <PageHeader title="Edit Language" :buttons="buttons" />
    <div class="space-y-6">
      <form @submit.prevent="updateLanguage" method="post">
        <div class="table-responsive whitespace-nowrap rounded-primary">
          <table class="table">
            <thead>
              <tr>
                <th class="col-6">{{ trans('Translation Key') }}</th>
                <th class="col-6">{{ trans('Translated Value') }}</th>
              </tr>
            </thead>

            <tbody>
              <tr v-for="(value, key) in posts" :key="key">
                <td>
                  {{ key }}
                </td>
                <td>
                  <input type="text" class="input" v-model="posts[key]" />
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="card-footer">
          <SpinnerBtn :btn-text="trans('Save Changes')" :processing="isProccessing" />
        </div>
      </form>
    </div>
  </main>

  <div id="addNewLanguageKeyDrawer" class="drawer drawer-right">
    <form @submit.prevent="createKey()">
      <div class="drawer-header">
        <h5>{{ trans('Add New Language') }}</h5>
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
          <label>{{ trans('Key') }}</label>
          <input type="text" name="key" v-model="form.key" class="input" required />
        </div>
        <div class="mb-2">
          <label>{{ trans('Value') }}</label>
          <input type="text" name="value" v-model="form.value" class="input" required />
        </div>
      </div>
      <div class="drawer-footer">
        <div class="flex justify-between gap-2">
          <button type="button" class="btn btn-secondary w-full" data-dismiss="drawer">
            <span> {{ trans('Close') }}</span>
          </button>
          <SpinnerBtn
            classes="btn btn-primary w-full"
            :processing="form.processing"
            :btn-text="trans('Create')"
          />
        </div>
      </div>
    </form>
  </div>
</template>

<script setup>
import {
  onMounted,
  ref,
} from "vue";

import SpinnerBtn from "@/Components/Admin/SpinnerBtn.vue";
import toast from "@/Composables/toastComposable";
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import PageHeader from "@/Layouts/Admin/PageHeader.vue";
import drawer from "@/Plugins/Admin/drawer";
import {
  router,
  useForm,
} from "@inertiajs/vue3";

defineOptions({ layout: AdminLayout })

onMounted(() => {
  drawer.init()
})

const props = defineProps(['posts', 'id', 'buttons', 'segments'])

const form = useForm({
  key: '',
  value: '',
  id: props.id
})

const createKey = () => {
  form.post('/admin/language/addkey', {
    onSuccess: () => {
      form.reset()
      toast.success(trans('Language key has been added successfully'))
      drawer.of('#addNewLanguageKeyDrawer').hide()
    }
  })
}

const isProccessing = ref(false)

const updateLanguage = () => {
  isProccessing.value = true
  router.patch(
    route('admin.language.update', props.id),
    {
      values: props.posts
    },
    {
      onSuccess: () => {
        form.reset()
        isProccessing.value = false
        toast.success(trans('Language key has been added successfully'))
      }
    }
  )
}
</script>
