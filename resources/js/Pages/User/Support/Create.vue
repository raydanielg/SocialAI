<script setup>
import InputFieldError from '@/Components/InputFieldError.vue'
import UserLayout from '@/Layouts/User/UserLayout.vue'
import notify from '@/Composables/toastComposable'
import { Head, useForm } from '@inertiajs/vue3'
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
defineOptions({ layout: UserLayout })

const form = useForm({
  subject: '',
  message: ''
})

const submit = () => {
  form.post(route('user.supports.store'), {
    onSuccess: () => {
      notify.success('Updated Successfully')
    }
  })
}
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader title="Support" :buttons="buttons" />
    <div class="space-y-6">
      <div class="card card-body mx-auto max-w-3xl">
        <h4 class="mb-4">{{ trans('Create Ticket') }}</h4>
        <form @submit.prevent="submit">
          <div class="mb-2">
            <label class="label mb-2">{{ trans('Subject') }}*</label>
            <input type="text" class="input" placeholder="Subject" v-model="form.subject" />
            <InputFieldError :message="form.errors.subject" />
          </div>

          <div class="mb-2">
            <label class="label mb-2">{{ trans('Message') }}*</label>
            <textarea
              required
              v-model="form.message"
              class="textarea"
              placeholder="Write message...."
            ></textarea>
            <InputFieldError :message="form.errors.message" />
          </div>
          <div class="button-group d-inline-flex align-items-center mt-30">
            <SpinnerBtn
              type="submit"
              classes="btn btn-primary"
              :processing="form.processing"
              btn-text="Submit"
            />
          </div>
        </form>
      </div>
    </div>
  </main>
</template>
