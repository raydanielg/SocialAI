<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import { useForm } from '@inertiajs/vue3'

import toast from '@/Composables/toastComposable'
defineOptions({ layout: AdminLayout })
const props = defineProps(['segments', 'buttons'])

const form = useForm({
  title: null,
  description: null,
  days: 30,
  price: null,
  plan_data: {
    credits: { value: 0, overview: '' },
    brands: { value: 0, overview: '' },
    social_accounts: { value: 0, overview: '' },
    posts: { value: 0, overview: '' },
    storage_size: { value: 0, overview: '' },
    analytics: { value: false, overview: '' },
    stock_library: { value: false, overview: '' },
    scheduling: { value: false, overview: '' },
    image_editor: { value: false, overview: '' },
    stock_content: false
  },
  is_featured: false,
  is_recommended: false,
  is_trial: false,
  status: true,
  trial_days: 0
})

function update() {
  form.post(route('admin.plan.store'), {
    onSuccess: () => {
      toast.success('Plan created successfully')
    }
  })
}
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader :title="trans('Create Plan')" :buttons="buttons" />
    <div class="space-y-6">
      <div>
        <strong>{{ trans('Create Plan') }}</strong>
        <p>{{ trans('Create subscription plan for charging from the customer') }}</p>
      </div>

      <form class="flex flex-col-reverse items-start gap-8 lg:flex-row" @submit.prevent="update()">
        <div class="card card-body flex-1">
          <strong>{{ trans('Plan Details') }}</strong>
          <div class="my-2">
            <label>{{ trans('Plan Name') }}</label>
            <input type="text" name="title" required="" class="input" v-model="form.title" />
          </div>
          <div class="my-2">
            <label>{{ trans('Plan Description') }}</label>
            <textarea v-model="form.description" required class="textarea" />
          </div>
          <div class="my-2">
            <label>{{ trans('Select Duration') }}</label>
            <select class="select" name="days" v-model="form.days">
              <option value="30">{{ trans('Monthly') }}</option>
              <option value="365">{{ trans('yearly') }}</option>
              <option value="999999">{{ trans('Lifetime') }}</option>
            </select>
          </div>
          <div class="my-2">
            <label>{{ trans('Price') }}</label>
            <input
              type="number"
              name="price"
              v-model="form.price"
              step="any"
              required=""
              class="input"
            />
          </div>

          <div class="mb-2">
            <label for="toggle-featured" class="toggle toggle-sm">
              <input
                v-model="form.is_featured"
                class="toggle-input peer sr-only"
                id="toggle-featured"
                type="checkbox"
              />
              <div class="toggle-body"></div>
              <span class="label label-md">{{ trans('Featured in home page?') }}</span>
            </label>
          </div>
          <div class="mb-2">
            <label for="toggle-is_recommended" class="toggle toggle-sm">
              <input
                v-model="form.is_recommended"
                class="toggle-input peer sr-only"
                id="toggle-is_recommended"
                type="checkbox"
              />
              <div class="toggle-body"></div>
              <span class="label label-md">{{ trans('Is recommended?') }}</span>
            </label>
          </div>

          <div class="mb-2">
            <label for="toggle-is_trial" class="toggle toggle-sm">
              <input
                v-model="form.is_trial"
                class="toggle-input peer sr-only"
                id="toggle-is_trial"
                type="checkbox"
              />
              <div class="toggle-body"></div>
              <span class="label label-md">{{ trans('Accept Trial?') }}</span>
            </label>
          </div>
          <template v-if="form.is_trial">
            <div class="from-group trial-days mb-2 mt-2">
              <label class="col-lg-12">{{ trans('Trial days') }}</label>
              <div class="col-lg-12">
                <input
                  type="number"
                  v-model="form.trial_days"
                  name="trial_days"
                  class="input"
                  required
                />
              </div>
            </div>
           
          </template>
          <div class="mb-2">
            <label for="toggle-status" class="toggle toggle-sm">
              <input
                v-model="form.status"
                class="toggle-input peer sr-only"
                id="toggle-status"
                type="checkbox"
              />
              <div class="toggle-body"></div>
              <span class="label label-md">{{ trans('Activate This Plan?') }}</span>
            </label>
          </div>
          <div class="mb-2">
              <label for="toggle-stock_content" class="toggle toggle-sm">
                <input
                  v-model="form.plan_data.stock_content"
                  class="toggle-input peer sr-only"
                  id="toggle-stock_content"
                  type="checkbox"
                />
                <div class="toggle-body"></div>
                <span class="label label-md">{{ trans('Stock Content?') }}</span>
              </label>
            </div>
          <div class="mt-6">
            <SpinnerBtn classes="btn btn-primary" :processing="form.processing" btn-text="Create" />
          </div>
        </div>

        <div class="card card-body flex-1 space-y-2">
          <strong>{{ trans('Plan Perks') }}</strong>
          <div class="my-2">
            <label class="label mb-1">{{ trans('Ai Credits') }}</label>
            <input type="number" v-model="form.plan_data.credits.value" required class="input" />
            <label class="label mb-1">{{ trans('Overview') }}</label>
            <textarea v-model="form.plan_data.credits.overview" required class="input" />
          </div>
          <div class="my-2">
            <label class="label mb-1">{{ trans('Brands') }}</label>
            <input type="number" v-model="form.plan_data.brands.value" required class="input" />
            <label class="label mb-1">{{ trans('Overview') }}</label>
            <textarea v-model="form.plan_data.brands.overview" required class="input" />
          </div>
          <div class="my-2">
            <label class="label mb-1">{{ trans('Social Accounts') }}</label>
            <input
              type="number"
              v-model="form.plan_data.social_accounts.value"
              required
              class="input"
            />
            <label class="label mb-1">{{ trans('Overview') }}</label>
            <textarea v-model="form.plan_data.social_accounts.overview" required class="input" />
          </div>
          <div class="my-2">
            <label class="label mb-1">{{ trans('Posts') }}</label>
            <input type="number" v-model="form.plan_data.posts.value" required class="input" />
            <label class="label mb-1">{{ trans('Overview') }}</label>
            <textarea v-model="form.plan_data.posts.overview" required class="input" />
          </div>
          <div class="my-2">
            <label class="label mb-1">{{ trans('Storage Size') }}</label>
            <input
              type="number"
              v-model="form.plan_data.storage_size.value"
              required
              class="input"
            />
            <label class="label mb-1">{{ trans('Overview') }}</label>
            <textarea v-model="form.plan_data.storage_size.overview" required class="input" />
          </div>
          <div class="my-2">
            <label for="toggle-analytics" class="toggle toggle-sm">
              <input
                v-model="form.plan_data.analytics.value"
                class="toggle-input peer sr-only"
                id="toggle-analytics"
                type="checkbox"
              />
              <div class="toggle-body"></div>
              <span class="label label-md">{{ trans('Analytics?') }}</span>
            </label>
            <label class="label mb-1 block">{{ trans('Overview') }}</label>
            <textarea v-model="form.plan_data.analytics.overview" required class="input" />
          </div>
          <div class="my-2">
            <label for="toggle-stock_library" class="toggle toggle-sm">
              <input
                v-model="form.plan_data.stock_library.value"
                class="toggle-input peer sr-only"
                id="toggle-stock_library"
                type="checkbox"
              />
              <div class="toggle-body"></div>
              <span class="label label-md">{{ trans('Stock Library?') }}</span>
            </label>
            <label class="label mb-1 block">{{ trans('Overview') }}</label>
            <textarea v-model="form.plan_data.stock_library.overview" required class="input" />
          </div>
          <div class="my-2">
            <label for="toggle-scheduling" class="toggle toggle-sm">
              <input
                v-model="form.plan_data.scheduling.value"
                class="toggle-input peer sr-only"
                id="toggle-scheduling"
                type="checkbox"
              />
              <div class="toggle-body"></div>
              <span class="label label-md">{{ trans('Scheduling/Calender?') }}</span>
            </label>
            <label class="label mb-1 block">{{ trans('Overview') }}</label>
            <textarea v-model="form.plan_data.scheduling.overview" required class="input" />
          </div>
          <div class="my-2">
            <label for="toggle-image_editor" class="toggle toggle-sm">
              <input
                v-model="form.plan_data.image_editor.value"
                class="toggle-input peer sr-only"
                id="toggle-image_editor"
                type="checkbox"
              />
              <div class="toggle-body"></div>
              <span class="label label-md">{{ trans('Image Editor?') }}</span>
            </label>
            <label class="label mb-1 block">{{ trans('Overview') }}</label>
            <textarea v-model="form.plan_data.image_editor.overview" required class="input" />
          </div>
        </div>
      </form>
    </div>
  </main>
</template>
