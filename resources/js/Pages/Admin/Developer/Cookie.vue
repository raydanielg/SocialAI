<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
import { useForm } from '@inertiajs/vue3'

defineOptions({ layout: AdminLayout })
const props = defineProps(['segments', 'id', 'COOKIE_CONSENT', 'cookieData'])

const form = useForm({
  COOKIE_CONSENT: props.COOKIE_CONSENT,
  cookieData: props.cookieData
})

function update() {
  form.put(route('admin.developer-settings.update', props.id))
}
</script>
<template>
  <main class="container p-4 sm:p-6">
    <PageHeader :title="trans('Cookie Settings')" />
    <div class="space-y-6">
      <div class="grid grid-cols-1 lg:grid-cols-12">
        <div class="lg:col-span-5">
          <strong>{{ trans('Cookie Settings') }}</strong>
          <p>{{ trans('Edit cookie settings') }}</p>
        </div>
        <div class="lg:col-span-7">
          <form @submit.prevent="update">
            <div class="card">
              <div class="card-body">
                <div class="mb-2">
                  <label class="label mb-1">{{ trans('Cookie Permission') }}</label>
                  <select class="select" v-model="form.COOKIE_CONSENT">
                    <option :value="true">{{ trans('Enable') }}</option>
                    <option :value="false">{{ trans('Disable') }}</option>
                  </select>
                </div>
                <div class="mb-2">
                  <label class="label mb-1">{{ trans('Title') }}</label>
                  <input type="text" v-model="form.cookieData.title" required class="input" />
                </div>
                <div class="mb-2">
                  <label class="label mb-1">{{ trans('Intro') }}</label>
                  <textarea v-model="form.cookieData.intro" required class="textarea"></textarea>
                </div>
                <div class="mb-2">
                  <label class="label mb-1">{{ trans('Essentials btn text') }}</label>
                  <input type="text" v-model="form.cookieData.essentials" required class="input" />
                </div>
                <div class="mb-2">
                  <label class="label mb-1">{{ trans('Accept all btn text') }}</label>
                  <input type="text" v-model="form.cookieData.all" required class="input" />
                </div>
                <div class="mt-3">
                  <SpinnerBtn :processing="form.processing" :btn-text="trans('Save Changes')" />
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
</template>
