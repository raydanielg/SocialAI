<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader :title="trans('Edit Customers')" :buttons="buttons" />
    <div class="space-y-6">
      <div class="flex">
        <div class="mt-5 flex-1">
          <strong>{{ trans('Edit User') }}</strong>
          <p>{{ trans('Edit user profile information') }}</p>
        </div>

        <div class="mt-5 flex-1">
          <form @submit.prevent="submit">
            <div class="card">
              <div class="card-body">
                <div class="mt-2">
                  <label>{{ trans('Name') }}</label>
                  <input type="text" name="name" required="" class="input" :value="form.name" />
                </div>
                <div class="mt-2">
                  <label>{{ trans('Email') }}</label>
                  <input type="email" name="email" required="" class="input" :value="form.email" />
                </div>
                <div class="mt-2">
                  <label>{{ trans('Phone') }}</label>
                  <input type="text" name="phone" class="input" :value="form.phone" />
                </div>
                <div class="mt-2">
                  <label>{{ trans('Address') }}</label>
                  <input type="text" name="address" class="input" :value="form.address" />
                </div>
                <div class="mt-2">
                  <label>{{ trans('New Password') }}</label>
                  <input type="text" name="password" class="input" value="" />
                </div>
                <div class="mt-2">
                  <label>{{ trans('Status') }}</label>
                  <select class="select" name="status">
                    <option value="1" :selected="form.status == 1">{{ trans('Active') }}</option>
                    <option value="0" :selected="form.status == 0">{{ trans('Deactive') }}</option>
                  </select>
                </div>
                <div class="mt-2">
                  <SpinnerBtn
                    classes="btn btn-primary"
                    :processing="form.processing"
                    :btn-text="trans('Save Changes')"
                  />
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import { useForm } from '@inertiajs/vue3'
import notify from '@/Composables/toastComposable'
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
export default {
  layout: AdminLayout
}
</script>

<script setup>
import PageHeader from '@/Layouts/Admin/PageHeader.vue'

const props = defineProps(['customer', 'segments', 'buttons'])

const form = useForm({
  ...props.customer
})

const submit = () => {
  let actionUrl = route('admin.customer.update', { id: props.customer.id })
  form.put(actionUrl, {
    onSuccess: () => {
      notify.success('Customer has been updated successfully')
    }
  })
}
</script>
