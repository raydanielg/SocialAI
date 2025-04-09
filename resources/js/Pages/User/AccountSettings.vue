<script setup>
import { computed, ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import InputFieldError from '@/Components/InputFieldError.vue'
import UserLayout from '@/Layouts/User/UserLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import SpinnerBtn from '@/Components/SpinnerBtn.vue'

defineOptions({ layout: UserLayout })

const props = defineProps(['user'])
const avatarPreview = computed(() => {
  if (form.avatar) {
    return URL.createObjectURL(form.avatar)
  }
  return props.user.avatar ? props.user.avatar : 'https://ui-avatars.com/api/?name=' + props.user.name
})

const form = useForm({
  avatar: null,
  name: props.user.name,
  email: props.user.email,
  phone: props.user.phone,
  current_password: '',
  _method: 'put'
})

const submit = () => {
  form.post(route('user.account-settings.update'))
}
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader />
    <div class="space-y-6">
      <div class="card mx-auto max-w-3xl p-5">
        <h4 class="mb-4">{{ trans('Edit Profile') }}</h4>
        <form @submit.prevent="submit" class="space-y-1">

          <div class="flex items-center gap-3">
            <img :src="avatarPreview" class="h-20 w-20 rounded-full border border-gray-300" />
            <div>
              <label class="label mb-1">{{ trans('Avatar') }}</label>
              <input class="input" type="file" @input="form.avatar = $event.target.files[0]" />
              <InputFieldError :message="form.errors.avatar" />
            </div>
          </div>

          <div>
            <label class="label mb-1">{{ trans('Name') }}</label>
            <input class="input" type="text" v-model="form.name" placeholder="Zubayer" />
            <InputFieldError :message="form.errors.name" />
          </div>
          <div>
            <label class="label mb-1">{{ trans('Phone Number') }}</label>
            <input class="input" type="tel" v-model="form.phone" placeholder="+810 989 989 989" />
            <InputFieldError :message="form.errors.phone" />
          </div>
          <template v-if="!props.user.provider && !props.user.provider_id">
            <div>
              <label class="label mb-1">{{ trans('Email') }}</label>
              <input class="input" type="email" v-model="form.email" placeholder="zubayerhasan@gmal.com" />
              <InputFieldError :message="form.errors.email" />
            </div>
            <div>
              <label class="label mb-1">{{ trans('Current Password') }}</label>
              <input class="input" type="password" v-model="form.current_password"
                placeholder="enter your current password" />

              <InputFieldError :message="form.errors.current_password" />

              <div class="mt-3 text-sm">
                {{ trans('Want to change the password?') }}
                <Link :href="route('user.change-password')" class="font-medium text-primary-800">
                {{ trans('Click here') }}</Link>
              </div>
            </div>
          </template>
          <SpinnerBtn type="submit" :processing="form.processing" class="btn btn-primary mb-4 mt-6"
            :btn-text="trans('Update Information')" />
        </form>
      </div>
    </div>
  </main>
</template>
