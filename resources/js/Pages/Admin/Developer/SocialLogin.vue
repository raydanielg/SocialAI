<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import SpinnerBtn from '@/Components/SpinnerBtn.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import { useForm } from '@inertiajs/vue3'
import trans from '@/Composables/transComposable'
defineOptions({ layout: AdminLayout })
const props = defineProps([
  'segments',
  'buttons',
  'id',
  'GOOGLE_CLIENT_ID',
  'GOOGLE_CLIENT_SECRET',
  'GOOGLE_REDIRECT_URL',
  'FACEBOOK_APP_ID',
  'FACEBOOK_APP_SECRET',
  'FACEBOOK_REDIRECT_URI'
])

const form = useForm({
  GOOGLE_CLIENT_ID: props.GOOGLE_CLIENT_ID,
  GOOGLE_CLIENT_SECRET: props.GOOGLE_CLIENT_SECRET,
  GOOGLE_REDIRECT_URL: props.GOOGLE_REDIRECT_URL,
  FACEBOOK_APP_ID: props.FACEBOOK_APP_ID,
  FACEBOOK_APP_SECRET: props.FACEBOOK_APP_SECRET,
  FACEBOOK_REDIRECT_URI: props.FACEBOOK_REDIRECT_URI
})

function update() {
  const url = route('admin.developer-settings.update', props.id)
  form.put(url)
}
</script>

<template>
  <main class="container p-4 sm:p-6">
    <PageHeader
      :title="trans('Social Login Developer Settings')"
      :segments="segments"
      :buttons="buttons"
    />
    <div class="space-y-6">
      <div class="grid grid-cols-1 lg:grid-cols-12">
        <div class="lg:col-span-5">
          <strong>{{ trans('Social Login Developer Settings') }}</strong>
          <p>{{ trans('Edit you application Social Login Api settings') }}</p>
        </div>
        <div class="lg:col-span-7">
          <form @submit.prevent="update">
            <div class="card">
              <div class="card-body">
                <h6>Google Api</h6>
                <div class="mb-2">
                  <label class="label">{{ trans('Google Client ID') }}</label>
                  <input type="text" v-model="form.GOOGLE_CLIENT_ID" class="input" />
                </div>
                <div class="mb-2">
                  <label class="label">{{ trans('Google Client Secret') }}</label>
                  <input type="text" v-model="form.GOOGLE_CLIENT_SECRET" class="input" />
                </div>
                <div class="mb-2">
                  <label class="label">{{ trans('Google Redirect Url') }}</label>

                  <input type="text" :value="GOOGLE_REDIRECT_URL" disabled class="input" />
                </div>

                <div class="mt-3">
                  <SpinnerBtn :processing="form.processing" :btn-text="trans('Save Changes')" />
                </div>
              </div>
            </div>
            <div class="card mt-5">
              <div class="card-body">
                <h6>Facebook Graph Api</h6>
                <div class="mb-2">
                  <label class="label">{{ trans('Facebook Client Id') }}</label>
                  <input type="text" v-model="form.FACEBOOK_APP_ID" class="input" />
                </div>
                <div class="mb-2">
                  <label class="label">{{ trans('Facebook Client Secret') }}</label>
                  <input type="text" v-model="form.FACEBOOK_APP_SECRET" class="input" />
                </div>
                <div class="mb-2">
                  <label class="label">{{ trans('Facebook Redirect Url') }}</label>
                  <input type="text" :value="FACEBOOK_REDIRECT_URI" disabled class="input" />
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
