<script setup>
import ImageInput from '@/Components/Admin/ImageInput.vue'
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import notify from '@/Composables/toastComposable'
import { Head, useForm } from '@inertiajs/vue3'

defineOptions({ layout: AdminLayout })
const props = defineProps([
  'buttons',
  'id',
  'FACEBOOK_APP_ID',
  'FACEBOOK_APP_SECRET',
  'FACEBOOK_REDIRECT_URI',
  'INSTAGRAM_APP_ID',
  'INSTAGRAM_APP_SECRET',
  'INSTAGRAM_REDIRECT_URI',

  'TWITTER_API_KEY',
  'TWITTER_API_KEY_SECRET',
  'TWITTER_ACCESS_TOKEN',
  'TWITTER_ACCESS_TOKEN_SECRET',
  'TWITTER_CLIENT_ID',
  'TWITTER_CLIENT_SECRET',
  'TWITTER_REDIRECT_URI',

  'LINKEDIN_APP_ID',
  'LINKEDIN_APP_SECRET',
  'LINKEDIN_REDIRECT_URI',
  'TIKTOK_APP_ID',
  'TIKTOK_APP_KEY',
  'TIKTOK_APP_SECRET',
  'TIKTOK_REDIRECT_URI'
])

const form = useForm({
  FACEBOOK_APP_ID: props.FACEBOOK_APP_ID,
  FACEBOOK_APP_SECRET: props.FACEBOOK_APP_SECRET,
  FACEBOOK_REDIRECT_URI: props.FACEBOOK_REDIRECT_URI,
  INSTAGRAM_APP_ID: props.INSTAGRAM_APP_ID,
  INSTAGRAM_APP_SECRET: props.INSTAGRAM_APP_SECRET,
  INSTAGRAM_REDIRECT_URI: props.INSTAGRAM_REDIRECT_URI,

  TWITTER_API_KEY: props.TWITTER_API_KEY,
  TWITTER_API_KEY_SECRET: props.TWITTER_API_KEY_SECRET,
  TWITTER_ACCESS_TOKEN: props.TWITTER_ACCESS_TOKEN,
  TWITTER_ACCESS_TOKEN_SECRET: props.TWITTER_ACCESS_TOKEN_SECRET,
  TWITTER_CLIENT_ID: props.TWITTER_CLIENT_ID,
  TWITTER_CLIENT_SECRET: props.TWITTER_CLIENT_SECRET,
  TWITTER_REDIRECT_URI: props.TWITTER_REDIRECT_URI,

  LINKEDIN_APP_ID: props.LINKEDIN_APP_ID,
  LINKEDIN_APP_SECRET: props.LINKEDIN_APP_SECRET,
  LINKEDIN_REDIRECT_URI: props.LINKEDIN_REDIRECT_URI,
  TIKTOK_APP_ID: props.TIKTOK_APP_ID,
  TIKTOK_APP_KEY: props.TIKTOK_APP_KEY,
  TIKTOK_APP_SECRET: props.TIKTOK_APP_SECRET,
  TIKTOK_REDIRECT_URI: props.TIKTOK_REDIRECT_URI,
  tiktok_verification_file: '',
  _method: 'PUT'
})

function update() {
  const url = route('admin.developer-settings.update', props.id)
  form.post(url)
}
</script>
<template>
  <main class="container p-4 sm:p-6">
    <Head title="Platform Settings" />
    <PageHeader :title="trans('Social Platform APIs Settings')" :buttons="buttons" />
    <div class="space-y-6">
      <div class="grid grid-cols-1 lg:grid-cols-12">
        <div class="lg:col-span-5">
          <strong>{{ trans('Social Platform APIs Settings') }}</strong>
          <p>{{ trans('Edit The Social Platform APIs Here') }}</p>
        </div>
        <div class="lg:col-span-7">
          <form @submit.prevent="update">
            <div class="card mb-5">
              <div class="card-body">
                <h6 class="card-title">{{ trans('Facebook') }}</h6>
                <div class="mb-2">
                  <label>FACEBOOK APP ID</label>
                  <input type="text" class="input mt-1" v-model="form.FACEBOOK_APP_ID" />
                </div>
                <div class="mb-2">
                  <label>FACEBOOK APP SECRET</label>
                  <input type="text" class="input mt-1" v-model="form.FACEBOOK_APP_SECRET" />
                </div>
                <div class="mb-2">
                  <label>FACEBOOK REDIRECT URI</label>
                  <input
                    type="text"
                    class="input mt-1"
                    disabled
                    v-model="form.FACEBOOK_REDIRECT_URI"
                  />
                </div>

                <div class="mb-2">
                  <SpinnerBtn :processing="form.processing" :btn-text="trans('Save Changes')" />
                </div>
              </div>
            </div>

            <div class="card mb-5">
              <div class="card-body">
                <h6 class="card-title">{{ trans('Instagram') }}</h6>
                <div class="mb-2">
                  <label>INSTAGRAM APP ID</label>
                  <input type="text" class="input mt-1" v-model="form.INSTAGRAM_APP_ID" />
                </div>
                <div class="mb-2">
                  <label>INSTAGRAM APP SECRET</label>
                  <input type="text" class="input mt-1" v-model="form.INSTAGRAM_APP_SECRET" />
                </div>
                <div class="mb-2">
                  <label>INSTAGRAM REDIRECT URI</label>
                  <input
                    type="text"
                    class="input mt-1"
                    disabled
                    v-model="form.INSTAGRAM_REDIRECT_URI"
                  />
                </div>

                <div class="mb-2">
                  <SpinnerBtn :processing="form.processing" :btn-text="trans('Save Changes')" />
                </div>
              </div>
            </div>
            <div class="card mb-5">
              <div class="card-body">
                <h6 class="card-title">{{ trans('Twitter') }}</h6>

                <div class="mb-2">
                  <label>TWITTER API KEY</label>
                  <input type="text" class="input mt-1" v-model="form.TWITTER_API_KEY" />
                </div>
                <div class="mb-2">
                  <label>TWITTER API SECRET</label>
                  <input type="text" class="input mt-1" v-model="form.TWITTER_API_KEY_SECRET" />
                </div>
                <div class="mb-2">
                  <label>TWITTER ACCESS TOKEN</label>
                  <input type="text" class="input mt-1" v-model="form.TWITTER_ACCESS_TOKEN" />
                </div>
                <div class="mb-2">
                  <label>TWITTER ACCESS TOKEN SECRET</label>
                  <input
                    type="text"
                    class="input mt-1"
                    v-model="form.TWITTER_ACCESS_TOKEN_SECRET"
                  />
                </div>

                <div class="mb-2">
                  <label>TWITTER CLIENT ID</label>
                  <input type="text" class="input mt-1" v-model="form.TWITTER_CLIENT_ID" />
                </div>
                <div class="mb-2">
                  <label>TWITTER CLIENT SECRET</label>
                  <input type="text" class="input mt-1" v-model="form.TWITTER_CLIENT_SECRET" />
                </div>

                <div class="mb-2">
                  <label>TWITTER REDIRECT URI</label>
                  <input
                    type="text"
                    class="input mt-1"
                    disabled
                    v-model="form.TWITTER_REDIRECT_URI"
                  />
                </div>
                <div class="mb-2">
                  <SpinnerBtn :processing="form.processing" :btn-text="trans('Save Changes')" />
                </div>
              </div>
            </div>

            <div class="card mb-5">
              <div class="card-body">
                <h6 class="card-title">{{ trans('Linkedin') }}</h6>
                <div class="mb-2">
                  <label>LINKEDIN APP ID</label>
                  <input type="text" class="input mt-1" v-model="form.LINKEDIN_APP_ID" />
                </div>
                <div class="mb-2">
                  <label>LINKEDIN APP SECRET</label>
                  <input type="text" class="input mt-1" v-model="form.LINKEDIN_APP_SECRET" />
                </div>
                <div class="mb-2">
                  <label>LINKEDIN REDIRECT URI</label>
                  <input
                    type="text"
                    class="input mt-1"
                    disabled
                    v-model="form.LINKEDIN_REDIRECT_URI"
                  />
                </div>

                <div class="mb-2">
                  <SpinnerBtn :processing="form.processing" :btn-text="trans('Save Changes')" />
                </div>
              </div>
            </div>
            <div class="card mb-5">
              <div class="card-body">
                <h6 class="card-title">{{ trans('Tiktok') }}</h6>
                <div class="mb-2">
                  <label>TIKTOK APP ID</label>
                  <input type="text" class="input mt-1" v-model="form.TIKTOK_APP_ID" />
                </div>
                <div class="mb-2">
                  <label>TIKTOK APP KEY</label>
                  <input type="text" class="input mt-1" v-model="form.TIKTOK_APP_KEY" />
                </div>
                <div class="mb-2">
                  <label>TIKTOK APP SECRET</label>
                  <input type="text" class="input mt-1" v-model="form.TIKTOK_APP_SECRET" />
                </div>
                <div class="mb-2">
                  <label>TIKTOK REDIRECT URI</label>
                  <input
                    type="text"
                    class="input mt-1"
                    disabled
                    v-model="form.TIKTOK_REDIRECT_URI"
                  />
                </div>

                <div class="mb-2">
                  <label class="label"> {{ trans('URL Properties Verification File') }}</label>
                  <input
                    type="file"
                    @change="(e) => (form.tiktok_verification_file = e.target.files[0])"
                    class="input"
                  />
                </div>

                <div class="mb-2">
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
