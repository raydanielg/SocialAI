<script setup>
import InputFieldError from '@/Components/InputFieldError.vue'
import { useForm } from '@inertiajs/vue3'

import UserLayout from '@/Layouts/User/UserLayout.vue'
import notify from '@/Composables/toastComposable'
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'

import PageHeader from '@/Layouts/Admin/PageHeader.vue'
defineOptions({ layout: UserLayout })
const props = defineProps(['segments'])
const form = useForm({
  current_password: '',
  new_password: '',
  new_password_confirmation: ''
})

const submit = () => {
  form.put(route('user.update-password'), {
    onSuccess: () => {
      notify.success(trans('password has been updated successfully'))
      form.reset()
    }
  })
}
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader title="Change Password" :buttons="[]" />
    <div class="card card-body mx-auto max-w-3xl">
      <h4 class="mb-4">{{ trans('Change Password') }}</h4>
      <form @submit.prevent="submit" class="space-y-6">
        <div>
          <label class="label mb-1"> {{ trans('Old Password') }} *</label>
          <input class="input" type="password" v-model="form.current_password" />
          <InputFieldError :message="form.errors.current_password" />
        </div>

        <div>
          <label class="label mb-1"> {{ trans('New Password') }} *</label>
          <input class="input" type="password" v-model="form.new_password" />
          <InputFieldError :message="form.errors.new_password" />
        </div>

        <div>
          <label class="label mb-1">{{ trans('Confirm Password') }} *</label>
          <input class="input" type="password" v-model="form.new_password_confirmation" />
          <InputFieldError :message="form.errors.new_password_confirmation" />
        </div>

        <div class="flex items-center gap-3">
          <SpinnerBtn
            :processing="form.processing"
            classes="btn btn-primary"
            :btn-text="trans('Change Password')"
          />
          <Link :href="route('user.account-settings')" class="btn btn-danger">
            {{ trans('Cancel') }}
          </Link>
        </div>
      </form>
    </div>
  </main>
</template>
